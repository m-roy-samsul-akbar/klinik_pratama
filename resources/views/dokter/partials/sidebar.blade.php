@php
    $user = Auth::user();
@endphp

<!-- Sidebar -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        @if ($user && $user->isDokter())
            <li class="nav-item {{ request()->is('dokter/dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dokter.dashboard') }}">
                    <i class="fa-solid fa-chart-line menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>

            <li class="nav-item {{ request()->is('datapasien') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dokter.datapasien') }}">
                    <i class="fa-solid fa-user-injured menu-icon"></i>
                    <span class="menu-title">Data Pasien</span>
                </a>
            </li>

            <li class="nav-item nav-category mt-3">Pages</li>

            <li class="nav-item {{ request()->is('dokter/kajianawal*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dokter.kajian.index') }}">
                    <i class="fa-solid fa-user-plus menu-icon"></i>
                    <span class="menu-title">Kajian Awal</span>
                </a>
            </li>

            <li class="nav-item {{ request()->is('dokter/rekammedis') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('rekammedis.index') }}">
                    <i class="fa-solid fa-file-waveform menu-icon"></i>
                    <span class="menu-title">Rekam Medis</span>
                </a>
            </li>

            <li class="nav-item {{ request()->is('dokter/laporan') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dokter.laporan') }}">
                    <i class="fa-solid fa-file-lines menu-icon"></i>
                    <span class="menu-title">Laporan</span>
                </a>
            </li>
        @endif
    </ul>
</nav>
