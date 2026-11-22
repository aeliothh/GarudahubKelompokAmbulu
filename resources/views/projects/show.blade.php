
<!DOCTYPE html>
<html lang="id">
    <link rel="stylesheet" href="{{ asset('css/security-fixes.css') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Proyek - Garuda Hub</title>

    <style nonce="{{ $cspNonce }}">
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f3f4f6;
            color: #1f2937;
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

        .navbar a {
            color: white;
            text-decoration: none;
            font-size: 14px;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #172554;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
        }

        .card {
            background: white;
            padding: 28px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            margin-bottom: 22px;
        }

        .category {
            display: inline-block;
            background: #eff6ff;
            color: #1d4ed8;
            padding: 6px 11px;
            border-radius: 5px;
            font-size: 12px;
            margin-bottom: 15px;
        }

        h1 {
            color: #172554;
            font-size: 27px;
            margin-bottom: 12px;
        }

        h2 {
            color: #172554;
            font-size: 20px;
            margin-bottom: 20px;
        }

        .description {
            color: #4b5563;
            line-height: 1.8;
            margin-top: 15px;
            white-space: pre-line;
        }

        .status {
            display: inline-block;
            padding: 6px 11px;
            border-radius: 5px;
            font-size: 12px;
            background: #dcfce7;
            color: #166534;
        }

        .status.closed {
            background: #fee2e2;
            color: #991b1b;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 25px;
        }

        .info-item {
            background: #f9fafb;
            padding: 17px;
            border-radius: 8px;
        }

        .info-item span {
            display: block;
            color: #6b7280;
            font-size: 13px;
            margin-bottom: 8px;
        }

        .info-item strong {
            color: #172554;
            font-size: 15px;
        }

        .action-group {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 25px;
        }

        .btn {
            display: inline-block;
            padding: 11px 17px;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-primary {
            background: #172554;
            color: white;
        }

        .btn-primary:hover {
            background: #1e40af;
        }

        .btn-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .btn-winner {
            background: #166534;
            color: white;
            margin-top: 15px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 8px;
            color: #374151;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            font-size: 14px;
            outline: none;
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        input:focus, textarea:focus {
            border-color: #2563eb;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            padding: 13px;
            border-radius: 7px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            padding: 13px;
            border-radius: 7px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .bid-item {
            padding: 20px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .bid-header {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 12px;
        }

        .bid-header strong {
            color: #172554;
        }

        .bid-price {
            color: #166534;
            font-weight: bold;
            font-size: 16px;
        }

        .bid-details {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            color: #6b7280;
            font-size: 13px;
            margin-bottom: 12px;
        }

        .proposal {
            font-size: 14px;
            line-height: 1.7;
            color: #4b5563;
        }

        .winner {
            display: inline-block;
            background: #dcfce7;
            color: #166534;
            padding: 6px 10px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: bold;
        }

        .empty {
            text-align: center;
            color: #6b7280;
            padding: 35px 15px;
            background: #f9fafb;
            border-radius: 8px;
        }

        @media (max-width: 600px) {
            .navbar {
                padding: 16px 5%;
            }

            .container {
                margin-top: 25px;
            }

            .card {
                padding: 20px;
            }

            h1 {
                font-size: 22px;
            }
        }
    </style>
</head>

<body>

    @php
        $isProjectOwner = auth()->user()->role === 'klien'
            && (int) $project->client_id === (int) auth()->id();

        $myBid = $project->bids->firstWhere(
            'developer_id',
            auth()->id()
        );

        $isBidOpen = $project->status === 'terbuka'
            && !$project->batas_lelang->lt(today());

        $hasWinner = $project->bids->contains('is_winner', true);
    @endphp

    <nav class="navbar">
        <h2>Garuda Hub</h2>
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </nav>

    <main class="container">

        <a href="{{ route('projects.index') }}" class="back-link">
            &larr; Kembali ke Daftar Proyek
        </a>

        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert-error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Informasi proyek -->
        <section class="card">

            <span class="category">{{ $project->kategori }}</span>

            <h1>{{ $project->judul }}</h1>

            <span class="status {{ $project->status === 'ditutup' ? 'closed' : '' }}">
                {{ ucfirst($project->status) }}
            </span>

            <p class="description">{{ $project->deskripsi }}</p>

            <div class="info-grid">

                <div class="info-item">
                    <span>Klien</span>
                    <strong>{{ $project->client->nama }}</strong>
                </div>

                <div class="info-item">
                    <span>Budget Minimum</span>
                    <strong>Rp{{ number_format($project->budget_min, 0, ',', '.') }}</strong>
                </div>

                <div class="info-item">
                    <span>Budget Maksimum</span>
                    <strong>Rp{{ number_format($project->budget_max, 0, ',', '.') }}</strong>
                </div>

                <div class="info-item">
                    <span>Batas Lelang</span>
                    <strong>{{ $project->batas_lelang->format('d M Y') }}</strong>
                </div>

                <div class="info-item">
                    <span>Total Penawaran</span>
                    <strong>{{ $project->bids->count() }} Penawaran</strong>
                </div>

                <div class="info-item">
                    <span>Tanggal Dibuat</span>
                    <strong>{{ $project->created_at->format('d M Y') }}</strong>
                </div>

            </div>

            @if ($isProjectOwner)
                <div class="action-group">

                    <a href="{{ route('projects.edit', $project) }}"
                       class="btn btn-primary">
                        Edit Proyek
                    </a>

                    <form action="{{ route('projects.destroy', $project) }}"
                          method="POST"
                          data-confirm="Yakin ingin menghapus proyek ini?">

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">
                            Hapus Proyek
                        </button>
                    </form>

                </div>
            @endif

        </section>

        <!-- Form pengajuan penawaran -->
        @if (auth()->user()->role === 'developer')

            <section class="card">

                <h2>Ajukan Penawaran</h2>

                @if ($myBid)

                    <div class="empty">
                        <h3>Penawaran Sudah Diajukan</h3>

                        <p class="csp-mt-10">
                            Kamu sudah mengajukan penawaran untuk proyek ini.
                        </p>

                        <p class="csp-mt-10">
                            Harga:
                            <strong>
                                Rp{{ number_format($myBid->harga, 0, ',', '.') }}
                            </strong>
                        </p>

                        <p class="csp-mt-5">
                            Durasi: {{ $myBid->durasi }} hari
                        </p>
                    </div>

                @elseif ($isBidOpen)

                    <p class="csp-project-note">
                        Isi informasi penawaran sesuai kemampuan dan estimasi pengerjaanmu.
                    </p>

                    <form action="{{ route('bids.store', $project) }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="harga">Harga Penawaran (Rp)</label>
                            <input type="number" id="harga" name="harga"
                                   value="{{ old('harga') }}"
                                   min="1" placeholder="Contoh: 7500000" required>
                        </div>

                        <div class="form-group">
                            <label for="durasi">Durasi Pengerjaan (Hari)</label>
                            <input type="number" id="durasi" name="durasi"
                                   value="{{ old('durasi') }}"
                                   min="1" placeholder="Contoh: 30" required>
                        </div>

                        <div class="form-group">
                            <label for="proposal">Proposal Penawaran</label>
                            <textarea id="proposal" name="proposal"
                                      placeholder="Jelaskan pendekatan pengerjaan dan kemampuan yang kamu tawarkan..."
                                      required>{{ old('proposal') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Kirim Penawaran
                        </button>
                    </form>

                @else

                    <div class="empty">
                        <h3>Penawaran Ditutup</h3>
                        <p class="csp-mt-8">
                            Proyek ini tidak lagi menerima penawaran.
                        </p>
                    </div>

                @endif

            </section>

        @endif

        <!-- Daftar penawaran untuk klien pemilik proyek -->
        @if ($isProjectOwner)

            <section class="card">

                <h2>Penawaran Developer</h2>

                @if ($project->bids->count() > 0)

                    @foreach ($project->bids as $bid)

                        <div class="bid-item">

                            <div class="bid-header">
                                <strong>{{ $bid->developer->nama }}</strong>

                                <span class="bid-price">
                                    Rp{{ number_format($bid->harga, 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="bid-details">
                                <span>Durasi: {{ $bid->durasi }} hari</span>

                                @if ($bid->is_winner)
                                    <span class="winner">
                                        Penawaran Terpilih
                                    </span>
                                @endif
                            </div>

                            <p class="proposal">{{ $bid->proposal }}</p>

                            @if (!$hasWinner && $isBidOpen)
                                <form
                                    action="{{ route('bids.winner', [$project, $bid]) }}"
                                    method="POST"
                                    data-confirm="Yakin memilih {{ $bid->developer->nama }} sebagai pemenang?"
                                >
                                    @csrf

                                    <button type="submit" class="btn btn-winner">
                                        Pilih sebagai Pemenang
                                    </button>
                                </form>
                            @endif

                        </div>

                    @endforeach

                @else

                    <div class="empty">
                        <h3>Belum Ada Penawaran</h3>
                        <p class="csp-mt-8">
                            Belum ada developer yang mengajukan penawaran.
                        </p>
                    </div>

                @endif

            </section>

        @endif

    </main>

    <script src="{{ asset('js/project-confirm.js') }}" defer></script>

</body>
</html>
