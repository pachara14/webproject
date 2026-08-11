<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Carbon\Carbon;
use Exception;
use OpenApi\Attributes as OA;

class AuthController extends Controller
{
    // ===================================================================
    // Helper Methods
    // ===================================================================

    /** ดึงรหัสนักศึกษาจากอีเมลมหาวิทยาลัย เช่น 1651010541126@rmutr.ac.th → "1651010541126" */
    private function studentIdFromUniversityEmail(string $email): ?string
    {
        $studentId = strstr($email, '@', true);
        return $studentId !== false && ctype_digit($studentId) ? $studentId : null;
    }

    /** แปลง Google Avatar URL ให้ได้ขนาดที่ต้องการ (default 400px) */
    private function getGoogleAvatar(string $avatarUrl, int $size = 400): string
    {
        // Google avatar URL มีรูปแบบ: ...=s96-c หรือ ...=s96
        // แทนที่ขนาดเดิมด้วยขนาดที่ต้องการ
        return preg_replace('/=s\d+(-c)?$/', "=s{$size}-c", $avatarUrl);
    }

    // ===================================================================
    // Web Auth (Session-based)
    // ===================================================================

    /** เข้าสู่ระบบจากหน้าเว็บ และสร้าง session ให้ผู้ใช้ */
    public function webLogin(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!str_ends_with(strtolower($credentials['email']), '@rmutr.ac.th')) {
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'กรุณาใช้อีเมลของมหาวิทยาลัย (@rmutr.ac.th) เท่านั้น']);
        }

        if (!Auth::attempt($credentials)) {
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'อีเมลหรือรหัสผ่านไม่ถูกต้อง']);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    /** สมัครสมาชิกจากหน้าเว็บ */
    public function register(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'email'      => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'   => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!str_ends_with(strtolower($data['email']), '@rmutr.ac.th')) {
            return back()->withInput($request->except('password', 'password_confirmation'))
                ->withErrors(['email' => 'กรุณาใช้อีเมลของมหาวิทยาลัย (@rmutr.ac.th) เท่านั้น']);
        }

        $userId = DB::table('users')->insertGetId([
            'students_id'   => $this->studentIdFromUniversityEmail($data['email']),
            'first_name'    => $data['first_name'],
            'last_name'     => $data['last_name'],
            'email'         => strtolower($data['email']),
            'role'          => 'user',
            'password'      => Hash::make($data['password']),
            'profile_image' => null, // ยังไม่มีรูป ตั้งเป็น null ไว้ก่อน
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);

        $user = User::findOrFail($userId);
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    /** ออกจากระบบหน้าเว็บและล้าง session ปัจจุบัน */
    public function webLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /** Google OAuth Redirect (Web) */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /** Google OAuth Callback (Web) */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $email      = $googleUser->getEmail();

            if (!str_ends_with($email, '@rmutr.ac.th')) {
                return redirect('/')->with('error', 'กรุณาใช้อีเมล @rmutr.ac.th');
            }

            // รูป Google ขนาด 400px
            $avatar = $this->getGoogleAvatar($googleUser->getAvatar());

            $user = User::where('email', $email)->first();

            if (!$user) {
                $name   = explode(' ', $googleUser->getName(), 2);
                $userId = DB::table('users')->insertGetId([
                    'students_id'   => $this->studentIdFromUniversityEmail($email),
                    'first_name'    => $name[0] ?? '',
                    'last_name'     => $name[1] ?? '',
                    'email'         => $email,
                    'google_id'     => $googleUser->getId(),
                    'profile_image' => $avatar,
                    'role'          => 'user',
                    'password'      => bcrypt(uniqid()),
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ]);
                $user = User::findOrFail($userId);
            } else {
                DB::table('users')->where('id', $user->id)->update([
                    'students_id'   => $this->studentIdFromUniversityEmail($email),
                    'google_id'     => $googleUser->getId(),
                    'profile_image' => $avatar,
                    'updated_at'    => Carbon::now(),
                ]);
                $user = User::findOrFail($user->id);
            }

            Auth::login($user);

            return redirect()->route('dashboard');
        } catch (Exception $e) {
            return redirect('/')->with('error', $e->getMessage());
        }
    }

    // ===================================================================
    // API Auth (Token-based / Sanctum)
    // ===================================================================

    /**
     * 1. API เข้าสู่ระบบด้วย Email + Password
     *    - ส่ง profile_image จาก DB กลับไปด้วย (null ถ้าไม่มี)
     */
    #[OA\Post(
        path: '/api/login',
        summary: 'เข้าสู่ระบบด้วย Email และ Password',
        tags: ['Auth'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['email', 'password'],
                properties: [
                    new OA\Property(property: 'email', type: 'string', example: 'user@rmutr.ac.th'),
                    new OA\Property(property: 'password', type: 'string', example: 'password123'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'เข้าสู่ระบบสำเร็จ'),
            new OA\Response(response: 401, description: 'อีเมลหรือรหัสผ่านไม่ถูกต้อง'),
            new OA\Response(response: 403, description: 'กรุณาใช้อีเมลของมหาวิทยาลัย (@rmutr.ac.th) เท่านั้น'),
        ]
    )]
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (!str_ends_with(strtolower($request->email), '@rmutr.ac.th')) {
            return response()->json([
                'status'  => false,
                'message' => 'กรุณาใช้อีเมลของมหาวิทยาลัย (@rmutr.ac.th) เท่านั้น',
            ], 403);
        }

        $user = DB::table('users')->where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status'  => false,
                'message' => 'อีเมลหรือรหัสผ่านไม่ถูกต้อง',
            ], 401);
        }

        // ดึง Eloquent Model เพื่อสร้าง Sanctum Token
        $userModel = User::find($user->id);
        $userModel->tokens()->delete(); // ลบ token เก่าทิ้ง (login ได้เครื่องเดียว)
        $token = $userModel->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status'       => true,
            'message'      => 'เข้าสู่ระบบสำเร็จ',
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'user'         => [
                'id'            => $user->id,
                'students_id'   => $user->students_id,
                'first_name'    => $user->first_name,
                'last_name'     => $user->last_name,
                'email'         => $user->email,
                'role'          => $user->role,
                'profile_image' => $user->profile_image, // null ถ้าไม่ได้ผูก Google
                'google_id'     => $user->google_id,
            ],
        ], 200);
    }

    /**
     * 2. API เข้าสู่ระบบด้วย Google Token
     *    - บันทึกรูป Google ขนาด 400px
     *    - อัปเดตรูปทุกครั้งที่ Login ด้วย Google
     */
    #[OA\Post(
        path: '/api/login/google',
        summary: 'เข้าสู่ระบบด้วย Google Access Token',
        tags: ['Auth'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['access_token'],
                properties: [
                    new OA\Property(property: 'access_token', type: 'string', example: 'ya29.a0...'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'เข้าสู่ระบบด้วย Google สำเร็จ'),
            new OA\Response(response: 401, description: 'Google Token ไม่ถูกต้อง'),
            new OA\Response(response: 403, description: 'กรุณาใช้อีเมลของมหาวิทยาลัย (@rmutr.ac.th) เท่านั้น'),
        ]
    )]
    public function googleLogin(Request $request)
    {
        $request->validate([
            'access_token' => 'required|string',
        ]);

        try {
            $googleUser = Socialite::driver('google')->stateless()->userFromToken($request->access_token);
            $email      = $googleUser->getEmail();

            if (!str_ends_with($email, '@rmutr.ac.th')) {
                return response()->json([
                    'status'  => false,
                    'message' => 'กรุณาใช้อีเมลของมหาวิทยาลัย (@rmutr.ac.th) เท่านั้น',
                ], 403);
            }

            // รูป Google ขนาด 400px
            $avatar = $this->getGoogleAvatar($googleUser->getAvatar());

            $user = DB::table('users')->where('email', $email)->first();

            if (!$user) {
                // สมัครสมาชิกใหม่ด้วย Google
                $fullName   = explode(' ', $googleUser->getName(), 2);
                $studentsId = $this->studentIdFromUniversityEmail($email);

                $userId = DB::table('users')->insertGetId([
                    'students_id'   => $studentsId,
                    'first_name'    => $fullName[0] ?? '',
                    'last_name'     => $fullName[1] ?? '',
                    'email'         => $email,
                    'google_id'     => $googleUser->getId(),
                    'profile_image' => $avatar,
                    'role'          => 'user',
                    'password'      => null,
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ]);
            } else {
                // อัปเดตข้อมูล Google ล่าสุด (รวมถึงรูป)
                $userId = $user->id;
                DB::table('users')->where('id', $userId)->update([
                    'google_id'     => $googleUser->getId(),
                    'profile_image' => $avatar,
                    'updated_at'    => Carbon::now(),
                ]);
            }

            // สร้าง Sanctum Token
            $userModel = User::find($userId);
            $userModel->tokens()->delete();
            $token = $userModel->createToken('auth_token')->plainTextToken;

            // ดึงข้อมูลล่าสุดจาก DB
            $updatedUser = DB::table('users')
                ->select('id', 'students_id', 'first_name', 'last_name', 'email', 'google_id', 'profile_image', 'role', 'created_at', 'updated_at')
                ->where('id', $userId)
                ->first();

            return response()->json([
                'status'       => true,
                'message'      => 'เข้าสู่ระบบด้วย Google สำเร็จ',
                'access_token' => $token,
                'token_type'   => 'Bearer',
                'user'         => $updatedUser,
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'เกิดข้อผิดพลาดในการตรวจสอบ Google Token',
                'error'   => $e->getMessage(),
            ], 401);
        }
    }

    /**
     * 3. API ออกจากระบบ
     */
    #[OA\Post(
        path: '/api/logout',
        summary: 'ออกจากระบบ',
        tags: ['Auth'],
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'ออกจากระบบสำเร็จ'),
            new OA\Response(response: 401, description: 'Unauthenticated'),
        ]
    )]
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status'  => true,
            'message' => 'ออกจากระบบสำเร็จ',
        ]);
    }
}
