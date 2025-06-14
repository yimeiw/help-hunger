<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EventsVolunteers;

class EventsVolunteersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EventsVolunteers::insert([
            [
                'event_name' => 'Relawan "Makan Siang Gratis"',
                'event_description' => 'Program ini bertujuan menyediakan makan siang bergizi bagi anak-anak sekolah dasar dari keluarga kurang mampu. Relawan akan membantu dalam persiapan, pengemasan, dan distribusi makanan, serta memberikan edukasi mengenai pentingnya gizi seimbang.',
                'start_date' => '2025-06-16',
                'end_date' => '2025-08-23',
                'partner_id' => 3,
                'location_id' => 1,
                'status' => 'accepted',
                'image_path' => 'assets/maksigratis-img.svg',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'event_name' => '"Dari Pasar ke Piring" – Penyelamatan Sayur & Buah di Pasar Tradisional',
                'event_description' => 'Kegiatan ini bertujuan menyelamatkan sayur dan buah layak konsumsi yang tidak terjual di pasar tradisional untuk didistribusikan kepada masyarakat yang membutuhkan. Relawan akan membantu dalam proses penyortiran, pengemasan, dan distribusi makanan, serta memberikan edukasi kepada pedagang tentang pengurangan limbah makanan.',
                'start_date' => '2025-06-30',
                'end_date' => '2025-08-30',
                'partner_id' => 3,
                'location_id' => 2,
                'status' => 'accepted',
                'image_path' => 'assets/sayurbuah-img.svg',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'event_name' => 'Wali Kota Gorontalo Distribusi Makanan Siap Saji ke Warga Terpapar Banjir',
                'event_description' => 'Kegiatan ini memberikan bantuan darurat kepada warga terdampak banjir di Kota Gorontalo melalui pendirian dapur umum, penyediaan tempat pengungsian, distribusi makanan siap saji, serta pelayanan kesehatan. Pemerintah juga berkomitmen memperbaiki infrastruktur penyebab banjir dan longsor demi mencegah kejadian serupa di masa depan.
                Pemerintah Kota Gorontalo, melalui berbagai upaya terpadu, melakukan respons cepat terhadap bencana banjir dan longsor yang melanda wilayahnya pada pertengahan Juli 2024. Penanganan yang dilakukan mencakup pendirian dapur umum untuk memenuhi kebutuhan pangan darurat, penyediaan tempat pengungsian di aula Kantor Wali Kota dan Bandayo Lo Yiladia (BLY), serta pendistribusian makanan siap saji kepada warga yang terdampak.

                Pada Jumat, 12 Juli 2024, Penjabat (Pj) Wali Kota Gorontalo, Ismail Madjid, turut terjun langsung ke lapangan untuk mendistribusikan bantuan makanan kepada masyarakat yang berada di lokasi pengungsian. Distribusi ini dilaksanakan melalui kerja sama lintas sektor yang melibatkan Pemerintah Kota Gorontalo, TNI, Polri, dan Pemerintah Provinsi Gorontalo, guna memastikan bantuan logistik menjangkau warga secara merata dan tepat sasaran.

                Selain bantuan pangan, perhatian terhadap kesehatan warga juga menjadi prioritas. Melalui Dinas Kesehatan Kota Gorontalo dan dukungan dari Universitas Negeri Gorontalo (UNG), pelayanan kesehatan darurat diberikan kepada masyarakat yang terdampak, khususnya karena tingginya risiko penyakit akibat genangan air yang berlangsung cukup lama.

                Langkah preventif juga sedang dipersiapkan oleh Pemerintah Kota dan Provinsi Gorontalo. Mereka berkomitmen untuk memperbaiki infrastruktur yang menjadi salah satu penyebab utama terjadinya banjir dan longsor. Koordinasi telah dilakukan bersama balai sungai, balai jalan, dan lembaga terkait lainnya untuk melakukan rekonstruksi serta pencegahan bencana serupa di masa mendatang. Upaya ini mencerminkan keseriusan pemerintah daerah dalam melindungi keselamatan warganya sekaligus memulihkan kondisi sosial dan lingkungan pasca bencana.',
                'start_date' => '2024-07-12',
                'end_date' => '2024-07-12',
                'partner_id' => 4,
                'location_id' => 3,
                'status' => 'accepted',
                'image_path' => 'assets/gorontalo-img.svg',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'event_name' => 'Takjil Treats (BINUS @Senayan)',
                'event_description' => 'Tujuan dari kegiatan “Takjil Treats” adalah untuk menumbuhkan rasa kepedulian sosial di kalangan BINUSIAN dengan berbagi kebahagiaan dan berkah Ramadan melalui pembagian takjil kepada masyarakat sekitar. Melalui donasi dan keterlibatan volunteer, kegiatan ini juga mempererat solidaritas dan semangat berbagi antar sesama.
                Bulan Ramadan adalah bulan yang penuh berkah, seperti yang dilakukan oleh Student Support Office BINUS @Senayan bersama Teach For Indonesia yang berbagi berkah melalui kegiatan “Takjil Treats”.
                Kegiatan berbagi takjil ini diadakan pada tanggal 1-2 April 2024 dan bertempat di sekitar kampus JWC.Sebelumnya, BINUSIAN mulai dari Karyawan dan Mahasiswa BINUS @Senayan telah mendonasikan snack atau minuman untuk dibuat bingkisan takjil.

                Para volunteer membantu mengemas snack dan minuman ke dalam plastik yang telah disediakan. Setelah dikemas, para volunteer membagikan bingkisan takjil tersebut ke pengguna jalan di sekitar BINUS @Senayan.

                Selain dapat meningkatkan rasa peduli dengan sesama, berbagi takjil ini dapat merasakan ibdahnya berbagi keberkahan dengan orang lain.',
                'start_date' => '2024-04-01',
                'end_date' => '2024-04-02',
                'partner_id' => 3,
                'location_id' => 4,
                'status' => 'accepted',
                'image_path' => 'assets/takjil-img.svg',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'event_name' => 'Disney 100 VoluntEARS Event with Rise Against Hunger',
                'event_description' => 'Kegiatan untuk memperkuat ketahanan pangan bagi masyarakat kurang mampu melalui pengemasan 50.000 bahan makanan, serta menumbuhkan semangat sosial dan kepedulian. Melibatkan BINUSIAN dan mitra global seperti Disney, kegiatan ini mendorong kontribusi nyata dalam membantu sesama melalui aksi kerelawanan lintas negara.
                BINUS University melalui Teach for Indonesia dan Student Support Office bersama dengan Walt Disney Indonesia, Rise Against Hunger, dan Hope Worldwide Indonesia menyelenggarakan kegiatan sosial “Disney 100 VoluntEARS Event with Rise Against Hunger”. Kegiatan ini dilakukan dalam rangka merayakan ulang tahun Disney ke 100 dan dalam rangka memperkuat ketahanan pangan bagi masyarakat kurang mampu.

                Sejumlah 130 volunteer yang terdiri dari Mahasiswa BINUS University, karyawan BINUS University, dan juga 39 volunteer dari Disney ikut melakukan pengemasan sebanyak 50.000 bahan makanan yang terdiri dari beras,sayuran kering dan kacang hijau. Bahan makanan yang sudah dikemas akan di distribusikan ke Posyandu yang ada di Jakarta. Kegiatan Disney VoluntEARS dilakukan di 3 Negara yaitu Singapura, Filipina dan Indonesia. Kegiatan Disney VoluntEARS menjadi salah satu kegiatan volunteer terbesar yang dilaksanakan Disney di Asia Tenggara.

                Kegiatan Disney VoluntEARS juga di hadiri oleh Dr. Nelly, S.Kom., M.M. selaku Rektor BINUS UNIVERSITY, Dr. Ir. Yohannes Kurniawan, S.Kom., S.E., MMSI. selaku Vice Rector Student Affairs BINUS University, Irma Irawati Ibrahim, SS., M.Kom. selaku Deputy Campus Director BINUS @Alam Sutera, Ibu Tursiana Setyohapsari selaku Head Of Corporate Communication The Walt Disney Company dan Tiki Keh selaku President Rise Against Hunger Malaysia.

                Melalui kegiatan ini, diharapkan para BINUSIAN dapat terus berkontribusi bagi masyarakat salah satunya dengan kegiatan pengemasan bahan makanan untuk masyarakat yang kurang mampu. Selain itu, kegiatan ini dapat meningkatkan jiwa social dan rasa saling peduli kepada masyarakat di sekitarnya.',
                'start_date' => '2025-09-21',
                'end_date' => '2025-09-21',
                'partner_id' => 4,
                'location_id' => 5,
                'status' => 'accepted',
                'image_path' => 'assets/disney-img.svg',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'event_name' => 'Mahasiswa Budi Luhur & Meiji Jepang Bagikan Makanan Gratis',
                'event_description' => 'Relawan memperkenalkan kuliner Indonesia kepada mahasiswa luar, memperat hubungan mahasiswa antara dua negara, dan memperkuat pemahaman lintas budaya. Kegiatan ini juga menciptakan interaksi langsung dengan masyarakat lokal melalui berbagi makanan, sekaligus mengembangkan keterampilan sosial dan kolaboratif para peserta.

                Sebuah kegiatan kolaboratif lintas negara berlangsung antara mahasiswa Meiji University, Jepang, dan Universitas Budi Luhur, Jakarta, dalam bentuk sesi memasak bersama yang mengangkat kuliner tradisional Indonesia. Bertempat di dapur praktik Universitas Budi Luhur, para volunteer dari Meiji University disambut hangat oleh mahasiswa tuan rumah yang bertugas sebagai “buddies”. Mereka bertindak sebagai pendamping yang membantu mengenalkan budaya serta menjelaskan langkah-langkah memasak secara langsung.

                Dengan antusiasme tinggi, para peserta internasional mempelajari cara memasak rendang, tumis buncis, dan bihun goreng—tiga hidangan populer yang merepresentasikan kekayaan rasa dan teknik masakan Indonesia. Kegiatan ini tidak hanya melibatkan proses memasak, tetapi juga edukasi seputar sejarah, bahan dasar lokal, serta filosofi di balik setiap hidangan yang dijelaskan oleh dosen kuliner dari Universitas Budi Luhur.

                Setelah sesi memasak selesai, seluruh makanan yang telah dipersiapkan dikemas rapi dan dibagikan kepada masyarakat sekitar kampus, khususnya warga yang membutuhkan. Proses pembagian makanan dilakukan langsung oleh mahasiswa Meiji dan Budi Luhur sebagai bagian dari aktivitas pelayanan masyarakat, menciptakan ruang interaksi yang humanis dan bermakna antara mahasiswa asing dan komunitas lokal.

                Kegiatan ini merupakan bagian dari program pertukaran budaya tahunan antara kedua universitas yang bertujuan memperkenalkan budaya Indonesia secara langsung kepada mahasiswa asing. Di sisi lain, mahasiswa lokal juga memperoleh pengalaman berharga dalam membangun jejaring internasional, memperluas wawasan global, serta meningkatkan kemampuan komunikasi lintas budaya.
                Secara keseluruhan, kegiatan ini tidak hanya menekankan nilai edukatif dan kuliner, tetapi juga menumbuhkan empati sosial, kerja sama lintas bangsa, serta membentuk generasi muda yang lebih terbuka terhadap keberagaman budaya global.',
                'start_date' => '2024-08-09',
                'end_date' => '2024-08-09',
                'partner_id' => 3,
                'location_id' => 6,
                'status' => 'accepted',
                'image_path' => 'assets/meiji-img.svg',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
