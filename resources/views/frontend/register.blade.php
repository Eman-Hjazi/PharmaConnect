<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء حساب</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        .registration-form {
            display: flex;
            flex-direction: column;
            text-align: right;
            margin-right: 10px;
        }

        .registration-form h2 {
            text-align: right;
            margin-bottom: 20px;
        }

        .labels {
            font-weight: bold;
            margin: 0;
            margin-bottom: 5px;
        }

        .inputs {
            text-align: right;
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
        }


        .account {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        .account:hover {
            background-color: #0056b3;
        }

        .alternative-login {
            text-align: center;
        }

        .alternative-login p {
            font-weight: bold;
        }

        .social-login {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }

        .social-login button {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background: rgb(255, 255, 255);
            cursor: pointer;
            display: inline-block;
            align-items: center;
            justify-content: center;
        }

        .social-login img {
            width: 20px;
            height: 20px;
            margin: 0;
        }

        .registration-form p {
            text-align: center;
        }

        .registration-form a {
            color: #007bff;
            text-decoration: none;
        }

        .registration-form a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
            font-size: 12px;
            margin-bottom: 10px;
        }

        .status-message {
            color: green;
            font-size: 14px;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <form class="registration-form" method="POST" action="{{ route('register') }}">
            @csrf

            <h2>إنشاء حساب</h2>

            <!-- Session Status -->
            @if (session('status'))
                <div class="status-message">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Name -->
            <label class="labels" for="name">الاسم كامل</label>
            <input class="inputs" id="name" type="text" name="name" value="{{ old('name') }}" placeholder="الاسم كامل" required autofocus autocomplete="name">
            @error('name')
                <div class="error-message">{{ $message }}</div>
            @enderror

            <!-- Email Address -->
            <label class="labels" for="email">البريد الإلكتروني</label>
            <input class="inputs" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="البريد الإلكتروني" required autocomplete="username">
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror

            <!-- Password -->
            <label class="labels" for="password">كلمة السر</label>
            <input class="inputs" id="password" type="password" name="password" placeholder="كلمة السر" required autocomplete="new-password">
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror

            <!-- Confirm Password -->
            <label class="labels" for="password_confirmation">تأكيد كلمة السر</label>
            <input class="inputs" id="password_confirmation" type="password" name="password_confirmation" placeholder="تأكيد كلمة السر" required autocomplete="new-password">
            @error('password_confirmation')
                <div class="error-message">{{ $message }}</div>
            @enderror


            <button type="submit" class="account">إنشاء حساب</button>



            <p>لديك حساب بالفعل؟ <a href="{{ route('login') }}">دخول</a></p>
        </form>
    </div>
</body>
</html>
