@php
    // Penanda untuk aktifkan collapse menu Data Dokter
    $dokterActive = request()->is('admin/datadokter*') || request()->is('admin/jadwaldokter*');
@endphp

<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.dashboard') }}">
        <i class="fa-solid fa-chart-line menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link {{ $dokterActive ? '' : 'collapsed' }}" data-bs-toggle="collapse" href="#ui-basic"
         aria-expanded="{{ $dokterActive ? 'true' : 'false' }}" aria-controls="ui-basic">
        <i class="fa-solid fa-user-doctor menu-icon"></i>
        <span class="menu-title">Data Dokter</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ $dokterActive ? 'show' : '' }}" id="ui-basic">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link {{ request()->is('admin/datadokter') ? 'active' : '' }}" href="{{ route('admin.datadokter') }}">Data Dokter</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->is('admin/jadwaldokter') ? 'active' : '' }}" href="{{ route('jadwaldokter.index') }}">Jadwal Dokter</a>
          </li>
        </ul>
      </div>
    </li>

    {{-- <li class="nav-item {{ request()->is('admin/datapasien') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.datapasien') }}">
        <i class="fa-solid fa-user-injured menu-icon"></i>
        <span class="menu-title">Data Pasien</span>
      </a>
    </li> --}}

    <li class="nav-item nav-category mt-3">Pages</li>

    <li class="nav-item {{ request()->is('admin/pendaftaran*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.pendaftaran') }}">
        <i class="fa-solid fa-user-plus menu-icon"></i>
        <span class="menu-title">Registrasi Pasien</span>
      </a>
    </li>

    {{-- <li class="nav-item {{ request()->is('admin/kajianawal') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.kajianawal') }}">
        <i class="fa-solid fa-notes-medical menu-icon"></i>
        <span class="menu-title">Kajian Awal</span>
      </a>
    </li> --}}

    <li class="nav-item {{ request()->is('admin/dataantrian') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.dataantrian') }}">
        <i class="fa-solid fa-clipboard-list menu-icon"></i>
        <span class="menu-title">Antrian Pasien</span>
      </a>
    </li>

    {{-- <li class="nav-item {{ request()->is('admin/rekammedis') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('rekammedis.index') }}">
        <i class="fa-solid fa-file-waveform menu-icon"></i>
        <span class="menu-title">Rekam Medis</span>
      </a>
    </li> --}}

    {{-- <li class="nav-item {{ request()->is('admin/laporan') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.laporan') }}">
        <i class="fa-solid fa-file-lines menu-icon"></i>
        <span class="menu-title">Laporan</span>
      </a>
    </li> --}}
    
  </ul>
</nav>
