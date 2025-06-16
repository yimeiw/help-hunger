# HelpHunger

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel)
![SQLite](https://img.shields.io/badge/Database-SQLite-07405E?style=for-the-badge&logo=sqlite)
![License](https://img.shields.io/badge/License-MIT-blue.svg?style=for-the-badge)

---

## Deskripsi Proyek

Indonesia, meskipun mengalami penurunan skor Indeks Kelaparan Global (GHI) setiap delapan tahun, masih menghadapi tantangan serius dalam mencapai ketahanan pangan dan nutrisi. Dengan skor GHI 16.9, Indonesia menduduki peringkat ketiga di Asia Tenggara dengan tingkat kelaparan tertinggi, di bawah Timor Leste (27) dan Laos (19.8). Daerah seperti Papua dan NTT secara khusus dikenal menghadapi kendala signifikan dalam hal ini.

**HelpHunger** adalah sebuah platform web yang dibangun untuk berkontribusi pada pencapaian Tujuan Pembangunan Berkelanjutan (SDG) kedua, yaitu mengakhiri kelaparan, mencapai ketahanan pangan, dan memperbaiki nutrisi. Aplikasi ini bertujuan untuk membantu daerah-daerah yang dilanda kemiskinan di Indonesia melalui pengiriman *volunteer* dan penyaluran donasi.

---

## Fitur Utama

* **Pendaftaran Volunteer:** Memungkinkan individu untuk mendaftar sebagai *volunteer* dan berkontribusi langsung di lapangan.
* **Donasi Makanan:** Memfasilitasi proses donasi makanan dari individu atau organisasi kepada mereka yang membutuhkan.
* **Peta Lokasi Bantuan Makanan:** Menyediakan visualisasi lokasi distribusi bantuan makanan untuk efisiensi penyaluran.
* **Notifikasi Real-time:** Memberikan pembaruan instan kepada *volunteer* dan donatur mengenai status kegiatan dan donasi.
* **Integrasi dengan Lembaga Sosial:** Membangun koneksi dan pelaporan donasi yang transparan dengan lembaga-lembaga sosial terkait.
* **Profil dan Riwayat Donasi:** Pengguna dapat melihat riwayat donasi dan aktivitas *volunteer* mereka.

---

## Teknologi

Proyek ini dikembangkan menggunakan teknologi-teknologi berikut:

* **Laravel 11:** Framework PHP yang tangguh untuk pengembangan *back-end*.
* **SQLite:** Basis data ringan dan tanpa *server* yang cocok untuk pengembangan dan skala proyek awal.
* **HTML, CSS, JavaScript:** Untuk pengembangan antarmuka pengguna.

---

## Instalasi dan Pengaturan Proyek

Untuk menjalankan proyek ini secara lokal, ikuti langkah-langkah di bawah ini:

### Prasyarat

Pastikan Anda telah menginstal yang berikut di sistem Anda:

* **PHP** (versi 8.2 atau lebih tinggi, sesuai dengan Laravel 11)
* **Composer**
* **Node.js & NPM** (opsional, jika ada aset *frontend* yang memerlukan kompilasi)
* **Git**

### Langkah-langkah Instalasi

1.  **Klon Repositori:**
    ```bash
    git clone [https://github.com/yimeiw/help-hunger.git](https://github.com/yimeiw/help-hunger.git)
    cd help-hunger
    ```

2.  **Instal Dependensi Composer:**
    ```bash
    composer install
    ```

3.  **Buat File `.env`:**
    Salin file `.env.example` dan ubah namanya menjadi `.env`:
    ```bash
    cp .env.example .env
    ```

4.  **Konfigurasi Basis Data SQLite:**
    Pastikan baris `DB_CONNECTION` di file `.env` Anda disetel ke `sqlite`. Anda bisa menghapus atau mengomentari baris `DB_DATABASE`, `DB_USERNAME`, atau `DB_PASSWORD` karena SQLite tidak memerlukannya.

    ```env
    DB_CONNECTION=sqlite
    # DB_HOST=127.0.0.1
    # DB_PORT=3306
    # DB_DATABASE=laravel
    # DB_USERNAME=root
    # DB_PASSWORD=
    ```
    Buat file `database.sqlite` di direktori `database/`:
    ```bash
    touch database/database.sqlite
    ```

5.  **Buat Kunci Aplikasi:**
    ```bash
    php artisan key:generate
    ```

6.  **Jalankan Migrasi Basis Data:**
    Ini akan membuat tabel yang diperlukan di basis data SQLite Anda.
    ```bash
    php artisan migrate
    ```

7.  **Jalankan Server Pengembangan:**
    ```bash
    php artisan serve
    ```

    Aplikasi akan tersedia di `http://127.0.0.1:8000`.

### Instalasi Dependensi Frontend (Opsional, jika ada file JS/CSS yang perlu dikompilasi)

Jika proyek Anda menggunakan Vite (bawaan Laravel 11) atau Mix, Anda mungkin perlu menginstal dependensi NPM dan mengompilasi aset:

```bash
npm install
npm run dev # atau npm run build untuk produksi