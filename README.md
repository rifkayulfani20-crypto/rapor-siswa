# Sistem Pengolahan Rapor Siswa

Aplikasi berbasis web untuk mengelola data siswa, guru, nilai, kehadiran, dan cetak rapor sekolah, dengan 4 peran pengguna: Admin, Guru, Siswa, dan Kepala Sekolah.

Project ini dibuat sebagai tugas Project Based Learning (PBL).

## Fitur Utama

- Manajemen data siswa, guru, kelas, dan mata pelajaran (CRUD + import/export)
- Input nilai per mata pelajaran, nilai sikap sosial & spiritual
- Rekap kehadiran dan catatan wali kelas
- Cetak rapor per siswa
- Kunci nilai oleh Kepala Sekolah (approval akhir semester)
- Login dengan pembatasan akses berdasarkan role (Admin, Guru, Siswa, Kepala Sekolah)

## Teknologi yang Digunakan

- Laravel 12
- MySQL / SQLite
- Tailwind CSS
- Vite

## Cara Menjalankan Project

1. Clone repository ini
2. Install dependency PHP:
```bash
   composer install
```
3. Salin file environment:
```bash
   cp .env.example .env
```
4. Sesuaikan konfigurasi database di file `.env`
5. Generate application key:
```bash
   php artisan key:generate
```
6. Jalankan migrasi database beserta data awal (seeder):
```bash
   php artisan migrate --seed
```
7. Install dependency frontend dan build asset:
```bash
   npm install
   npm run build
```
8. Jalankan server:
```bash
   php artisan serve
```
9. Buka `http://127.0.0.1:8000` di browser

## Struktur Role Pengguna

| Role | Akses |
|------|-------|
| Admin | Kelola seluruh data master (siswa, guru, kelas, mapel, tahun ajaran) |
| Guru | Input nilai, kehadiran, catatan wali kelas |
| Kepala Sekolah | Kunci nilai, lihat rekap nilai akhir |
| Siswa | Lihat nilai dan cetak rapor pribadi |

## Anggota Kelompok

- Rifka yulfani simanjuntak - 3312511050
- Karina sinaga  - 3312511052
- Lanna laura panjaitan - 3312511044

## Lisensi

Project ini dibuat untuk keperluan tugas akademik.