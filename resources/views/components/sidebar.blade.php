<nav class="sidebar">
    <div class="logo">
        <h2><img src="img/LOGO-QUANTUM.png" alt="Logo Quantum" width="70"></h2>
    </div>
    <ul class="nav-menu">
        <li class="nav-item">
            <x-sidelink href="{{ route('dashboard') }}" :active="request()->is('dashboard')" data-section="home">
                <span class="nav-icon">🏠</span>
                Home
            </x-sidelink>
        </li>
        @php $role = auth()->user()->role; @endphp

        @if($role === 'admin' || $role === 'guru_bk')
            <li class="nav-item">
                <x-sidelink href="{{ route('data_siswa') }}" :active="request()->is('data_siswa')"
                            data-section="data-siswa">
                    <span class="nav-icon">👥</span>
                    Data Siswa
                </x-sidelink>
            </li>
            <li class="nav-item">
                <x-sidelink href="{{ route('penilaian_siswa') }}" :active="request()->is('penilaian_siswa')"
                            data-section="penilaian">
                    <span class="nav-icon">⭐</span>
                    Penilaian
                </x-sidelink>
            </li>
        @endif

        @if($role === 'admin' || $role === 'guru_bk' || $role === 'kepsek' || $role === 'siswa')
            <li class="nav-item">
                <x-sidelink href="{{ route('laporan_siswa') }}" :active="request()->is('laporan_siswa')"
                            data-section="laporan">
                    <span class="nav-icon">📊</span>
                    Laporan
                </x-sidelink>
            </li>
        @endif
    </ul>
    <div class="logout-section">
        <button class="logout-btn" onclick="logout()">
            <span class="nav-icon">🚪</span>
            Logout
        </button>
    </div>
    <script>
        function logout() {
            window.location.href = "{{ route('logout') }}";
        }
    </script>
</nav>
