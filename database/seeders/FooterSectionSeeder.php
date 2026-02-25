<?php

namespace Database\Seeders;

use App\Models\FooterSection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FooterSectionSeeder extends Seeder
{
    public function run(): void
    {
        $investor = FooterSection::updateOrCreate(
            ['slug' => 'investor'],
            [
                'title' => 'Investor bermanfaat',
                'content' => 'ayo bergabung denganku biar dapet duit',
                'image' => 'investor.jpg'
            ]
        );

        $csr = FooterSection::updateOrCreate(
            ['slug' => 'csr'],
            [
                'title' => 'Corporate Social Responsibility (CSR)',
                'content' => 'Program CSR Klinik Mata Tritya berfokus pada peningkatan kesehatan mata masyarakat melalui edukasi dan layanan sosial.',
                'image' => 'csr.jpg'
            ]
        );

        $emc = FooterSection::updateOrCreate(
            ['slug' => 'emc'],
            [
                'title' => 'Eye Medical Center (EMC)',
                'content' => 'EMC menyediakan layanan medis mata profesional dengan teknologi modern.',
                'image' => 'emc.jpg'
            ]
        );

        $pusat_bantuan = FooterSection::updateOrCreate(
            ['slug' => 'pusat-bantuan'],
            [
                'title' => 'Pusat Bantuan',
                'content' => 'Temukan jawaban atas pertanyaan umum dan informasi layanan kami.',
                'image' => 'bantuan.jpg'
            ]
        );

        $amal = FooterSection::updateOrCreate(
            ['slug' => 'kegiatan-amal'],
            [
                'title' => 'Kegiatan Amal',
                'content' => 'Kegiatan sosial dan bakti kesehatan mata untuk masyarakat.',
                'image' => 'amal.jpg'
            ]
        );

        $privasi = FooterSection::updateOrCreate(
            ['slug' => 'kebijakan-privasi'],
            [
                'title' => 'Kebijakan Privasi',
                'content' => 'Kami menjaga dan melindungi data pribadi pasien dengan standar keamanan tinggi.',
                'image' => 'privacy.jpg'
            ]
        );

        $promo = FooterSection::updateOrCreate(
            ['slug' => 'promo'],
            [
                'title' => 'Promo',
                'content' => 'Kami menyediakan harga yang kompetitif dengan klinik ternama di Surabaya',
                'image' => 'promo.jpg'
            ]
        );

        // Hapus item lama biar tidak double
        $promo->items()->delete();

        $promo->items()->createMany([
            [
                'pemeriksaan' => 'Pemeriksaan Darah Lengkap',
                'harga_normal' => 150000,
                'harga_promo' => 120000,
                'keterangan' => 'Paket pemeriksaan darah lengkap untuk evaluasi kesehatan umum.'
            ],
            [
                'pemeriksaan' => 'Tes Kolesterol',
                'harga_normal' => 100000,
                'harga_promo' => 85000,
                'keterangan' => 'Pemeriksaan kadar kolesterol total dalam darah.'
            ],
            [
                'pemeriksaan' => 'Tes Gula Darah',
                'harga_normal' => 75000,
                'harga_promo' => 20000,
                'keterangan' => 'Pemeriksaan kadar gula darah puasa maupun sewaktu.'
            ],
        ]);
    }
}
