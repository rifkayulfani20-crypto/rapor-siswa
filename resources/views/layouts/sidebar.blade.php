<nav x-show="sidebarOpen"
     class="w-52 min-h-screen bg-gray-900 fixed top-0 left-0 z-20 overflow-y-auto"
     style="transition: transform 0.3s">

    <!-- Brand -->
    <div class="flex items-center gap-3 px-4 py-4 border-b border-white/10">
        <div class="w-9 h-9 bg-blue-500 rounded-lg flex items-center justify-center text-white font-bold text-base">R</div>
        <span class="text-white font-semibold text-sm">
            {{ auth()->user()->isAdmin() ? 'ADMIN' : 'GURU' }}
        </span>
    </div>

    <div class="py-2">
        <!-- Dashboard -->
        <a href="{{ auth()->user()->isAdmin() ? route('dashboard') : route('guru.dashboard') }}"
           class="flex items-center gap-2 px-4 py-2 text-gray-300 hover:bg-white/10 hover:text-white text-sm transition
                  {{ request()->routeIs('dashboard') || request()->routeIs('guru.dashboard') ? 'bg-blue-600 text-white border-l-4 border-blue-300' : '' }}">
            <i class="fas fa-tachometer-alt w-4"></i> Dashboard
        </a>

        @if(auth()->user()->isAdmin())
        <!-- Master Data -->
        <p class="px-4 py-2 text-xs text-white/30 uppercase tracking-widest font-semibold mt-2">Master Data</p>

        <!-- Biodata (collapsible) -->
        <div x-data="{ open: {{ request()->routeIs('siswa.*') || request()->routeIs('guru.*') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                    class="w-full flex items-center justify-between px-4 py-2 text-gray-300 hover:bg-white/10 hover:text-white text-sm transition">
                <div class="flex items-center gap-2"><i class="fas fa-address-card w-4"></i> BIODATA</div>
                <i class="fas fa-chevron-right text-xs transition" :class="open ? 'rotate-90' : ''"></i>
            </button>
            <div x-show="open" x-collapse>
                <a href="{{ route('siswa.index') }}"
                   class="flex items-center gap-2 py-2 pl-10 pr-4 text-gray-400 hover:text-white hover:bg-white/5 text-sm transition
                          {{ request()->routeIs('siswa.*') ? 'text-white' : '' }}">
                    <i class="fas fa-circle text-xs"></i> Data Siswa
                </a>
                <a href="{{ route('guru.index') }}"
                   class="flex items-center gap-2 py-2 pl-10 pr-4 text-gray-400 hover:text-white hover:bg-white/5 text-sm transition
                          {{ request()->routeIs('guru.*') ? 'text-white' : '' }}">
                    <i class="fas fa-circle text-xs"></i> Data Guru
                </a>
                <a href="{{ route('kelas.index') }}"
                   class="flex items-center gap-2 py-2 pl-10 pr-4 text-gray-400 hover:text-white hover:bg-white/5 text-sm transition">
                    <i class="fas fa-circle text-xs"></i> Data Kelas
                </a>
                <a href="{{ route('mapel.index') }}"
                   class="flex items-center gap-2 py-2 pl-10 pr-4 text-gray-400 hover:text-white hover:bg-white/5 text-sm transition">
                    <i class="fas fa-circle text-xs"></i> Data Mapel
                </a>
                <a href="{{ route('pembelajaran.index') }}"
                   class="flex items-center gap-2 py-2 pl-10 pr-4 text-gray-400 hover:text-white hover:bg-white/5 text-sm transition
                          {{ request()->routeIs('pembelajaran.*') ? 'text-white' : '' }}">
                    <i class="fas fa-circle text-xs"></i> Data Pembelajaran
                </a>
            </div>
        </div>

        <!-- Raport -->
        <p class="px-4 py-2 text-xs text-white/30 uppercase tracking-widest font-semibold mt-2">Raport</p>
        <a href="{{ route('nilai.index') }}"
           class="flex items-center gap-2 px-4 py-2 text-gray-300 hover:bg-white/10 hover:text-white text-sm transition
                  {{ request()->routeIs('nilai.*') ? 'bg-blue-600 text-white border-l-4 border-blue-300' : '' }}">
            <i class="fas fa-pen w-4"></i> Input Nilai
        </a>
        <a href="{{ route('raport.index') }}"
           class="flex items-center gap-2 px-4 py-2 text-gray-300 hover:bg-white/10 hover:text-white text-sm transition
                  {{ request()->routeIs('raport.*') ? 'bg-blue-600 text-white border-l-4 border-blue-300' : '' }}">
            <i class="fas fa-print w-4"></i> Cetak Raport
        </a>
        @endif

        @if(auth()->user()->isGuru())
        <p class="px-4 py-2 text-xs text-white/30 uppercase tracking-widest font-semibold mt-2">Penilaian</p>
        <a href="{{ route('guru.mapel.nilai') }}"
           class="flex items-center gap-2 px-4 py-2 text-gray-300 hover:bg-white/10 hover:text-white text-sm transition
                  {{ request()->routeIs('guru.mapel.*') ? 'bg-blue-600 text-white border-l-4 border-blue-300' : '' }}">
            <i class="fas fa-pen w-4"></i> Input Nilai Pelajaran
        </a>
        @endif

        <p class="px-4 py-2 text-xs text-white/30 uppercase tracking-widest font-semibold mt-2">Akun</p>
        <a href="{{ route('profil') }}"
           class="flex items-center gap-2 px-4 py-2 text-gray-300 hover:bg-white/10 hover:text-white text-sm transition">
            <i class="fas fa-user w-4"></i> Profil
        </a>
    </div>
</nav>