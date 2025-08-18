<!-- Navbar -->
<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo d-flex align-items-center" href="{{ url('/dashboard') }}" style="gap: 10px;">
            <img src="{{ asset('admin/images/logoklinik.png') }}" alt="logo" style="height: 45px; width: auto;" />
            <div class="brand-text-wrapper text-primary" style="font-family: 'Lora', sans-serif; line-height: 1.2;">
                <span class="d-block" style="font-size: 14px; font-weight: 600;">Klinik Pratama Aisyiyah</span>
                <span class="d-block" style="font-size: 13px; font-weight: 500;">Hj. Mafroh</span>
            </div>
        </a>
        <a class="navbar-brand brand-logo-mini" href="{{ url('/login') }}">
            <img src="{{ asset('admin/images/logoklinik.png') }}" alt="logo" />
        </a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="icon-menu"></span>
        </button>

        <!-- Right Icons -->
        <ul class="navbar-nav navbar-nav-right">

            <!-- Notifikasi -->
            <li class="nav-item dropdown">
                <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#"
                    data-toggle="dropdown">
                    <i class="icon-bell mx-0"></i>
                    <span class="count"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                    aria-labelledby="notificationDropdown">
                    <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-success">
                                <i class="ti-info-alt mx-0"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <h6 class="preview-subject font-weight-normal">Application Error</h6>
                            <p class="font-weight-light small-text mb-0 text-muted">Just now</p>
                        </div>
                    </a>
                </div>
            </li>

            <!-- Profil -->
            @php
                $fotoProfil = Auth::user()->foto_profil
                    ? asset('storage/' . Auth::user()->foto_profil) . '?v=' . time()
                    : asset('admin/images/faces/face29.jpg');
            @endphp

            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                    <img src="{{ $fotoProfil }}" alt="profile" style="object-fit: cover;" />
                    <span class="nav-profile-name">{{ Auth::user()->name }}</span>
                </a>

                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <h6 class="p-3 mb-0">Profile</h6>
                    <div class="dropdown-divider"></div>

                    {{-- Pengaturan berdasarkan role --}}
                    @php
                        $isAdmin = Auth::user()->hasRole('admin');
                        $isDokter = Auth::user()->hasRole('dokter');
                    @endphp

                    @if ($isAdmin)
                        <a class="dropdown-item" href="{{ route('admin.pengaturan') }}">
                            <i class="ti-settings text-primary"></i> Settings
                        </a>
                    @elseif ($isDokter)
                        <a class="dropdown-item" href="{{ route('dokter.pengaturan') }}">
                            <i class="ti-settings text-primary"></i> Settings
                        </a>
                    @endif

                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="dropdown-item"
                            style="border: none; background: none; width: 100%; text-align: left;">
                            <i class="ti-power-off text-primary"></i> Logout
                        </button>
                    </form>
                </div>
            </li>

            <li class="nav-item nav-settings d-none d-lg-flex">
                <a class="nav-link" href="/">
                    <i class="icon-ellipsis"></i>
                </a>
            </li>
        </ul>

        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="icon-menu"></span>
        </button>
    </div>
</nav>
