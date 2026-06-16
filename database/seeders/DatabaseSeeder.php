<?php
namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Pembelajaran;
use App\Models\Sekolah;
use App\Models\Siswa;
use App\Models\TahunPelajaran;
use App\Models\User;
use App\Models\Nilai;
use App\Models\Kehadiran;
use App\Models\SikapSiswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Data Sekolah ─────────────────────────────────────────
        // Kolom yang tersedia: nama, npsn, nss, kode_pos, telepon, email, website, kepala_sekolah, nip_kepala_sekolah
        // (logo dan alamat sudah di-drop)
        Sekolah::create([
            'nama'               => 'MTs Rekayasa',
            'npsn'               => '69354090',
            'nss'                => '12345678',
            'kode_pos'           => '46385',
            'telepon'            => '02652701285',
            'email'              => 'mts-rekayasa@gmail.com',
            'website'            => 'www.mts-rekayasa.sch.id',
            'kepala_sekolah'     => 'Deni Ramdani, M.M',
            'nip_kepala_sekolah' => '197607092004015009',
        ]);

        // ── Tahun Pelajaran ──────────────────────────────────────
        $tapel = TahunPelajaran::create([
            'nama'              => '2023/2024',
            'semester'          => 'Ganjil',
            'tempat_pembagian'  => 'Ciamis',
            'tanggal_pembagian' => '2023-12-24',
            'aktif'             => true,
            'is_locked'         => false,
        ]);
        TahunPelajaran::create([
            'nama'              => '2023/2024',
            'semester'          => 'Genap',
            'tempat_pembagian'  => 'Ciamis',
            'tanggal_pembagian' => '2024-06-23',
            'aktif'             => false,
            'is_locked'         => false,
        ]);

        // ── Admin ────────────────────────────────────────────────
        // Kolom users: name, email, password, role
        // (email_verified_at dan remember_token sudah di-drop)
        User::create([
            'name'     => 'Elfin Pratama, S.T',
            'email'    => 'admin@mtsrekayasa.sch.id',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);
        User::create([
            'name'     => 'Erik Subianto, S.Kom',
            'email'    => 'erik@mtsrekayasa.sch.id',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        // ── Guru ─────────────────────────────────────────────────
        // Kolom gurus: nama, jenis_kelamin, nip, nuptk, tempat_lahir, tanggal_lahir, alamat, no_hp, user_id
        // (gelar sudah di-drop)
        $guruData = [
            // [nama, gelar(untuk nama user saja), jk, nip, nuptk, email, password, no_hp, tempat_lahir, tgl_lahir]
            ['Ahmad Subagyo',   'S.Pd',   'L', '76842915362507192', '87429501367582968', 'ahmad@mtsrekayasa.sch.id',  'ahmadguru',   '08231312131', 'Ciamis', '1990-01-05'],
            ['Budi Santoso',    'S.Pd',   'L', '76842915362507192', '54189072653897428', 'budi@mtsrekayasa.sch.id',   'budiguru',    '08231312123', 'Ciamis', '1990-01-05'],
            ['Dewi Rahmawati',  'S.Pd.I', 'P', null,                '87429501367582968', 'dewi@mtsrekayasa.sch.id',   'dewiguru',    '08231312131', 'Ciamis', '1990-01-05'],
            ['Hadi Pratama',    'S.T',    'L', '76842915362507192', '87429501367582968', 'hadi@mtsrekayasa.sch.id',   'hadiguru',    '08231312131', 'Ciamis', '1990-01-05'],
            ['Indah Nurul',     'S.Pd',   'P', '76842915362507192', '87429501367582968', 'indah@mtsrekayasa.sch.id',  'indahguru',   '08231312131', 'Ciamis', '1990-01-05'],
            ['Iwan Setiawan',   'S.Pd',   'L', '20956384719852360', '87429501367582968', 'iwan@mtsrekayasa.sch.id',   'iwanguru',    '08231312131', 'Ciamis', '1990-01-05'],
            ['Siti Rahayu',     'S.Pd.I', 'P', '76842915362507192', '87429501367582968', 'siti@mtsrekayasa.sch.id',   'sitiguru',    '08231312131', 'Ciamis', '1990-01-05'],
            ['Slamet Riyadi',   'S.Pd.I', 'L', '76842915362507192', '87429501367582968', 'slamet@mtsrekayasa.sch.id', 'slametguru',  '08231312131', 'Ciamis', '1990-01-05'],
            ['Titin Wulandari', 'S.Pd',   'P', '76842915362507192', '87429501367582968', 'titin@mtsrekayasa.sch.id',  'titinguru',   '08231312131', 'Ciamis', '1990-01-05'],
            ['Tri Wulandari',   'S.Pd.I', 'P', '76842915362507192', '87429501367582968', 'tri@mtsrekayasa.sch.id',    'triguru',     '08231312131', 'Ciamis', '1990-01-05'],
        ];

        $gurus = [];
        foreach ($guruData as $g) {
            $user = User::create([
                'name'     => $g[0] . ', ' . $g[1], // gelar hanya dipakai di name user
                'email'    => $g[5],
                'password' => Hash::make($g[6]),
                'role'     => 'guru',
            ]);
            $gurus[] = Guru::create([
                'user_id'       => $user->id,
                'nama'          => $g[0],
                // 'gelar' => TIDAK ADA, sudah di-drop
                'jenis_kelamin' => $g[2],
                'nip'           => $g[3],
                'nuptk'         => $g[4],
                'no_hp'         => $g[7],
                'tempat_lahir'  => $g[8],
                'tanggal_lahir' => $g[9],
                'alamat'        => 'Cihampelas, Bandung',
            ]);
        }

        // ── Kelas ────────────────────────────────────────────────
$kelasIXA   = Kelas::create(['nama' => 'IX A',  'tingkat' => 'IX',   'wali_kelas_id' => $gurus[1]->id, 'tahun_pelajaran_id' => $tapel->id]);
$kelasVIIIA = Kelas::create(['nama' => 'VIII A', 'tingkat' => 'VIII', 'wali_kelas_id' => $gurus[2]->id, 'tahun_pelajaran_id' => $tapel->id]);
$kelasVIIA  = Kelas::create(['nama' => 'VII A',  'tingkat' => 'VII',  'wali_kelas_id' => $gurus[5]->id, 'tahun_pelajaran_id' => $tapel->id]);
$kelasIXB   = Kelas::create(['nama' => 'IX B',  'tingkat' => 'IX',   'wali_kelas_id' => $gurus[7]->id, 'tahun_pelajaran_id' => $tapel->id]);

        // ── Mata Pelajaran ───────────────────────────────────────
        $mp = [];
        $mapelData = [
            ['Al-Quran Hadist',                             'Qurdis',    'A', 75, $gurus[0]->id],
            ['Akidah Akhlak',                               'Aqidah',    'A', 75, $gurus[0]->id],
            ['Fikih',                                       'Fikih',     'A', 75, $gurus[1]->id],
            ['Sejarah Kebudayaan Islam',                    'SKI',       'A', 75, $gurus[1]->id],
            ['PPKn',                                        'PPKn',      'A', 75, $gurus[2]->id],
            ['Bahasa Indonesia',                            'B.Indo',    'A', 75, $gurus[3]->id],
            ['Bahasa Arab',                                 'B.Arab',    'A', 75, $gurus[4]->id],
            ['Matematika',                                  'MTK',       'A', 75, $gurus[5]->id],
            ['Ilmu Pengetahuan Alam',                       'IPA',       'A', 75, $gurus[6]->id],
            ['Ilmu Pengetahuan Sosial',                     'IPS',       'A', 75, $gurus[7]->id],
            ['Bahasa Inggris',                              'B.Inggris', 'A', 70, $gurus[8]->id],
            ['Seni Budaya',                                 'SB',        'B', 70, $gurus[9]->id],
            ['Pendidikan Jasmani, Olahraga, dan Kesehatan', 'PJOK',      'B', 70, $gurus[0]->id],
            ['Prakarya',                                    'Prakarya',  'B', 70, $gurus[1]->id],
            ['Teknologi Informasi dan Komunikasi',          'TIK',       'B', 70, $gurus[2]->id],
            ['Bahasa Sunda',                                'B.Sunda',   'B', 70, $gurus[3]->id],
        ];
        foreach ($mapelData as $m) {
            $mp[] = MataPelajaran::create([
                'nama'               => $m[0],
                'kode'               => $m[1],
                'kelompok'           => $m[2],
                'kkm'                => $m[3],
                'guru_id'            => $m[4],
                'tahun_pelajaran_id' => $tapel->id,
            ]);
        }

        // ── Pembelajaran ─────────────────────────────────────────
        Pembelajaran::create(['guru_id' => $gurus[1]->id, 'mata_pelajaran_id' => $mp[5]->id,  'kelas_id' => $kelasIXA->id,   'tahun_pelajaran_id' => $tapel->id, 'status' => 'Aktif']);
        Pembelajaran::create(['guru_id' => $gurus[1]->id, 'mata_pelajaran_id' => $mp[12]->id, 'kelas_id' => $kelasIXA->id,   'tahun_pelajaran_id' => $tapel->id, 'status' => 'Aktif']);
        Pembelajaran::create(['guru_id' => $gurus[1]->id, 'mata_pelajaran_id' => $mp[13]->id, 'kelas_id' => $kelasIXA->id,   'tahun_pelajaran_id' => $tapel->id, 'status' => 'Aktif']);
        Pembelajaran::create(['guru_id' => $gurus[2]->id, 'mata_pelajaran_id' => $mp[8]->id,  'kelas_id' => $kelasVIIIA->id, 'tahun_pelajaran_id' => $tapel->id, 'status' => 'Aktif']);
        Pembelajaran::create(['guru_id' => $gurus[5]->id, 'mata_pelajaran_id' => $mp[7]->id,  'kelas_id' => $kelasVIIA->id,  'tahun_pelajaran_id' => $tapel->id, 'status' => 'Aktif']);

        // ── Siswa ────────────────────────────────────────────────
        // Kolom siswas yang tersisa: nama, nis, nisn, jenis_kelamin, tempat_lahir, tanggal_lahir,
        // alamat, no_hp_ortu, nama_ayah, nama_ibu, nama_wali, kelas_id, status, user_id
        // (telepon, agama, jenis_pendaftaran, diterima_pada, anak_ke, pekerjaan_* sudah di-drop)
        $siswaList = [
            // [nama, nis, nisn, jk, kelas_id, tgl_lahir, email, password]
            ['Alfitka',       '024342098', '3030923424', 'L', $kelasVIIA->id,  '2004-12-15', 'alfitka@siswa.com',   'alfitka123'],
            ['Andre',         '024342401', '3035422401', 'L', $kelasIXA->id,   '2004-10-01', 'andre@siswa.com',     'andre123'],
            ['Bunga',         '024342121', '3035423409', 'P', $kelasIXA->id,   '2004-05-20', 'bunga@siswa.com',     'bunga123'],
            ['Dimas',         '024342404', '3035422213', 'L', $kelasIXA->id,   '2004-10-03', 'dimas@siswa.com',     'dimas123'],
            ['Dwi',           '024342409', '3035422409', 'P', $kelasIXA->id,   '2004-10-09', 'dwi@siswa.com',       'dwi123'],
            ['Elfan Saputra', '024342412', '3035423424', 'L', $kelasIXA->id,   '2005-01-05', 'elfan@siswa.com',     'elfan123'],
            ['Khikmal',       '024342407', '3035422407', 'L', $kelasIXA->id,   '2004-10-07', 'khikmal@siswa.com',   'khikmal123'],
            ['Rafli',         '024342406', '3035422406', 'L', $kelasIXA->id,   '2004-10-06', 'rafli@siswa.com',     'rafli123'],
            ['Renal',         '024342402', '3035422403', 'L', $kelasIXA->id,   '2004-10-02', 'renal@siswa.com',     'renal123'],
            ['Rifaul',        '024112410', '3030422410', 'P', $kelasIXA->id,   '2004-10-10', 'rifaul@siswa.com',    'rifaul123'],
            ['Sinta',         '024342500', '3035425001', 'P', $kelasVIIIA->id, '2005-03-12', 'sinta@siswa.com',     'sinta123'],
            ['Maya',          '024342501', '3035425002', 'P', $kelasVIIIA->id, '2005-04-15', 'maya@siswa.com',      'maya123'],
        ];

        $siswas = [];
foreach ($siswaList as $s) {
    $siswas[] = Siswa::create([
        'nama'          => $s[0],
        'nis'           => $s[1],
        'nisn'          => $s[2],
        'jenis_kelamin' => $s[3],
        'kelas_id'      => $s[4],
        'tanggal_lahir' => $s[5],
        'tempat_lahir'  => 'Ciamis',
        'alamat'        => 'Lakbok',
        'nama_ayah'     => 'Herman',
        'nama_ibu'      => 'Tasrifah',
        'no_hp_ortu'    => '081234567890',
        'status'        => 'Aktif',
    ]);
}

        // ── Nilai Dummy ──────────────────────────────────────────
        $nilaiMapel = array_slice($mp, 0, 5);
        foreach ($siswas as $siswa) {
            foreach ($nilaiMapel as $mapel) {
                $np   = rand(70, 95);
                $nk   = rand(70, 95);
                $pts  = rand(65, 90);
                $pas  = rand(65, 90);
                $na   = round(($np + $nk + $pts + $pas) / 4, 2);
                $pred = $na >= 90 ? 'Sangat Baik' : ($na >= 80 ? 'Baik' : ($na >= 70 ? 'Cukup' : 'Perlu Bimbingan'));
                Nilai::create([
                    'siswa_id'           => $siswa->id,
                    'mata_pelajaran_id'  => $mapel->id,
                    'tahun_pelajaran_id' => $tapel->id,
                    'nilai_pengetahuan'  => $np,
                    'nilai_keterampilan' => $nk,
                    'nilai_pts'          => $pts,
                    'nilai_pas'          => $pas,
                    'nilai_akhir'        => $na,
                    'deskripsi'          => 'Menunjukkan penguasaan materi yang ' . strtolower($pred) . '.',
                ]);
            }
        }

        // ── Kehadiran Dummy ──────────────────────────────────────
        foreach ($siswas as $siswa) {
            Kehadiran::create([
                'siswa_id'           => $siswa->id,
                'tahun_pelajaran_id' => $tapel->id,
                'sakit'              => rand(0, 5),
                'izin'               => rand(0, 3),
                'tanpa_keterangan'   => rand(0, 2),
            ]);
        }

        // ── Sikap Dummy ──────────────────────────────────────────
        $predikatList = ['Sangat Baik', 'Baik', 'Cukup'];
        foreach ($siswas as $siswa) {
            SikapSiswa::create([
                'siswa_id'            => $siswa->id,
                'kelas_id'            => $siswa->kelas_id,
                'tahun_pelajaran_id'  => $tapel->id,
                'predikat_sosial'     => $predikatList[rand(0, 2)],
                'predikat_spiritual'  => $predikatList[rand(0, 1)],
                'deskripsi_sosial'    => 'Peserta didik menunjukkan sikap sosial yang baik.',
                'deskripsi_spiritual' => 'Peserta didik menunjukkan sikap spiritual yang baik.',
            ]);
        }
    }
}