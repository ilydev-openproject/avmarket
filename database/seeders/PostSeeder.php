<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [

            [
                'title' => 'Madu Herbal: Kunci Kesehatan Pria dan Wanita',
                'content' => 'Madu herbal dikenal untuk meningkatkan stamina pria, mendukung kesuburan wanita, dan menjaga kesehatan umum. Produk madu kami mengandung ginseng dan ekstrak herbal, cocok untuk promil atau vitalitas. Artikel ini membahas manfaat madu herbal, cara memilih produk berkualitas, dan rekomendasi madu stamina pria serta madu kesuburan dari toko kami, semua terdaftar BPOM.',
                'meta_title' => 'Madu Herbal untuk Kesehatan Pria & Wanita',
                'meta_description' => 'Temukan madu herbal alami untuk stamina pria dan kesuburan wanita. Produk berkualitas, aman, dan BPOM!',
                'meta_keywords' => 'madu herbal, madu kesuburan, madu pria, suplemen alami',
                'kategori_id' => 1, // Herbal Umum
                'is_published' => true,
            ],
            [
                'title' => 'Spray Manjakani: Solusi Praktis untuk Kewanitaan',
                'content' => 'Spray manjakani adalah produk herbal praktis untuk menjaga kebersihan dan kesehatan area kewanitaan. Berbahan alami, produk ini membantu mengatasi keputihan dan menjaga elastisitas. Artikel ini membahas manfaat spray manjakani, cara penggunaan yang benar, dan alasan mengapa produk kami menjadi pilihan utama. Semua produk terdaftar BPOM untuk keamanan dan kualitas.',
                'meta_title' => 'Spray Manjakani Alami untuk Kewanitaan',
                'meta_description' => 'Gunakan spray manjakani alami untuk atasi keputihan dan jaga kesehatan kewanitaan. Produk aman dan BPOM!',
                'meta_keywords' => 'spray manjakani, obat keputihan herbal, kewanitaan, herbal wanita',
                'kategori_id' => 4, // Kewanitaan
                'is_published' => true,
            ],
            [
                'title' => 'Jual Herbal Alami untuk Kesehatan dan Keharmonisan',
                'content' => 'Dengan tren pencarian meningkat 900%, belanja herbal online menawarkan kenyamanan dan privasi. Kami jual herbal alami untuk pria, wanita, dan promil, termasuk madu stamina, suplemen kesuburan, dan spray manjakani. Artikel ini menjelaskan keunggulan toko kami, seperti produk BPOM, pengiriman rahasia, dan layanan pelanggan 24/7. Temukan produk herbal terbaik untuk kesehatan Anda!',
                'meta_title' => 'Jual Herbal Alami – Produk Kesehatan Terbaik',
                'meta_description' => 'Jual herbal alami untuk pria, wanita, dan promil. Temukan produk madu dan manjakani berkualitas di toko kami!',
                'meta_keywords' => 'jual herbal, toko herbal online, produk herbal, kesehatan alami',
                'kategori_id' => 1, // Herbal Umum
                'is_published' => true,
            ],
            [
                'title' => 'Herbal Mengatasi Keputihan: Tips dan Produk Alami',
                'content' => 'Keputihan bisa mengganggu jika tidak ditangani. Penyebabnya beragam, seperti infeksi atau perubahan hormon. Herbal seperti manjakani terbukti efektif mengatasi keputihan secara alami. Artikel ini membahas penyebab keputihan, manfaat herbal, dan rekomendasi produk seperti spray manjakani dan kapsul herbal kami. Semua produk aman dan terdaftar BPOM untuk kesehatan kewanitaan Anda.',
                'meta_title' => 'Herbal Mengatasi Keputihan – Solusi Alami',
                'meta_description' => 'Atasi keputihan dengan herbal mengatasi keputihan alami. Temukan manjakani dan produk aman untuk kewanitaan!',
                'meta_keywords' => 'herbal mengatasi keputihan, obat keputihan herbal, manjakani, kewanitaan',
                'kategori_id' => 4, // Kewanitaan
                'is_published' => true,
            ],
            [
                'title' => 'Obat Herbal Kesuburan Pria: Solusi Alami Promil',
                'content' => 'Kesuburan pria penting untuk keberhasilan program kehamilan. Faktor seperti stres dan pola hidup memengaruhi kualitas sperma. Obat herbal kesuburan pria, seperti suplemen berbasis madu dan ginseng, membantu meningkatkan stamina dan kesuburan. Artikel ini menjelaskan manfaat herbal untuk promil pria, produk unggulan kami, dan tips menjaga kesehatan reproduksi.',
                'meta_title' => 'Obat Herbal Kesuburan Pria – Solusi Promil',
                'meta_description' => 'Tingkatkan kesuburan dengan obat herbal kesuburan pria. Produk alami untuk promil, aman dan BPOM!',
                'meta_keywords' => 'obat herbal kesuburan pria, madu pria, promil, herbal pria',
                'kategori_id' => 3, // Promil
                'is_published' => true,
            ],
            [
                'title' => 'Manjakani Herbal Wanita: Kunci Kesehatan Kewanitaan',
                'content' => 'Manjakani adalah bahan herbal tradisional untuk kesehatan kewanitaan. Digunakan dalam spray dan kapsul, manjakani membantu mengatasi keputihan, menjaga elastisitas, dan meningkatkan kebersihan area intim. Artikel ini membahas manfaat manjakani, cara kerjanya, dan produk unggulan kami yang terdaftar BPOM. Dapatkan tips perawatan kewanitaan dengan herbal alami.',
                'meta_title' => 'Manjakani Herbal Wanita untuk Kewanitaan',
                'meta_description' => 'Temukan manjakani herbal wanita untuk atasi keputihan dan jaga kewanitaan. Produk alami dan aman!',
                'meta_keywords' => 'manjakani herbal wanita, spray manjakani, kewanitaan, herbal wanita',
                'kategori_id' => 4, // Kewanitaan
                'is_published' => true,
            ],
            [
                'title' => 'Madu Kesuburan Wanita: Dukungan Alami untuk Promil',
                'content' => 'Madu kaya antioksidan yang mendukung kesehatan reproduksi wanita, menjadikannya pilihan populer untuk program kehamilan. Madu kesuburan wanita membantu menyeimbangkan hormon dan meningkatkan kualitas sel telur. Artikel ini menjelaskan manfaat madu untuk promil, tips memilih produk berkualitas, dan rekomendasi madu kesuburan kami yang terbuat dari bahan alami dan terdaftar BPOM.',
                'meta_title' => 'Madu Kesuburan Wanita – Solusi Promil',
                'meta_description' => 'Dukung promil dengan madu kesuburan wanita alami. Produk aman untuk kesehatan reproduksi, terdaftar BPOM!',
                'meta_keywords' => 'madu kesuburan wanita, herbal promil, madu herbal, kesuburan',
                'kategori_id' => 3, // Promil
                'is_published' => true,
            ],
        ];

        foreach ($posts as $post) {
            Post::create([
                'title' => $post['title'],
                'slug' => Str::slug($post['title']),
                'content' => $post['content'],
                'meta_title' => $post['meta_title'],
                'meta_description' => $post['meta_description'],
                'meta_keywords' => $post['meta_keywords'],
                'kategori_id' => $post['kategori_id'],
                'is_published' => $post['is_published'],
            ]);
        }
    }
}
