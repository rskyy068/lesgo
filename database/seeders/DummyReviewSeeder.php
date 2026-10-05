<?php

namespace Database\Seeders;

use App\Models\Bimbel;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class DummyReviewSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        if ($users->isEmpty()) {
            return;
        }

        $bimbels = Bimbel::all();
        if ($bimbels->isEmpty()) {
            return;
        }

        $sampleComments = [
            5 => [
                'Sangat memuaskan! Pengajar sangat ramah, sabar, dan materi dijelaskan secara mendalam.',
                'Fasilitas sangat lengkap dan metode belajarnya membuat anak saya makin percaya diri di sekolah.',
                'Luar biasa! Skor tryout anak saya naik drastis setelah 2 bulan mengikuti bimbingan di sini.',
                'Bimbel terbaik di kota ini! Rekomendasi banget untuk persiapan SNBT dan Ujian Sekolah.',
            ],
            4 => [
                'Bagus sekali, pengajar berpengalaman dan suasana belajar sangat kondusif.',
                'Materi tersusun rapi dan banyak latihan soal yang mirip dengan ujian asli.',
                'Pelayanan ramah dan tempatnya bersih. Sangat membantu memajukan pemahaman materi.',
            ],
            3 => [
                'Cukup baik, pengajar jelas dalam menyampaikan materi walaupun jadwanya agak padat.',
                'Bimbingan oke, fasilitas perlu sedikit ditingkatkan tapi pengajarnya ramah.',
            ],
        ];

        foreach ($bimbels as $index => $bimbel) {
            // Tentukan pola rating untuk bimbel agar bervariasi
            // Bimbel di index awal dapat rating lebih tinggi (5, 5, 4), dsb
            $ratingPool = match ($index % 4) {
                0 => [5, 5, 5, 4],
                1 => [5, 4, 4, 5],
                2 => [4, 4, 3, 5],
                3 => [5, 5, 4, 4],
            };

            foreach ($ratingPool as $rIndex => $rating) {
                $user = $users[$rIndex % $users->count()];

                $comments = $sampleComments[$rating];
                $comment = $comments[array_rand($comments)];

                Review::updateOrCreate(
                    [
                        'user_id'   => $user->id,
                        'bimbel_id' => $bimbel->id,
                    ],
                    [
                        'rating'   => $rating,
                        'komentar' => $comment,
                    ]
                );
            }
        }
    }
}
