<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mapel;
use Illuminate\Support\Str;

class DummyMapelSeeder extends Seeder
{
    public function run(): void
    {
        $mapels = [
            [
                'nama' => 'Matematika',
                'slug' => 'matematika',
                'icon' => 'bi-calculator-fill',
                'warna' => '#3B82F6',
                'status' => 'aktif',
            ],
            [
                'nama' => 'Fisika',
                'slug' => 'fisika',
                'icon' => 'bi-lightning-charge-fill',
                'warna' => '#EC4899',
                'status' => 'aktif',
            ],
            [
                'nama' => 'Kimia',
                'slug' => 'kimia',
                'icon' => 'bi-funnel-fill',
                'warna' => '#EBB93B',
                'status' => 'aktif',
            ],
            [
                'nama' => 'Biologi',
                'slug' => 'biologi',
                'icon' => 'bi-tree-fill',
                'warna' => '#96BD4F',
                'status' => 'aktif',
            ],
            [
                'nama' => 'Bahasa Indonesia',
                'slug' => 'bahasa-indonesia',
                'icon' => 'bi-book-half',
                'warna' => '#EF4444',
                'status' => 'aktif',
            ],
            [
                'nama' => 'Bahasa Inggris',
                'slug' => 'bahasa-inggris',
                'icon' => 'bi-translate',
                'warna' => '#4C9DB8',
                'status' => 'aktif',
            ],
            [
                'nama' => 'Informatika & Coding',
                'slug' => 'informatika-coding',
                'icon' => 'bi-cpu-fill',
                'warna' => '#59C4BC',
                'status' => 'aktif',
            ],
            [
                'nama' => 'Ekonomi & Akuntansi',
                'slug' => 'ekonomi-akuntansi',
                'icon' => 'bi-graph-up-arrow',
                'warna' => '#34D399',
                'status' => 'aktif',
            ],
            [
                'nama' => 'Geografi',
                'slug' => 'geografi',
                'icon' => 'bi-globe-americas',
                'warna' => '#6366F1',
                'status' => 'aktif',
            ],
            [
                'nama' => 'Sosiologi',
                'slug' => 'sosiologi',
                'icon' => 'bi-people-fill',
                'warna' => '#A78BFA',
                'status' => 'aktif',
            ],
            [
                'nama' => 'Sejarah',
                'slug' => 'sejarah',
                'icon' => 'bi-hourglass-split',
                'warna' => '#D97706',
                'status' => 'aktif',
            ],
            [
                'nama' => 'Persiapan UTBK & SNBT',
                'slug' => 'persiapan-utbk-snbt',
                'icon' => 'bi-mortarboard-fill',
                'warna' => '#F472B6',
                'status' => 'aktif',
            ],
            [
                'nama' => 'Bahasa Jepang',
                'slug' => 'bahasa-jepang',
                'icon' => 'bi-chat-left-text-fill',
                'warna' => '#E11D48',
                'status' => 'aktif',
            ],
            [
                'nama' => 'Bahasa Mandarin',
                'slug' => 'bahasa-mandarin',
                'icon' => 'bi-chat-quote-fill',
                'warna' => '#F27474',
                'status' => 'aktif',
            ],
            [
                'nama' => 'Bahasa Arab',
                'slug' => 'bahasa-arab',
                'icon' => 'bi-journal-bookmark-fill',
                'warna' => '#059669',
                'status' => 'aktif',
            ],
            [
                'nama' => 'PAI & Keagamaan',
                'slug' => 'pai-keagamaan',
                'icon' => 'bi-moon-stars-fill',
                'warna' => '#38BDF8',
                'status' => 'aktif',
            ],
            [
                'nama' => 'Seni & Desain',
                'slug' => 'seni-desain',
                'icon' => 'bi-palette-fill',
                'warna' => '#FB923C',
                'status' => 'aktif',
            ],
            [
                'nama' => 'Calistung (Membaca, Menulis, Berhitung)',
                'slug' => 'calistung',
                'icon' => 'bi-pencil-fill',
                'warna' => '#F59E0B',
                'status' => 'aktif',
            ],
            [
                'nama' => 'Pendidikan Pancasila & PPKn',
                'slug' => 'pendidikan-pancasila-ppkn',
                'icon' => 'bi-shield-check',
                'warna' => '#DC2626',
                'status' => 'aktif',
            ],
            [
                'nama' => 'Musik & Olah Vokal',
                'slug' => 'musik-olah-vokal',
                'icon' => 'bi-music-note-beamed',
                'warna' => '#EC4899',
                'status' => 'aktif',
            ],
        ];

        foreach ($mapels as $data) {
            Mapel::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }
}

