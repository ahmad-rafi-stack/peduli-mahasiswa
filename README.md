# 🎓 Peduli Mahasiswa
### Sistem Informasi Pendataan Mahasiswa Kurang Mampu

![PHP](https://img.shields.io/badge/PHP-7.4+-777BB4?style=flat-square&logo=php&logoColor=white)
![CodeIgniter](https://img.shields.io/badge/CodeIgniter-3.x-EF4223?style=flat-square&logo=codeigniter&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-5.7+-4479A1?style=flat-square&logo=mysql&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-3.x-06B6D4?style=flat-square&logo=tailwind-css&logoColor=white)

Sistem informasi berbasis web untuk mengelola pendataan mahasiswa yang membutuhkan bantuan sosial. Dibangun dengan CodeIgniter 3 dan tampilan modern menggunakan Tailwind CSS.

---

## ✨ Fitur Utama

- 🔐 **Autentikasi Admin** — Login aman dengan validasi session
- 📊 **Dashboard Statistik** — Ringkasan data mahasiswa, dana bantuan, dan antrean
- 👨‍🎓 **Manajemen Mahasiswa** — CRUD lengkap beserta data ekonomi keluarga
- 💰 **Manajemen Bantuan Sosial** — Pencatatan dan persetujuan bantuan dengan Quick Approval
- 🔔 **Notifikasi Real-time** — Bel notifikasi untuk pengajuan bantuan yang perlu konfirmasi
- 🔍 **Live Search & Filter** — Pencarian dan filter data secara real-time
- 📱 **Fully Responsive** — Tampilan Floating Cards yang optimal di desktop dan mobile

---

## 🛠️ Teknologi

| Komponen | Teknologi |
|----------|-----------|
| Backend | PHP 7.4+ / CodeIgniter 3 |
| Database | MySQL |
| Frontend | Tailwind CSS (CDN) |
| Icons | Font Awesome 6 |
| Notifikasi | SweetAlert2 |
| Arsitektur | MVC (Model-View-Controller) |

---

## 🚀 Cara Instalasi

### Prasyarat
- XAMPP / Laragon (PHP 7.4+, MySQL)
- Web browser modern

### Langkah-langkah

**1. Clone repositori ini**
```bash
git clone https://github.com/ahmad-rafi-stack/peduli-mahasiswa.git
```

**2. Pindahkan ke folder XAMPP**
```bash
# Salin ke folder htdocs XAMPP
C:\xampp\htdocs\peduli-mahasiswa
```

**3. Setup Database**
- Buat database baru di phpMyAdmin, contoh: `db_peduli_mahasiswa`
- Import file SQL yang ada di folder `database/` (jika tersedia)

**4. Konfigurasi Database**
```bash
# Salin file contoh
cp application/config/database.example.php application/config/database.php
```
Buka `application/config/database.php` dan sesuaikan:
```php
$db['default'] = array(
    'hostname' => 'localhost',
    'username' => 'root',        // sesuaikan
    'password' => '',            // sesuaikan
    'database' => 'db_peduli_mahasiswa', // sesuaikan
    ...
);
```

**5. Konfigurasi Base URL**

Buka `application/config/config.php` dan sesuaikan:
```php
$config['base_url'] = 'http://localhost/peduli-mahasiswa/';
```

**6. Akses Aplikasi**

Buka browser dan akses:
```
http://localhost/peduli-mahasiswa/
```

---

## 📁 Struktur Proyek

```
peduli-mahasiswa/
├── application/
│   ├── config/
│   │   ├── database.example.php  ← Template konfigurasi DB
│   │   └── ...
│   ├── controllers/
│   │   ├── Auth.php
│   │   ├── Dashboard.php
│   │   ├── Mahasiswa.php
│   │   └── Bantuan.php
│   ├── models/
│   │   ├── Mahasiswa_model.php
│   │   └── Bantuan_model.php
│   ├── views/
│   │   ├── templates/
│   │   │   ├── header.php
│   │   │   └── footer.php
│   │   ├── dashboard/
│   │   ├── mahasiswa/
│   │   └── bantuan/
│   └── core/
│       └── MY_Controller.php     ← Global auth protection
├── system/                       ← CodeIgniter core
├── uploads/                      ← Foto mahasiswa (tidak di-upload)
├── .htaccess
└── index.php
```

---

## 🗄️ Struktur Database

```sql
tb_admin          -- Data akun administrator
tb_mahasiswa      -- Data biodata mahasiswa
tb_data_ekonomi   -- Data ekonomi keluarga (1:1 dengan mahasiswa)
tb_bantuan        -- Riwayat bantuan sosial (relasi ke mahasiswa)
```

Relasi menggunakan `FOREIGN KEY` dengan `ON DELETE CASCADE`.

---

## 👨‍💻 Developer

**Ahmad Rafi** — [@ahmad-rafi-stack](https://github.com/ahmad-rafi-stack)

---

## 📄 Lisensi

Proyek ini dibuat untuk keperluan tugas/proyek kuliah.
