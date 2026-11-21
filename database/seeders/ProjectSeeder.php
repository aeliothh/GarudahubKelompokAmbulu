<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'client_email' => 'budi@example.com',
                'judul' => 'Website Toko Batik Online',
                'deskripsi' => 'Membutuhkan toko online dengan katalog produk, keranjang, dan halaman kontak. Desain responsif.',
                'kategori' => 'Web',
                'budget_min' => 5000000,
                'budget_max' => 10000000,
                'batas_lelang' => '2027-12-31',
                'status' => 'terbuka',
            ],
            [
                'client_email' => 'budi@example.com',
                'judul' => 'Aplikasi Kasir Android',
                'deskripsi' => 'Aplikasi kasir sederhana untuk warung: catat transaksi, laporan harian, cetak struk via Bluetooth.',
                'kategori' => 'Mobile',
                'budget_min' => 8000000,
                'budget_max' => 15000000,
                'batas_lelang' => '2027-11-30',
                'status' => 'terbuka',
            ],
            [
                'client_email' => 'siti@example.com',
                'judul' => 'Redesain Logo dan UI Kit',
                'deskripsi' => 'Redesain identitas visual startup kuliner beserta UI kit untuk aplikasi pemesanan.',
                'kategori' => 'Desain',
                'budget_min' => 2000000,
                'budget_max' => 4000000,
                'batas_lelang' => '2026-09-01',
                'status' => 'ditutup',
            ],
            [
                'client_email' => 'siti@example.com',
                'judul' => 'Dashboard Analitik Penjualan',
                'deskripsi' => 'Dashboard grafik penjualan bulanan dari file CSV, dengan filter per cabang dan ekspor laporan.',
                'kategori' => 'Data',
                'budget_min' => 6000000,
                'budget_max' => 12000000,
                'batas_lelang' => '2027-10-15',
                'status' => 'terbuka',
            ],
            [
                'client_email' => 'agus@example.com',
                'judul' => 'Chatbot Layanan Pelanggan',
                'deskripsi' => 'Chatbot FAQ untuk situs sekolah, dapat dijawab dalam bahasa Indonesia.',
                'kategori' => 'AI',
                'budget_min' => 4000000,
                'budget_max' => 8000000,
                'batas_lelang' => '2026-08-20',
                'status' => 'terbuka',
            ],
            [
                'client_email' => 'agus@example.com',
                'judul' => 'Sistem Absensi Sekolah',
                'deskripsi' => 'Sistem absensi siswa berbasis web dengan rekap per kelas dan laporan bulanan untuk wali kelas.',
                'kategori' => 'Web',
                'budget_min' => 7000000,
                'budget_max' => 14000000,
                'batas_lelang' => '2026-07-10',
                'status' => 'ditutup',
            ],
            [
                'client_email' => 'budi@example.com',
                'judul' => 'Migrasi Database ke MySQL',
                'deskripsi' => 'Memindahkan data inventaris dari spreadsheet ke MySQL dan membuat skrip impor.',
                'kategori' => 'Data',
                'budget_min' => 3000000,
                'budget_max' => 6000000,
                'batas_lelang' => '2026-06-30',
                'status' => 'ditutup',
            ],
            [
                'client_email' => 'siti@example.com',
                'judul' => 'Landing Page Event Kampus',
                'deskripsi' => 'Satu halaman informasi acara seminar teknologi dengan formulir pendaftaran sederhana.',
                'kategori' => 'Web',
                'budget_min' => 1500000,
                'budget_max' => 3000000,
                'batas_lelang' => '2027-09-01',
                'status' => 'terbuka',
            ],
        ];

        foreach ($projects as $project) {
            $client = User::where(
                'email',
                $project['client_email']
            )->firstOrFail();

            Project::updateOrCreate(
                ['judul' => $project['judul']],
                [
                    'client_id' => $client->id,
                    'deskripsi' => $project['deskripsi'],
                    'kategori' => $project['kategori'],
                    'budget_min' => $project['budget_min'],
                    'budget_max' => $project['budget_max'],
                    'batas_lelang' => $project['batas_lelang'],
                    'status' => $project['status'],
                ]
            );
        }
    }
}
