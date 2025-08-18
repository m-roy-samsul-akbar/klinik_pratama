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

        <ul class="navbar-nav navbar-nav-right">
            <!-- Profil -->
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center profile-link" href="#"
                    data-toggle="dropdown" id="profileDropdown">
                    {{-- Icon profil --}}
                    <i class="mdi mdi-account-circle profile-icon"></i>
                    <span class="nav-profile-name">{{ Auth::user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <h6 class="p-3 mb-0">Profile</h6>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('admin.pengaturan') }}">
                        <i class="ti-settings text-primary"></i> Settings
                    </a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item" style="border: none; background: none;">
                            <i class="ti-power-off text-primary"></i> Logout
                        </button>
                    </form>
                </div>
            </li>

            <li class="nav-item nav-settings d-none d-lg-flex">
                <a class="nav-link" href="#">
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
