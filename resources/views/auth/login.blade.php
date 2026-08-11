<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#6d202c">
    <title>เข้าสู่ระบบ | Senior Project Center</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai:wght@400;500;600;700&family=Prompt:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --wine: #70212d; --wine-dark: #591822; --gold: #d9a63c; --paper: #f3ebe4; --ink: #453838; --muted: #988783; }
        * { box-sizing: border-box; }
        body { margin: 0; min-width: 320px; color: var(--ink); font-family: "IBM Plex Sans Thai", Tahoma, sans-serif; background: var(--paper); }
        .login-page { min-height: 100vh; display: grid; grid-template-columns: 44% 56%; }
        .brand-panel { position: relative; min-height: 100vh; overflow: hidden; padding: 48px; color: #fff; background: var(--wine); display: flex; flex-direction: column; }
        .brand-panel::before, .brand-panel::after { content: ""; position: absolute; border: 1px solid rgba(214, 157, 54, .25); border-radius: 50%; pointer-events: none; }
        .brand-panel::before { width: 370px; height: 370px; top: -145px; right: -120px; }
        .brand-panel::after { width: 430px; height: 430px; bottom: -130px; left: -48px; }
        .university { position: relative; z-index: 1; display: flex; align-items: center; gap: 12px; font-size: 11px; line-height: 1.25; }
        .crest { width: 36px; height: 36px; border-radius: 50% 50% 45% 45%; display: grid; place-items: center; color: var(--wine); background: #d6a634; box-shadow: inset 0 0 0 3px rgba(255,255,255,.17); font-weight: 700; font-size: 12px; }
        .university strong { display: block; font-size: 13px; font-weight: 700; }
        .university span { color: #e3bd68; }
        .brand-copy { position: relative; z-index: 1; margin: auto 0; max-width: 455px; transform: translateY(15px); }
        .eyebrow { margin: 0 0 8px; color: #e3b54a; font-family: Prompt, sans-serif; font-size: 11px; font-weight: 700; letter-spacing: .31em; }
        h1 { max-width: 410px; margin: 0; font-family: Prompt, "IBM Plex Sans Thai", sans-serif; font-size: clamp(42px, 4vw, 61px); line-height: 1.1; letter-spacing: -.035em; }
        .description { max-width: 450px; margin: 26px 0 0; font-size: 17px; line-height: 1.8; color: rgba(255,255,255,.9); }
        .brand-footer { position: relative; z-index: 1; display: flex; align-items: center; gap: 12px; color: #d6adaf; font-size: 12px; }
        .brand-footer::before { content: ""; width: 40px; height: 1px; background: #daa839; }
        .form-panel { min-height: 100vh; display: grid; place-items: center; padding: 36px; background: radial-gradient(circle at 50% 53%, #fffaf5 0, #f5ece5 37%, var(--paper) 72%); }
        .login-card { width: min(100%, 448px); padding: 40px; background: rgba(255,253,250,.94); border: 1px solid #eadbd0; border-radius: 16px; box-shadow: 0 23px 46px rgba(93, 55, 41, .12); animation: card-enter .65s cubic-bezier(.22, 1, .36, 1) both; }
        .welcome { margin: 0 0 2px; color: #c58c23; font-size: 14px; font-weight: 600; }
        h2 { margin: 0; font-family: Prompt, "IBM Plex Sans Thai", sans-serif; font-size: 30px; line-height: 1.3; }
        .helper { margin: 4px 0 27px; color: #958481; font-size: 14px; }
        .field { display: block; margin-top: 17px; color: #594b47; font-size: 14px; font-weight: 600; }
        .required { color: #9a2935; }
        input[type="email"], input[type="password"] { width: 100%; height: 44px; margin-top: 5px; padding: 0 13px; color: var(--ink); font: 500 14px/1 "IBM Plex Sans Thai", sans-serif; background: #fffdfa; border: 1px solid #dbc9bf; border-radius: 12px; outline: none; transition: border-color .2s, box-shadow .2s; }
        input:focus { border-color: #9a4a55; box-shadow: 0 0 0 3px rgba(112,33,45,.1); }
        .options { display: flex; align-items: center; justify-content: space-between; gap: 15px; margin-top: 13px; color: #927f7a; font-size: 13px; }
        .remember { display: flex; align-items: center; gap: 8px; white-space: nowrap; cursor: pointer; }
        input[type="checkbox"] { width: 13px; height: 13px; accent-color: var(--wine); }
        .forgot { color: #7c2530; font-weight: 600; text-decoration: none; }
        .forgot:hover { text-decoration: underline; }
        .submit { width: 100%; height: 45px; margin-top: 23px; border: 0; border-radius: 12px; color: #fff; font: 600 15px/1 "IBM Plex Sans Thai", sans-serif; cursor: pointer; background: #812733; transition: background .2s, transform .2s; }
        .submit:hover { background: var(--wine-dark); transform: translateY(-1px); }
        .arrow { display: inline-block; margin-left: 9px; font-size: 21px; line-height: 0; vertical-align: -2px; }
        .login-divider { display: flex; align-items: center; gap: 12px; margin: 23px 0 16px; color: #ac9c96; font-size: 12px; }
        .login-divider::before, .login-divider::after { content: ""; height: 1px; flex: 1; background: #e7dcd5; }
        .google-login { display: flex; align-items: center; justify-content: center; gap: 10px; height: 45px; color: #514340; background: #fff; border: 1px solid #ddcec6; border-radius: 12px; font-size: 14px; font-weight: 600; text-decoration: none; transition: border-color .2s, box-shadow .2s, transform .2s; }
        .google-login:hover { border-color: #b7a19a; box-shadow: 0 7px 15px rgba(93,55,41,.1); transform: translateY(-2px); }
        .google-mark { width: 19px; height: 19px; }
        .card-footer { margin-top: 32px; padding-top: 18px; border-top: 1px solid #e7dcd5; color: #ad9d96; text-align: center; font-size: 12px; }
        .error { margin: 0 0 18px; padding: 10px 12px; color: #8b2531; background: #fff0ef; border-radius: 9px; font-size: 13px; }
        @keyframes card-enter { from { opacity: 0; transform: translateY(20px) scale(.985); } to { opacity: 1; transform: translateY(0) scale(1); } }
        @media (prefers-reduced-motion: reduce) { *, *::before, *::after { scroll-behavior: auto !important; animation-duration: .01ms !important; animation-iteration-count: 1 !important; transition-duration: .01ms !important; } }
        @media (max-width: 820px) { .login-page { grid-template-columns: 1fr; } .brand-panel { min-height: auto; padding: 28px 30px 34px; } .brand-copy { margin: 52px 0 0; transform: none; } .brand-footer { display: none; } .form-panel { min-height: auto; padding: 42px 22px; } }
        @media (max-width: 460px) { .brand-panel { padding: 24px; } h1 { font-size: 38px; } .description { font-size: 15px; } .login-card { padding: 28px 22px; } .options { align-items: flex-start; flex-direction: column; gap: 8px; } }
    </style>
</head>
<body>
    <main class="login-page">
        <section class="brand-panel" aria-labelledby="project-title">
            <div class="university">
                <div class="crest" aria-hidden="true">◈</div>
                <div><strong>มหาวิทยาลัยเทคโนโลยีราชมงคลรัตนโกสินทร์</strong><span>Rajamangala University of Technology Rattanakosin</span></div>
            </div>
            <div class="brand-copy">
                <p class="eyebrow">SENIOR PROJECT CENTER</p>
                <h1 id="project-title">พื้นที่กลาง<br>ของโครงงานที่ดี</h1>
                <p class="description">ติดตามความก้าวหน้า ประสานงานกับอาจารย์ และรวบรวมเอกสารสำคัญของโครงงานวิศวกรรมไว้ในที่เดียว</p>
            </div>
            <div class="brand-footer">งานสหกิจศึกษาและโครงงานวิศวกรรม · พ.ศ. 2568</div>
        </section>

        <section class="form-panel" aria-label="เข้าสู่ระบบ">
            <form class="login-card" method="POST" action="{{ route('login.submit') }}">
                @csrf
                @if ($errors->any())
                    <div class="error">{{ $errors->first() }}</div>
                @endif
                <p class="welcome">ยินดีต้อนรับกลับ</p>
                <h2>เข้าสู่ระบบ</h2>
                <p class="helper">ใช้บัญชี RMUTR ของคุณเพื่อดำเนินการต่อ</p>
                <label class="field" for="email">อีเมลมหาวิทยาลัย <span class="required">*</span>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="name@rmutr.ac.th" autocomplete="email" required autofocus>
                </label>
                <label class="field" for="password">รหัสผ่าน <span class="required">*</span>
                    <input id="password" name="password" type="password" placeholder="กรอกรหัสผ่าน" autocomplete="current-password" required>
                </label>
                <div class="options">
                    <label class="remember"><input type="checkbox" name="remember" checked> จดจำการเข้าสู่ระบบ</label>
                    <a class="forgot" href="#">ลืมรหัสผ่าน?</a>
                </div>
                <button class="submit" type="submit">เข้าสู่ระบบ <span class="arrow">→</span></button>
                <div class="login-divider">หรือ</div>
                <a class="google-login" href="{{ route('google.login') }}">
                    <svg class="google-mark" viewBox="0 0 24 24" aria-hidden="true"><path fill="#4285F4" d="M21.8 12.23c0-.71-.06-1.23-.2-1.78H12v3.55h5.64c-.11.88-.7 2.2-2.02 3.1l-.02.12 2.93 2.22.2.02c1.85-1.66 3.07-4.12 3.07-7.23Z"/><path fill="#34A853" d="M12 22c2.76 0 5.08-.89 6.77-2.42l-3.22-2.36c-.86.58-2.01.98-3.55.98a6.14 6.14 0 0 1-5.8-4.15l-.12.01-3.05 2.3-.04.11A10.16 10.16 0 0 0 12 22Z"/><path fill="#FBBC05" d="M6.2 14.05A6.04 6.04 0 0 1 5.86 12c0-.71.12-1.4.33-2.05v-.13L3.1 7.48l-.1.05A9.77 9.77 0 0 0 2 12c0 1.61.39 3.13 1 4.47l3.2-2.42Z"/><path fill="#EA4335" d="M12 5.8c1.94 0 3.25.82 4 1.5l2.92-2.79C17.07 2.82 14.76 2 12 2A10.16 10.16 0 0 0 3 7.53l3.19 2.42A6.17 6.17 0 0 1 12 5.8Z"/></svg>
                    เข้าสู่ระบบด้วย Google
                </a>
                <div class="card-footer">สำหรับนักศึกษา อาจารย์ที่ปรึกษา และผู้ดูแลระบบ<br>ยังไม่มีบัญชี? <a class="forgot" href="{{ route('register') }}">สมัครใช้งาน</a></div>
            </form>
        </section>
    </main>
</body>
</html>
