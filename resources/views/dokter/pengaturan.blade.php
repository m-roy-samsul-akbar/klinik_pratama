@extends('layouts.dokter')

@section('title', 'Settings')

@section('content')
    <div class="container-fluid">
        <h4 class="mb-4">Pengaturan Akun</h4>
        <ul class="nav nav-tabs" id="settingsTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                    aria-controls="profile" aria-selected="true">Profil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="password-tab" data-toggle="tab" href="#password" role="tab"
                    aria-controls="password" aria-selected="false">Ganti Password</a>
            </li>
        </ul>

        <div class="tab-content mt-3" id="settingsTabContent">
            {{-- TAB PROFIL --}}
            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('settings.profile') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- Foto Profil --}}
                            <div class="form-group text-center mb-4">
                                <img id="current-foto"
                                    src="{{ Auth::user()->foto_profil ? asset('storage/' . Auth::user()->foto_profil) . '?v=' . time() : asset('admin/images/default-avatar.png') }}"
                                    alt="Foto Profil" class="rounded-circle mb-3"
                                    style="width: 120px; height: 120px; object-fit: cover;">

                                <img id="preview-foto" class="rounded-circle mt-2"
                                    style="width: 120px; height: 120px; object-fit: cover; display: none;">

                                <div class="mt-2">
                                    <input type="file" name="foto_profil" id="foto_profil" class="form-control-file"
                                        accept="image/*">
                                    <small class="form-text text-muted">Format: JPG, PNG. Maksimal 2MB</small>
                                </div>
                            </div>

                            {{-- Nama --}}
                            <div class="form-group">
                                <label for="name">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ Auth::user()->name }}" required>
                            </div>

                            {{-- Email --}}
                            <div class="form-group">
                                <label for="email">Alamat Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ Auth::user()->email }}" required>
                            </div>

                            <button type="submit" class="btn btn-primary mt-2">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- TAB GANTI PASSWORD --}}
            <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('settings.password') }}" method="POST">
                            @csrf
                            <div class="form-group position-relative">
                                <label for="new_password">Password Baru</label>
                                <input type="password" class="form-control pr-5" id="new_password" name="new_password"
                                    placeholder="Masukkan password baru" required style="padding-right: 40px;">
                                <span class="position-absolute"
                                    style="top: 70%; right: 12px; transform: translateY(-50%); cursor: pointer;"
                                    onclick="togglePassword('new_password', this)">
                                    <i class="mdi mdi-eye-off"></i>
                                </span>
                            </div>

                            <div class="form-group position-relative">
                                <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control pr-5" id="new_password_confirmation"
                                    name="new_password_confirmation" placeholder="Ulangi password baru" required
                                    style="padding-right: 40px;">
                                <span class="position-absolute"
                                    style="top: 70%; right: 12px; transform: translateY(-50%); cursor: pointer;"
                                    onclick="togglePassword('new_password_confirmation', this)">
                                    <i class="mdi mdi-eye-off"></i>
                                </span>
                            </div>

                            <button type="submit" class="btn btn-primary mt-2">Ganti Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Aktifkan tab Bootstrap tanpa scroll
        document.querySelectorAll('a[data-toggle="tab"]').forEach(function(tab) {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                $(this).tab('show');
            });
        });

        // Toggle visibility password
        function togglePassword(fieldId, iconSpan) {
            const input = document.getElementById(fieldId);
            const icon = iconSpan.querySelector("i");

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("mdi-eye-off");
                icon.classList.add("mdi-eye");
            } else {
                input.type = "password";
                icon.classList.remove("mdi-eye");
                icon.classList.add("mdi-eye-off");
            }
        }

        // Preview gambar profil sebelum upload
        document.getElementById('foto_profil').addEventListener('change', function(event) {
            const [file] = event.target.files;
            const preview = document.getElementById('preview-foto');
            const current = document.getElementById('current-foto');

            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
                current.style.display = 'none';
            }
        });
    </script>
@endpush
