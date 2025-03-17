<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #ccc;
            font-family: Arial, sans-serif;
            margin: 0;
        }
        .login-container {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: right;
        }
        .login-container h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .input-field {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
        }
        .remember-me {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .login-button {
            width: 100%;
            padding: 10px;
            background: blue;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }
        .social-login {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }
        .social-login button {
            flex: 1;
            margin: 0 5px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background: rgb(255, 255, 255);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .social-login img {
            width: 20px;
            height: 20px;
            margin-left: 5px;
        }
        .register-link {
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
        }
        .register-link a {
            color: blue;
            text-decoration: none;
        }
        .label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        .input-field {
            margin-right: -10px;
        }
        #text {
            text-align: center;
            font-weight: bold;
            margin-top: 15px;
        }
        .remember-me a {
            color: #000;
            text-decoration: none;
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
    <div class="login-container">
        <h2>دخول</h2>

        <!-- Session Status -->
        @if (session('status'))
            <div class="status-message">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="email-container">
                <label class="label" for="email">البريد الإلكتروني</label>
                <input id="email" type="email" class="input-field" name="email" value="{{ old('email') }}" placeholder="البريد الإلكتروني" required autofocus autocomplete="username">
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="password-container">
                <label class="label" for="password">كلمة السر</label>
                <input id="password" type="password" class="input-field" name="password" placeholder="كلمة السر" required autocomplete="current-password">
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="remember-me">
                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> تذكرني
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">نسيت كلمة المرور؟</a>
                @endif
            </div>

            <!-- Login Button -->
            <button type="submit" class="login-button">دخول</button>


        </form>



        <!-- Register Link -->
        <div class="register-link">
            ليس لديك حساب؟ <a href="{{ route('register') }}">سجل الآن</a>
        </div>
    </div>
</body>
</html>
