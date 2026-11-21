<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Garuda Hub</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f3f4f6;
            min-height: 100vh;
        }

        .navbar {
            background: #172554;
            color: white;
            padding: 18px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h2 {
            font-size: 21px;
        }

        .logout-btn {
            background: white;
            color: #172554;
            padding: 9px 16px;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }

        .container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .welcome {
            margin-bottom: 25px;
        }

        .welcome h1 {
            color: #172554;
            margin-bottom: 8px;
        }

        .welcome p {
            color: #6b7280;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 13px;
            border-radius: 7px;
            margin-bottom: 20px;
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05);
        }

        .card h3 {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 12px;
        }

        .card p {
            color: #172554;
            font-size: 20px;
            font-weight: bold;
        }

        .information {
            background: white;
            padding: 25px;
            border-radius: 10px;
            margin-top: 25px;
        }

        .information h3 {
            color: #172554;
            margin-bottom: 12px;
        }

        .information p {
            color: #6b7280;
            line-height: 1.7;
        }

        @media (max-width: 600px) {
            .navbar {
                padding: 16px 5%;
            }

            .container {
                margin-top: 30px;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <h2>Garuda Hub</h2>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">
                Logout
            </button>
        </form>
    </nav>

    <main class="container">

        @if (session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        <section class="welcome">
            <h1>Selamat Datang, {{ auth()->user()->nama }}!</h1>
            <p>Selamat datang di dashboard Garuda Hub.</p>
        </section>

        <section class="card-container">

            <div class="card">
                <h3>Nama Pengguna</h3>
                <p>{{ auth()->user()->nama }}</p>
            </div>

            <div class="card">
                <h3>Email</h3>
                <p style="font-size: 16px;">
                    {{ auth()->user()->email }}
                </p>
            </div>

            <div class="card">
                <h3>Role Pengguna</h3>
                <p>{{ ucfirst(auth()->user()->role) }}</p>
            </div>

        </section>

        <section class="information">
            <h3>Informasi Akun</h3>
            <p>
                Kamu berhasil masuk ke sistem Garuda Hub.
                Dashboard ini merupakan halaman awal setelah
                pengguna melakukan login atau registrasi.
            </p>
        </section>

    </main>

</body>
</html>
