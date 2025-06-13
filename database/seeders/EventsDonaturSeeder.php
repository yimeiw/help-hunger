<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EventsDonatur;

class EventsDonaturSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EventsDonatur::insert([
            [
                'event_name' => 'Banjir Bandang di Sumatera Barat – “Food for Flood Survivors”',
                'event_description' => 'Pada awal Mei 2025, banjir bandang dan longsor melanda Kabupaten Agam dan Tanah Datar, Sumatera Barat, akibat curah hujan ekstrem yang mengguyur kawasan tersebut selama beberapa hari berturut-turut. Banjir menghanyutkan rumah, kendaraan, dan lahan pertanian, mengakibatkan ribuan warga mengungsi ke tempat-tempat darurat. Warga kehilangan akses ke dapur, air bersih, dan makanan pokok. Keterbatasan jalur distribusi akibat jalan dan jembatan yang rusak parah memperburuk kondisi logistik, sementara dapur umum yang ada tidak mampu menjangkau semua titik pengungsian. Krisis pangan akut mulai terjadi, terutama pada kelompok rentan seperti anak-anak, lansia, dan ibu hamil. Bantuan berupa makanan siap saji, bahan pokok, dan suplai air bersih sangat dibutuhkan untuk mempertahankan kesehatan dan keselamatan para penyintas.',
                'start_date' => '20-05-2024',
                'end_date' => '20-07-2024',
                'partner_id' => 1,
                'location_id' => 1,
                'status' => 'accepted',
                'image_path' => 'assets/banjir-img.svg',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'event_name' => 'Kekeringan di Nusa Tenggara Timur – “Pangan untuk Timur”',
                'event_description' => 'NTT dikenal sebagai provinsi dengan musim kering yang panjang, namun tahun 2025 mencatatkan anomali iklim yang memperpanjang musim kemarau hingga lebih dari 6 bulan. Hal ini menyebabkan gagal panen massal di berbagai kabupaten seperti Sumba Timur dan Belu. Warga mengalami kelaparan, dan ketersediaan air bersih sangat terbatas. Anak-anak mulai menunjukkan gejala kurang gizi, dan sistem irigasi tradisional tidak mampu lagi menopang kebutuhan lahan pertanian. Distribusi bantuan dari pusat sulit menjangkau desa-desa terpencil yang terputus akibat medan yang sulit. Program ini bertujuan mendistribusikan bantuan pangan langsung kepada masyarakat terdampak serta mengedukasi sistem pemanfaatan pangan darurat dengan efisiensi tinggi.',
                'start_date' => '23-6-2025',
                'end_date' => '23-8-2025',
                'partner_id' => 2,
                'location_id' => 2,
                'status' => 'accepted',
                'image_path' => 'assets/kering-img.svg',
                'created_at' => now(),
                'updated_at' => now(),
            ],

                        [
                'event_name' => 'Gizi Buruk di Papua – “Gizi untuk Asmat”',
                'event_description' => 'Asmat, Papua Selatan, masih menghadapi krisis gizi akut yang berkepanjangan. Akses transportasi yang terbatas, mahalnya harga bahan pangan, dan minimnya tenaga medis membuat banyak anak mengalami stunting dan malnutrisi berat. Masalah gizi di wilayah ini tidak hanya terjadi karena kelangkaan pangan, tetapi juga kurangnya pengetahuan tentang pola makan seimbang dan keterbatasan infrastruktur kesehatan. Seringkali, masyarakat harus berjalan jauh untuk mendapatkan makanan atau pelayanan kesehatan. Banyak anak balita menderita diare kronis dan penyakit infeksi yang memperparah kondisi gizi mereka. Kegiatan ini bertujuan untuk membawa paket makanan bergizi dan suplemen, serta melakukan edukasi tentang gizi kepada orang tua dan kader Posyandu lokal.',
                'start_date' => '25-5-2025',
                'end_date' => '10-6-2025',
                'partner_id' => 2,
                'location_id' => 3,
                'status' => 'accepted',
                'image_path' => 'assets/gizi-img.svg',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'event_name' => 'Dari Dapur ke Tenda – Bantuan Gizi untuk Pengungsi Cianjur',
                'event_description' => 'Gempa dahsyat di Cianjur meruntuhkan puluhan ribu rumah, memaksa ribuan warga bertahan di tenda darurat dengan akses pangan minim. Melalui “Dari Dapur ke Tenda”, HelpHunger mendistribusikan 5.000 paket siap santap, alat masak portabel, dan bahan pokok ke 18 titik pengungsian, fokus membantu anak-anak dan ibu hamil.
                Pada Desember 2024, gempa berkekuatan besar mengguncang Cianjur, Jawa Barat, merusak lebih dari 50.000 rumah dan memaksa sekitar 20.000 jiwa tinggal di tenda-tenda darurat. Infrastruktur dapur umum setempat tidak memadai, sedangkan akses distribusi logistik terganggu akibat kerusakan jalan dan cuaca buruk. Kondisi ini memperparah kekurangan pangan bergizi, terutama bagi anak-anak, ibu hamil, dan lansia.

                Menanggapi krisis tersebut, HelpHunger meluncurkan program “Dari Dapur ke Tenda” berjalan antara 12 Desember 2024 hingga 20 Januari 2025. Program ini bekerja sama dengan Posko Peduli Cianjur dan ACT, mengerahkan tim relawan untuk mengemas dan memasak langsung di lokasi. Donasi sebesar Rp 217.000.000 yang dikumpulkan dari 852 donaturdigunakan untuk:
                5.000 paket makanan siap santap, terdiri dari nasi, lauk (telur, ayam suwir), sayuran matang, dan buah segar
                50 set alat masak portabel termasuk kompor gas portable, panci, dan peralatan memasak ringan
                Bahan pokok seperti beras, minyak goreng, susu UHT, dan air mineral galon
                Dapur keliling agar relawan bisa memasak di berbagai titik pengungsian secara bergantian

                Distribusi dilaksanakan ke 18 titik pengungsian terpencil. Relawan tidak hanya membagikan paket, tetapi juga membantu memasak bersama warga untuk memastikan makanan hangat tersaji, sambil memberikan edukasi singkat tentang sanitasi dan gizi. Hasilnya, lebih dari 10.000 orang—termasuk 3.500 anak-anak dan 1.200 ibu hamil—mendapatkan asupan bergizi, menurunkan risiko malnutrisi dan memperkuat daya tahan tubuh di tengah situasi darurat.',
                'start_date' => '12-12-2024',
                'end_date' => '20-1-2025',
                'partner_id' => 2,
                'location_id' => 4,
                'status' => 'accepted',
                'image_path' => 'assets/dapurtenda-img.svg',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'event_name' => 'Berbagi Makan, Merajut Harapan – Untuk Anak Jalanan Jakarta',
                'event_description' => 'Jumlah anak jalanan melonjak pasca pandemi, hidup tanpa kepastian makanan, tempat tinggal, atau pendidikan. Melalui donasi, HelpHunger menyalurkan 3.000 paket makanan sehat dan mendirikan titik makan rutin. Dukungan konseling dan paket hiburan edukatif turut diberikan untuk memulihkan kondisi fisik dan mental mereka.
                Pasca pandemi COVID-19, Jakarta mengalami lonjakan signifikan jumlah anak jalanan, terutama di wilayah padat seperti Sudirman, Cempaka Putih, dan Pasar Senen. Banyak dari mereka berasal dari keluarga yang kehilangan penghasilan, terpisah dari orang tua, atau menjadi korban eksploitasi. Mereka hidup dalam ketidakpastian—tanpa asupan gizi cukup, akses ke pendidikan, atau perlindungan sosial. Dalam kondisi tersebut, banyak anak mengalami malnutrisi, tekanan psikologis, serta rentan terhadap kekerasan dan eksploitasi. Situasi ini menjadi darurat kemanusiaan tersendiri yang sering kali terabaikan karena sifatnya yang tersebar dan kurang terdokumentasi.

                Menjawab krisis ini, HelpHunger menyelenggarakan program bertajuk “Hidangan Harapan: Misi Gizi untuk Anak Jalanan”, dimulai pada 18 Maret 2025 dan berlangsung selama satu bulan penuh. Kegiatan ini didukung oleh partner Zero Food Waste Community dan Yayasan Peduli Pangan Nusantara.
                Dari hasil donasi sebesar Rp 146.500.000 yang dikumpulkan dari 608 donatur, HelpHunger:
                Mendistribusikan 3.000 paket makanan sehat berisi nasi, lauk protein (telur, ayam suwir), sayuran matang, dan buah
                Mendirikan 4 titik makan mingguan di lokasi strategis untuk memastikan akses langsung bagi anak-anak
                Membagikan 500 paket hiburan edukatif (buku cerita, alat gambar, permainan edukatif)
                Menyediakan sesi konseling ringan oleh relawan psikologi dan sosial untuk menangani trauma ringan

                Program ini tidak hanya memberi asupan gizi darurat, tetapi juga menciptakan ruang aman sementara bagi anak-anak untuk belajar dan bermain. Hasilnya, tingkat kelaparan anak jalanan di titik sasaran menurun secara signifikan selama periode program, dan beberapa anak diarahkan ke panti asuhan atau rumah singgah untuk penanganan jangka panjang.',
                'start_date' => '2-2-2025',
                'end_date' => '2-3-2025',
                'partner_id' => 2,
                'location_id' => 5,
                'status' => 'accepted',
                'image_path' => 'assets/bagimakan-img.svg',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'event_name' => 'Makan untuk Damai – Respon Cepat Krisis Yahukimo, Papua',
                'event_description' => 'Krisis pangan akibat konflik di Yahukimo memaksa ribuan warga mengungsi ke hutan. Melalui donasi, HelpHunger menyalurkan 7.000 paket makanan, air bersih, dan suplemen ke lokasi terdampak. Distribusi dilakukan via jalur darat dan udara bersama TNI untuk menyelamatkan anak-anak, lansia, dan keluarga rentan.
                Pada April 2025, Kabupaten Yahukimo, Papua, mengalami krisis kemanusiaan serius akibat konflik bersenjata antar kelompok yang memaksa lebih dari 8.000 warga meninggalkan rumah mereka dan mengungsi ke hutan maupun lokasi-lokasi pengungsian darurat. Situasi semakin memburuk karena distribusi makanan terhenti total, pasar tradisional ditutup, dan tidak adanya akses terhadap fasilitas kesehatan atau dapur umum. Anak-anak, lansia, dan ibu hamil menjadi kelompok yang paling terdampak, dengan banyak kasus kelaparan dan dehidrasi akibat cuaca ekstrem dan minimnya logistik.

                Menanggapi situasi ini, HelpHunger meluncurkan kegiatan “Makan untuk Damai – Respon Cepat Krisis Yahukimo”bekerja sama dengan Yayasan Damai Papua dan TNI Satgas Pamtas. Dalam waktu 20 hari, terkumpul dana sebesar Rp 312.800.000 dari 1.104 donatur. Donasi ini digunakan untuk menyalurkan:
                7.000 paket makanan siap santap (nasi instan, abon, biskuit tinggi kalori, dan susu UHT)
                Air mineral galon dan filter air portabel untuk sumber air alami
                Suplemen vitamin C dan multivitamin anak
                Logistik dapur sederhana seperti kompor gas, alat masak, dan beras

                Distribusi dilakukan secara intensif melalui jalur darat ke kamp pengungsian terdekat dan jalur udara ke daerah yang sulit dijangkau, dengan pengamanan dari TNI. Bantuan ini memastikan asupan gizi darurat tetap tersalurkan sambil memberi ruang bagi warga untuk membangun kembali pola makan mandiri melalui dapur komunitas kecil.

                Program ini berhasil menekan angka kelaparan akut dan memulihkan kondisi gizi lebih dari 5.500 jiwa, sekaligus menjadi bukti solidaritas nasional bagi daerah konflik yang kerap terabaikan.',
                'start_date' => '5-4-2025',
                'end_date' => '25-4-2025',
                'partner_id' => 2,
                'location_id' => 6,
                'status' => 'accepted',
                'image_path' => 'assets/yakuhimo-img.svg',
                'created_at' => now(),
                'updated_at' => now(),
            ],            
        ]);
    }
}
