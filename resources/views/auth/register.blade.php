<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>สมัครใช้งาน | Senior Project Center</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai:wght@400;500;600;700&family=Prompt:wght@600;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 28px;
            background: #f3ebe4;
            color: #453838;
            font-family: "IBM Plex Sans Thai", Tahoma, sans-serif
        }

        .card {
            width: min(100%, 460px);
            padding: 38px;
            background: #fffdfa;
            border: 1px solid #eadbd0;
            border-radius: 16px;
            box-shadow: 0 23px 46px #5d37211f;
            animation: enter .5s ease both
        }

        h1 {
            margin: 0;
            font-family: Prompt, sans-serif;
            font-size: 30px
        }

        .intro {
            margin: 4px 0 20px;
            color: #958481;
            font-size: 14px
        }

        label {
            display: block;
            margin-top: 13px;
            font-size: 14px;
            font-weight: 600
        }

        input {
            width: 100%;
            height: 43px;
            margin-top: 4px;
            padding: 0 12px;
            border: 1px solid #dbc9bf;
            border-radius: 10px;
            box-sizing: border-box;
            font: 14px "IBM Plex Sans Thai", sans-serif
        }

        input:focus {
            outline: 0;
            border-color: #9a4a55;
            box-shadow: 0 0 0 3px #70212d18
        }

        .names {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px
        }

        .button {
            width: 100%;
            height: 45px;
            margin-top: 23px;
            border: 0;
            border-radius: 11px;
            background: #812733;
            color: #fff;
            font: 600 15px "IBM Plex Sans Thai", sans-serif;
            cursor: pointer
        }

        .error {
            margin: 0 0 14px;
            padding: 10px;
            border-radius: 8px;
            color: #8b2531;
            background: #fff0ef;
            font-size: 13px
        }

        .foot {
            margin-top: 22px;
            text-align: center;
            color: #958481;
            font-size: 13px
        }

        a {
            color: #7c2530;
            font-weight: 600;
            text-decoration: none
        }

        @keyframes enter {
            from {
                opacity: 0;
                transform: translateY(15px)
            }

            to {
                opacity: 1;
                transform: none
            }
        }

        @media(max-width:400px) {
            .card {
                padding: 27px 21px
            }

            .names {
                grid-template-columns: 1fr
            }
        }
    </style>
</head>

<body>
    <main class="card">
        <h1>สมัครใช้งาน</h1>
        <p class="intro">สร้างบัญชีด้วยอีเมลมหาวิทยาลัย RMUTR</p>
        @if ($errors->any())<div class="error">{{ $errors->first() }}</div>@endif
        <form method="POST" action="{{ route('register.submit') }}">@csrf
            <div class="names"><label>ชื่อ<input name="first_name" value="{{ old('first_name') }}" required></label><label>นามสกุล<input name="last_name" value="{{ old('last_name') }}" required></label></div>
            <label>อีเมลมหาวิทยาลัย<input type="email" name="email" value="{{ old('email') }}" placeholder="name@rmutr.ac.th" required></label>
            <label>รหัสผ่าน<input type="password" name="password" minlength="8" required></label><label>ยืนยันรหัสผ่าน<input type="password" name="password_confirmation" minlength="8" required></label>
            <button class="button" type="submit">สมัครใช้งาน</button>
        </form>
        <p class="foot">มีบัญชีอยู่แล้ว? <a href="{{ route('login') }}">เข้าสู่ระบบ</a></p>
    </main>
</body>

</html>
