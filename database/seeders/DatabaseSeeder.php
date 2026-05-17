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
use App\Models\WaliSiswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Data Sekolah ───────────────────────────────────────────
        Sekolah::create([
            'nama'               => 'MTs Rekayasa',
            'npsn'               => '69354090',
            'nss'                => '12345678',
            'kode_pos'           => '46385',
            'telepon'            => '02652701285',
            'alamat'             => 'Jl. Raya Indonesia, Banjar',
            'email'              => 'mts-rekayasa@gmail.com',
            'website'            => 'www.mts-rekayasa.sch.id',
            'kepala_sekolah'     => 'Deni Ramdani, M.M',
            'nip_kepala_sekolah' => '197607092004015009',
        ]);

        // ── Tahun Pelajaran ────────────────────────────────────────
        $tapel = TahunPelajaran::create([
            'nama'              => '2023/2024',
            'semester'          => 'Ganjil',
            'tempat_pembagian'  => 'Ciamis',
            'tanggal_pembagian' => '2023-12-24',
            'aktif'             => true,
        ]);
        TahunPelajaran::create([
            'nama'              => '2023/2024',
            'semester'          => 'Genap',
            'tempat_pembagian'  => 'Ciamis',
            'tanggal_pembagian' => '2024-06-23',
            'aktif'             => false,
        ]);

        // ── Admin ──────────────────────────────────────────────────
        User::create(['name'=>'Elfin Pratama, S.T',  'username'=>'elfinadmin','email'=>'admin@mtsrekayasa.sch.id','password'=>Hash::make('admin123'),'role'=>'admin']);
        User::create(['name'=>'Erik Subianto, S.Kom','username'=>'erikadmin', 'email'=>'erik@mtsrekayasa.sch.id', 'password'=>Hash::make('admin123'),'role'=>'admin']);

        // ── Guru ───────────────────────────────────────────────────
        $guruData = [
            ['Ahmad Subagyo',   'S.Pd',   'L','76842915362507192','87429501367582968','ahmad@mtsrekayasa.sch.id', 'ahmadguru',   '08231312131','Ciamis','1990-01-05'],
            ['Budi Santoso',    'S.Pd',   'L','76842915362507192','54189072653897428','budi@mtsrekayasa.sch.id',  'budiguru',    '08231312123','Ciamis','1990-01-05'],
            ['Dewi Rahmawati',  'S.Pd.I', 'P', null,              '87429501367582968','dewi@mtsrekayasa.sch.id',  'dewiguru',    '08231312131','Ciamis','1990-01-05'],
            ['Hadi Pratama',    'S.T',    'L','76842915362507192','87429501367582968','hadi@mtsrekayasa.sch.id',  'hadiguru',    '08231312131','Ciamis','1990-01-05'],
            ['Indah Nurul',     'S.Pd',   'P','76842915362507192','87429501367582968','indah@mtsrekayasa.sch.id', 'indahguru',   '08231312131','Ciamis','1990-01-05'],
            ['Iwan Setiawan',   'S.Pd',   'L','20956384719852360','87429501367582968','iwan@mtsrekayasa.sch.id',  'iwanguru',    '08231312131','Ciamis','1990-01-05'],
            ['Siti Rahayu',     'S.Pd.I', 'P','76842915362507192','87429501367582968','siti@mtsrekayasa.sch.id',  'yasrifanguru','08231312131','Ciamis','1990-01-05'],
            ['Slamet Riyadi',   'S.Pd.I', 'L','76842915362507192','87429501367582968','slamet@mtsrekayasa.sch.id','slametguru',  '08231312131','Ciamis','1990-01-05'],
            ['Titin Wulandari', 'S.Pd',   'P','76842915362507192','87429501367582968','titin@mtsrekayasa.sch.id', 'titinguru',   '08231312131','Ciamis','1990-01-05'],
            ['Tri Wulandari',   'S.Pd.I', 'P','76842915362507192','87429501367582968','tri@mtsrekayasa.sch.id',   'triguru',     '08231312131','Ciamis','1990-01-05'],
        ];
        $gurus = [];
        foreach ($guruData as $g) {
            $u = User::create(['name'=>$g[0].', '.$g[1],'username'=>$g[6],'email'=>$g[5],'password'=>Hash::make('guru123'),'role'=>'guru']);
            $gurus[] = Guru::create(['nama'=>$g[0],'gelar'=>$g[1],'jenis_kelamin'=>$g[2],'nip'=>$g[3],'nuptk'=>$g[4],'no_hp'=>$g[8],'tempat_lahir'=>$g[9],'tanggal_lahir'=>$g[10],'alamat'=>'Cihampelas, Bandung','user_id'=>$u->id]);
        }

        // ── Kelas ──────────────────────────────────────────────────
        $kelasIXA   = Kelas::create(['nama'=>'IX A',  'tingkat'=>'9','wali_kelas_id'=>$gurus[1]->id,'tahun_pelajaran_id'=>$tapel->id]);
        $kelasVIIIA = Kelas::create(['nama'=>'VIII A','tingkat'=>'8','wali_kelas_id'=>$gurus[2]->id,'tahun_pelajaran_id'=>$tapel->id]);
        $kelasVIIA  = Kelas::create(['nama'=>'VII A', 'tingkat'=>'7','wali_kelas_id'=>$gurus[5]->id,'tahun_pelajaran_id'=>$tapel->id]);
        $kelasIXB   = Kelas::create(['nama'=>'IX B',  'tingkat'=>'9','wali_kelas_id'=>$gurus[7]->id,'tahun_pelajaran_id'=>$tapel->id]);

        // ── Mata Pelajaran ─────────────────────────────────────────
        $mp = [];
        foreach ([
            ['Al-Quran Hadist','Qurdis','A',75],['Akidah Akhlak','Aqidah','A',75],
            ['Fikih','Fikih','A',75],['Sejarah Kebudayaan Islam','SKI','A',75],
            ['PPKn','PPKn','A',75],['Bahasa Indonesia','B.Indo','A',75],
            ['Bahasa Arab','B.Arab','A',75],['Matematika','MTK','A',75],
            ['Ilmu Pengetahuan Alam','IPA','A',75],['Ilmu Pengetahuan Sosial','IPS','A',75],
            ['Bahasa Inggris','B.Inggris','A',70],
            ['Seni Budaya','SB','B',70],['Pendidikan Jasmani, Olahraga, dan Kesehatan','PJOK','B',70],
            ['Prakarya','Prakarya','B',70],['Teknologi Informasi dan Komunikasi','TIK','B',70],
            ['Bahasa Sunda','B.Jawa','B',70],
        ] as $m) {
            $mp[] = MataPelajaran::create(['nama'=>$m[0],'kode'=>$m[1],'kelompok'=>$m[2],'kkm'=>$m[3],'tahun_pelajaran_id'=>$tapel->id]);
        }

        // ── Pembelajaran ───────────────────────────────────────────
        Pembelajaran::create(['guru_id'=>$gurus[1]->id,'mata_pelajaran_id'=>$mp[5]->id, 'kelas_id'=>$kelasIXA->id,  'tahun_pelajaran_id'=>$tapel->id,'status'=>'Aktif']);
        Pembelajaran::create(['guru_id'=>$gurus[1]->id,'mata_pelajaran_id'=>$mp[12]->id,'kelas_id'=>$kelasIXA->id,  'tahun_pelajaran_id'=>$tapel->id,'status'=>'Aktif']);
        Pembelajaran::create(['guru_id'=>$gurus[1]->id,'mata_pelajaran_id'=>$mp[13]->id,'kelas_id'=>$kelasIXA->id,  'tahun_pelajaran_id'=>$tapel->id,'status'=>'Aktif']);
        Pembelajaran::create(['guru_id'=>$gurus[2]->id,'mata_pelajaran_id'=>$mp[8]->id, 'kelas_id'=>$kelasVIIIA->id,'tahun_pelajaran_id'=>$tapel->id,'status'=>'Aktif']);
        Pembelajaran::create(['guru_id'=>$gurus[5]->id,'mata_pelajaran_id'=>$mp[7]->id, 'kelas_id'=>$kelasVIIA->id, 'tahun_pelajaran_id'=>$tapel->id,'status'=>'Aktif']);

        // ── Siswa ──────────────────────────────────────────────────
        $siswaList = [
            ['Alfitka',      '024342098','3030923424','L',$kelasVIIA->id, '2004-12-15','Katolik','081234567850','Siswa Pindahan'],
            ['Andre',        '024342401','3035422401','L',$kelasIXA->id,  '2004-10-01','Islam',  '081234567893','Siswa Baru'],
            ['Bunga',        '024342121','3035423409','P',$kelasIXA->id,  '2004-05-20','Islam',  '081234567891','Siswa Baru'],
            ['Dimas',        '024342404','3035422213','L',$kelasIXA->id,  '2004-10-03','Islam',  '081234567893','Siswa Baru'],
            ['Dwi',          '024342409','3035422409','P',$kelasIXA->id,  '2004-10-09','Islam',  '081234567893','Siswa Baru'],
            ['Elfan Saputra','024342412','3035423424','L',$kelasIXA->id,  '2005-01-05','Islam',  '081234567890','Siswa Baru'],
            ['Khikmal',      '024342407','3035422407','L',$kelasIXA->id,  '2004-10-07','Islam',  '081234567893','Siswa Baru'],
            ['Rafli',        '024342406','3035422406','L',$kelasIXA->id,  '2004-10-06','Islam',  '081234567893','Siswa Baru'],
            ['Renal',        '024342402','3035422403','L',$kelasIXA->id,  '2004-10-02','Islam',  '081234567893','Siswa Baru'],
            ['Rifaul',       '024112410','3030422410','P',$kelasIXA->id,  '2004-10-10','Islam',  '081234567893','Siswa Baru'],
            ['Sinta',        '024342500','3035425001','P',$kelasVIIIA->id,'2005-03-12','Islam',  '081234567893','Siswa Baru'],
            ['Maya',         '024342501','3035425002','P',$kelasVIIIA->id,'2005-04-15','Islam',  '081234567893','Siswa Baru'],
        ];
        $siswas = [];
        foreach ($siswaList as $s) {
            $siswas[] = Siswa::create([
                'nama'=>$s[0],'nis'=>$s[1],'nisn'=>$s[2],'jenis_kelamin'=>$s[3],'kelas_id'=>$s[4],
                'tanggal_lahir'=>$s[5],'agama'=>$s[6],'telepon'=>$s[7],'jenis_pendaftaran'=>$s[8],
                'tempat_lahir'=>'Ciamis','alamat'=>'Lakbok','diterima_pada'=>'2022-10-16',
                'nama_ayah'=>'Herman','nama_ibu'=>'Tasrifah','status'=>'Aktif',
            ]);
        }

        // ── Wali Siswa ─────────────────────────────────────────────
        WaliSiswa::create(['nama'=>'Herman',  'jenis_kelamin'=>'L','siswa_id'=>$siswas[5]->id,'sebagai'=>'Ayah','pekerjaan'=>'Petani',  'no_hp'=>'081234567890']);
        WaliSiswa::create(['nama'=>'Tasrifah','jenis_kelamin'=>'P','siswa_id'=>$siswas[2]->id,'sebagai'=>'Ayah','pekerjaan'=>'Pedagang','no_hp'=>'081234567891']);
    }
}