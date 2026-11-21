<?php

namespace Database\Seeders;

use App\Models\Bid;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class BidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bids = [
            [
                'project_title' => 'Website Toko Batik Online',
                'developer_email' => 'dewi@example.com',
                'harga' => 8500000,
                'durasi' => 30,
                'proposal' => 'Saya akan membangun dengan PHP dan MySQL, lengkap dengan panel admin produk.',
                'is_winner' => false,
            ],
            [
                'project_title' => 'Website Toko Batik Online',
                'developer_email' => 'eko@example.com',
                'harga' => 7000000,
                'durasi' => 40,
                'proposal' => 'Pengalaman 3 tahun membuat toko online. Termasuk pelatihan penggunaan.',
                'is_winner' => false,
            ],
            [
                'project_title' => 'Website Toko Batik Online',
                'developer_email' => 'fitri@example.com',
                'harga' => 9500000,
                'durasi' => 25,
                'proposal' => 'Desain premium bernuansa batik, dukungan perawatan 3 bulan.',
                'is_winner' => false,
            ],
            [
                'project_title' => 'Aplikasi Kasir Android',
                'developer_email' => 'dewi@example.com',
                'harga' => 12000000,
                'durasi' => 45,
                'proposal' => 'Aplikasi native Kotlin, dukungan printer Bluetooth termasuk.',
                'is_winner' => false,
            ],
            [
                'project_title' => 'Aplikasi Kasir Android',
                'developer_email' => 'gilang@example.com',
                'harga' => 10000000,
                'durasi' => 50,
                'proposal' => 'Memakai Flutter agar bisa juga dipakai di iOS nanti.',
                'is_winner' => false,
            ],
            [
                'project_title' => 'Redesain Logo dan UI Kit',
                'developer_email' => 'eko@example.com',
                'harga' => 3000000,
                'durasi' => 14,
                'proposal' => 'Tiga konsep logo dan UI kit lengkap di Figma.',
                'is_winner' => true,
            ],
            [
                'project_title' => 'Redesain Logo dan UI Kit',
                'developer_email' => 'fitri@example.com',
                'harga' => 3500000,
                'durasi' => 10,
                'proposal' => 'Revisi tak terbatas selama 2 minggu.',
                'is_winner' => false,
            ],
            [
                'project_title' => 'Dashboard Analitik Penjualan',
                'developer_email' => 'gilang@example.com',
                'harga' => 9000000,
                'durasi' => 35,
                'proposal' => 'Dashboard dengan Chart dan ekspor PDF.',
                'is_winner' => false,
            ],
            [
                'project_title' => 'Dashboard Analitik Penjualan',
                'developer_email' => 'dewi@example.com',
                'harga' => 11000000,
                'durasi' => 30,
                'proposal' => 'Termasuk modul impor CSV otomatis.',
                'is_winner' => false,
            ],
            [
                'project_title' => 'Dashboard Analitik Penjualan',
                'developer_email' => 'eko@example.com',
                'harga' => 7500000,
                'durasi' => 45,
                'proposal' => 'Fokus pada grafik interaktif dan filter cabang.',
                'is_winner' => false,
            ],
            [
                'project_title' => 'Chatbot Layanan Pelanggan',
                'developer_email' => 'fitri@example.com',
                'harga' => 6000000,
                'durasi' => 30,
                'proposal' => 'Chatbot berbasis aturan dengan basis pengetahuan FAQ sekolah.',
                'is_winner' => false,
            ],
            [
                'project_title' => 'Sistem Absensi Sekolah',
                'developer_email' => 'gilang@example.com',
                'harga' => 11000000,
                'durasi' => 40,
                'proposal' => 'Sistem lengkap dengan rekap otomatis dan ekspor Excel.',
                'is_winner' => true,
            ],
            [
                'project_title' => 'Sistem Absensi Sekolah',
                'developer_email' => 'dewi@example.com',
                'harga' => 13000000,
                'durasi' => 35,
                'proposal' => 'Termasuk aplikasi pemindai kode QR untuk absensi.',
                'is_winner' => false,
            ],
            [
                'project_title' => 'Migrasi Database ke MySQL',
                'developer_email' => 'eko@example.com',
                'harga' => 4500000,
                'durasi' => 15,
                'proposal' => 'Skrip impor dengan validasi data dan laporan galat.',
                'is_winner' => true,
            ],
            [
                'project_title' => 'Migrasi Database ke MySQL',
                'developer_email' => 'fitri@example.com',
                'harga' => 5000000,
                'durasi' => 12,
                'proposal' => 'Termasuk dokumentasi skema dan pelatihan singkat.',
                'is_winner' => false,
            ],
        ];

        foreach ($bids as $bid) {
            $project = Project::where(
                'judul',
                $bid['project_title']
            )->firstOrFail();

            $developer = User::where(
                'email',
                $bid['developer_email']
            )->firstOrFail();

            Bid::updateOrCreate(
                [
                    'project_id' => $project->id,
                    'developer_id' => $developer->id,
                ],
                [
                    'harga' => $bid['harga'],
                    'durasi' => $bid['durasi'],
                    'proposal' => $bid['proposal'],
                    'is_winner' => $bid['is_winner'],
                ]
            );
        }
    }
}
