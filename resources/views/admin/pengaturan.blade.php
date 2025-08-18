@extends('layouts.admin')

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
            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('settings.profile') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ Auth::user()->name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Alamat Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ Auth::user()->email }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Simpan Profil</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('settings.password') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="new_password">Password Baru</label>
                                <input type="password" class="form-control" id="new_password" name="new_password"
                                    placeholder="Masukkan password baru" required>
                            </div>
                            <div class="form-group">
                                <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" id="new_password_confirmation"
                                    name="new_password_confirmation" placeholder="Ulangi password baru" required>
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
        document.querySelectorAll('a[data-toggle="tab"]').forEach(function(tab) {
            tab.addEventListener('click', function(e) {
                e.preventDefault(); // cegah scroll ke anchor
                $(this).tab('show'); // aktifkan tab bootstrap
            });
        });
    </script>
@endpush
