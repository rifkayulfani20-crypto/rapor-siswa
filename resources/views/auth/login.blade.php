<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login – Sistem Pengolahan Rapor Siswa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-content-center bg-gradient-to-br from-slate-900 via-slate-700 to-blue-500 flex justify-center">

<div class="bg-white rounded-2xl shadow-2xl p-10 w-full max-w-md mx-4">

    {{-- Header --}}
    <div class="text-center mb-7">
        <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-3">
            <i class="fas fa-graduation-cap text-white text-2xl"></i>
        </div>
        <h1 class="text-lg font-bold text-slate-800">sistem pengolahan rapor siswa</h1>
        <p class="text-sm text-slate-400 mt-1">Silakan masuk untuk melanjutkan</p>
    </div>

    {{-- Error --}}
    @if($errors->any())
        <div class="flex items-center gap-2 bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3 rounded-lg mb-4">
            <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
        </div>
    @endif
    @if(session('error'))
        <div class="flex items-center gap-2 bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3 rounded-lg mb-4">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <input type="hidden" name="role" id="input-role" value="">

        {{-- Login Sebagai --}}
        <div class="mb-4">
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Login Sebagai</label>
            <div class="relative">
                <i class="fas fa-users absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                <select onchange="updateRole(this)"
                    class="w-full pl-9 pr-9 py-2.5 border border-slate-300 rounded-lg text-sm text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 appearance-none cursor-pointer">
                    <option value="">-- Pilih Role --</option>
                    <option value="admin"   {{ old('role') == 'admin'   ? 'selected' : '' }}>Admin</option>
                    <option value="guru"    {{ old('role') == 'guru'    ? 'selected' : '' }}>Guru</option>
                    <option value="siswa"   {{ old('role') == 'siswa'   ? 'selected' : '' }}>Siswa</option>
                    <option value="kepsek"  {{ old('role') == 'kepsek'  ? 'selected' : '' }}>Kepala Sekolah</option>
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
            </div>
        </div>

        {{-- Badge Role --}}
        <div id="role-badge" class="hidden mb-4">
            <span id="role-badge-inner" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold">
                <i id="badge-icon" class="fas fa-shield-alt"></i>
                <span id="badge-text">Admin</span>
            </span>
        </div>

        {{-- Email --}}
        <div class="mb-4">
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Email</label>
            <div class="relative">
                <i class="fas fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                <input type="email" name="email"
                    value="{{ old('email') }}"
                    placeholder="contoh@email.com"
                    required autofocus
                    class="w-full pl-9 pr-4 py-2.5 border border-slate-300 rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 @error('email') border-red-400 @enderror">
            </div>
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div class="mb-6">
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Password</label>
            <div class="relative">
                <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                <input type="password" name="password" id="password"
                    placeholder="••••••••"
                    required
                    class="w-full pl-9 pr-10 py-2.5 border border-slate-300 rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                <button type="button" onclick="togglePw()"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-blue-500 transition-colors">
                    <i class="fas fa-eye text-sm" id="pw-icon"></i>
                </button>
            </div>
        </div>

        {{-- Submit --}}
        <button type="submit"
            class="w-full py-3 bg-blue-500 hover:bg-blue-600 active:scale-95 text-white font-semibold rounded-lg text-sm transition-all flex items-center justify-center gap-2">
            <i class="fas fa-sign-in-alt"></i> Masuk
        </button>

    </form>

</div>

<script>
    const roleConfig = {
        admin:  { icon: 'fas fa-shield-alt',         label: 'Admin',          color: 'text-blue-600',   bg: 'bg-blue-50'   },
        guru:   { icon: 'fas fa-chalkboard-teacher', label: 'Guru',           color: 'text-green-600',  bg: 'bg-green-50'  },
        siswa:  { icon: 'fas fa-user-graduate',      label: 'Siswa',          color: 'text-orange-500', bg: 'bg-orange-50' },
        kepsek: { icon: 'fas fa-user-tie',           label: 'Kepala Sekolah', color: 'text-purple-600', bg: 'bg-purple-50' },
    };

    function updateRole(select) {
        const val   = select.value;
        const badge = document.getElementById('role-badge');
        const inner = document.getElementById('role-badge-inner');
        const iconEl = document.getElementById('badge-icon');
        const textEl = document.getElementById('badge-text');

        document.getElementById('input-role').value = val;

        if (!val) { badge.classList.add('hidden'); return; }

        const cfg = roleConfig[val];

        inner.className = 'inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold ' + cfg.bg + ' ' + cfg.color;
        iconEl.className = cfg.icon + ' ' + cfg.color;
        textEl.textContent = cfg.label;

        badge.classList.remove('hidden');
    }

    function togglePw() {
        const pw   = document.getElementById('password');
        const icon = document.getElementById('pw-icon');
        if (pw.type === 'password') {
            pw.type = 'text';
            icon.className = 'fas fa-eye-slash text-sm';
        } else {
            pw.type = 'password';
            icon.className = 'fas fa-eye text-sm';
        }
    }

    // Restore badge jika ada old('role')
    const sel = document.querySelector('select');
    if (sel && sel.value) updateRole(sel);
</script>

</body>
</html>