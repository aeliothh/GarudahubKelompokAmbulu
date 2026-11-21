<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Proyek - Garuda Hub</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f3f4f6;
            color: #1f2937;
            padding: 30px 20px;
        }

        .container {
            max-width: 750px;
            margin: 0 auto;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #172554;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
        }

        .form-card {
            background: white;
            padding: 32px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        h1 {
            color: #172554;
            margin-bottom: 8px;
            font-size: 25px;
        }

        .subtitle {
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
            color: #374151;
            margin-bottom: 8px;
        }

        input, textarea, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            font-size: 14px;
            outline: none;
            background: white;
        }

        input:focus, textarea:focus, select:focus {
            border-color: #2563eb;
        }

        textarea {
            min-height: 130px;
            resize: vertical;
            line-height: 1.6;
        }

        .budget-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .error {
            color: #dc2626;
            font-size: 13px;
            margin-top: 6px;
        }

        .alert {
            background: #fee2e2;
            color: #991b1b;
            padding: 14px;
            border-radius: 7px;
            margin-bottom: 22px;
            font-size: 14px;
        }

        .button-group {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 28px;
        }

        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 7px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-cancel {
            background: #e5e7eb;
            color: #374151;
        }

        .btn-submit {
            background: #172554;
            color: white;
        }

        .btn-submit:hover {
            background: #1e40af;
        }

        @media (max-width: 550px) {
            .form-card {
                padding: 22px;
            }

            .budget-group {
                grid-template-columns: 1fr;
                gap: 0;
            }
        }
    </style>
</head>

<body>

    <main class="container">

        <a href="{{ route('projects.index') }}" class="back-link">
            &larr; Kembali ke Daftar Proyek
        </a>

        <section class="form-card">

            <h1>Pasang Proyek Baru</h1>

            <p class="subtitle">
                Lengkapi informasi proyek agar developer dapat mengajukan penawaran.
            </p>

            @if ($errors->any())
                <div class="alert">
                    <strong>Periksa kembali data yang kamu masukkan:</strong>

                    <ul style="margin-top: 8px; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('projects.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="judul">Judul Proyek</label>

                    <input
                        type="text"
                        id="judul"
                        name="judul"
                        value="{{ old('judul') }}"
                        placeholder="Contoh: Website Toko Online"
                        maxlength="200"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi Proyek</label>

                    <textarea
                        id="deskripsi"
                        name="deskripsi"
                        placeholder="Jelaskan kebutuhan dan ruang lingkup proyek..."
                        required
                    >{{ old('deskripsi') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="kategori">Kategori Proyek</label>

                    <select id="kategori" name="kategori" required>
                        <option value="">Pilih kategori</option>

                        @foreach (['Web', 'Mobile', 'Desain', 'Data', 'AI'] as $kategori)
                            <option
                                value="{{ $kategori }}"
                                {{ old('kategori') == $kategori ? 'selected' : '' }}
                            >
                                {{ $kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="budget-group">

                    <div class="form-group">
                        <label for="budget_min">Budget Minimum (Rp)</label>

                        <input
                            type="number"
                            id="budget_min"
                            name="budget_min"
                            value="{{ old('budget_min') }}"
                            placeholder="3000000"
                            min="0"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="budget_max">Budget Maksimum (Rp)</label>

                        <input
                            type="number"
                            id="budget_max"
                            name="budget_max"
                            value="{{ old('budget_max') }}"
                            placeholder="10000000"
                            min="1"
                            required
                        >
                    </div>

                </div>

                <div class="form-group">
                    <label for="batas_lelang">Batas Waktu Lelang</label>

                    <input
                        type="date"
                        id="batas_lelang"
                        name="batas_lelang"
                        value="{{ old('batas_lelang') }}"
                        min="{{ date('Y-m-d') }}"
                        required
                    >
                </div>

                <div class="button-group">
                    <a href="{{ route('projects.index') }}" class="btn btn-cancel">
                        Batal
                    </a>

                    <button type="submit" class="btn btn-submit">
                        Publikasikan Proyek
                    </button>
                </div>

            </form>

        </section>

    </main>

</body>
</html>
