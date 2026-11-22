{{--
    IDENTITAS KELOMPOK GARUDA HUB

    1. NIM: 252410102027
    2. NIM: 252410102044
    3. NIM: 252410102085
    4. NIM: 252410102093
    5. NIM: 252410102094
--}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Garuda Hub</title>

    <style nonce="{{ $cspNonce }}">
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f3f4f6;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 430px;
            background: white;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        h1 {
            text-align: center;
            color: #172554;
            margin-bottom: 8px;
        }

        .subtitle {
            text-align: center;
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 28px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 7px;
            color: #374151;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            outline: none;
            font-size: 14px;
        }

        input:focus {
            border-color: #2563eb;
        }

        .btn {
            width: 100%;
            padding: 13px;
            background: #172554;
            color: white;
            border: none;
            border-radius: 7px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn:hover {
            background: #1e40af;
        }

        .register-link {
            text-align: center;
            margin-top: 22px;
            font-size: 14px;
            color: #6b7280;
        }

        a {
            color: #2563eb;
            text-decoration: none;
        }

        .error {
            color: #dc2626;
            font-size: 13px;
            margin-top: 5px;
        }

        .alert {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 7px;
            font-size: 13px;
            margin-bottom: 18px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 7px;
            font-size: 13px;
            margin-bottom: 18px;
        }
    </style>
</head>

<body>

    <div class="login-container">

        <h1>Garuda Hub</h1>
        <p class="subtitle">Masuk ke akun Garuda Hub kamu</p>

        @if (session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="nama@example.com"
                    required
                    autofocus
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Masukkan password"
                    required
                >
            </div>

            <button type="submit" class="btn">
                Login
            </button>
        </form>

        <p class="register-link">
            Belum punya akun?
            <a href="{{ route('register') }}">Daftar sekarang</a>
        </p>

    </div>

</body>
</html>
