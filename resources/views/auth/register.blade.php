<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Garuda Hub</title>

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

        .register-container {
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
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 7px;
            color: #374151;
        }

        input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            outline: none;
            font-size: 14px;
        }

        input:focus, select:focus {
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

        .login-link {
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
    </style>
</head>

<body>

    <div class="register-container">

        <h1>Garuda Hub</h1>
        <p class="subtitle">Buat akun baru untuk bergabung</p>

        @if ($errors->any())
            <div class="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input
                    type="text"
                    id="nama"
                    name="nama"
                    value="{{ old('nama') }}"
                    placeholder="Masukkan nama lengkap"
                    required
                >
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="nama@example.com"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Minimal 8 karakter"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Masukkan ulang password"
                    required
                >
            </div>

            <div class="form-group">
                <label for="role">Daftar Sebagai</label>
                <select id="role" name="role" required>
                    <option value="">Pilih peran</option>
                    <option value="klien" {{ old('role') == 'klien' ? 'selected' : '' }}>
                        Klien
                    </option>
                    <option value="developer" {{ old('role') == 'developer' ? 'selected' : '' }}>
                        Developer
                    </option>
                </select>
            </div>

            <button type="submit" class="btn">
                Daftar Sekarang
            </button>
        </form>

        <p class="login-link">
            Sudah punya akun?
            <a href="{{ route('login') }}">Login di sini</a>
        </p>

    </div>

</body>
</html>
