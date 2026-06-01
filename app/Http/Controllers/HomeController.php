<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\TahunPelajaran;

class HomeController extends Controller
{
    public function index()
    {
        $tapel = TahunPelajaran::aktif();

        $stats = [
            ['value' => Siswa::count(),                    'label' => 'Total Siswa',       'description' => 'Siswa terdaftar di semua kelas'],
            ['value' => Guru::count(),                     'label' => 'Total Guru',        'description' => 'Guru aktif mengajar'],
            ['value' => Kelas::count(),                    'label' => 'Total Kelas',       'description' => 'Kelas aktif tahun ini'],
            ['value' => \App\Models\MataPelajaran::count(),'label' => 'Mata Pelajaran',    'description' => 'Mapel yang tersedia'],
        ];

        $documents = [
            [
                'type'        => 'Panduan',
                'title'       => 'Panduan Penggunaan Sistem Rapor',
                'description' => 'Panduan lengkap untuk admin, guru, dan siswa dalam menggunakan sistem pengolahan rapor.',
                'route'       => route('login'),
            ],
            [
                'type'        => 'Informasi',
                'title'       => 'Jadwal Pengisian & Pembagian Rapor',
                'description' => 'Informasi jadwal input nilai dan pembagian rapor semester ' . ($tapel?->semester ?? '-') . ' tahun pelajaran ' . ($tapel?->nama ?? '-') . '.',
                'route'       => route('login'),
            ],
        ];

        $announcements = [
            [
                'initial'     => 'AD',
                'title'       => 'Pengisian Nilai Semester ' . ($tapel?->semester ?? '-'),
                'author'      => 'Admin Sekolah',
                'date'        => now()->format('d F Y'),
                'description' => 'Kepada seluruh guru, mohon segera melakukan pengisian nilai sebelum batas waktu yang ditentukan. Pastikan semua nilai sudah diinput dengan benar.',
            ],
            [
                'initial'     => 'WK',
                'title'       => 'Pembagian Rapor ' . ($tapel?->nama ?? '-'),
                'author'      => 'Wali Kelas',
                'date'        => $tapel?->tanggal_pembagian?->format('d F Y') ?? now()->format('d F Y'),
                'description' => 'Pembagian rapor akan dilaksanakan di ' . ($tapel?->tempat_pembagian ?? 'sekolah') . '. Orang tua/wali siswa dimohon hadir tepat waktu.',
            ],
        ];

        $roleCards = [
            ['label' => 'Admin',  'item_count' => \App\Models\User::where('role','admin')->count()  . ' pengguna', 'login_route' => route('login')],
            ['label' => 'Guru',   'item_count' => Guru::count() . ' pengguna',                                      'login_route' => route('login')],
            ['label' => 'Siswa',  'item_count' => Siswa::count() . ' pengguna',                                     'login_route' => route('login')],
        ];

        $classroomSummaries = Kelas::withCount('siswas')
            ->where('tahun_pelajaran_id', $tapel?->id)
            ->get()
            ->map(fn($k) => [
                'classroom'     => $k->nama,
                'student_count' => $k->siswas_count,
            ]);

        return view('landing', compact('stats','documents','announcements','roleCards','classroomSummaries'));
    }
}
