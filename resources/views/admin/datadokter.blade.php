@extends('layouts.admin')

@section('title', 'Data Akun Dokter')

@section('content')

    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Data Dokter</h4>

            <div class="d-flex align-items-center action-bar">
                {{-- Filter Poli --}}
                <form method="GET" action="{{ route('dokter.index') }}" class="me-3">
                    <select name="spesialis" class="form-control form-control-sm text-dark filter-select"
                        onchange="this.form.submit()">
                        <option value="">Semua Poli</option>
                        <option value="Umum" {{ request('spesialis') == 'Umum' ? 'selected' : '' }}>Poli Umum</option>
                        <option value="Gigi" {{ request('spesialis') == 'Gigi' ? 'selected' : '' }}>Poli Gigi</option>
                    </select>
                </form>

                {{-- Tombol Tambah Data --}}
                <button type="button" class="btn btn-primary btn-sm px-3 tambah-btn" data-bs-toggle="modal"
                    data-bs-target="#tambahDokterModal">
                    <i class="mdi mdi-plus-circle-outline me-1"></i> Tambah Data Dokter
                </button>
            </div>
        </div>

        <style>
            /* Pastikan elemen rata tengah dan punya jarak rapi */
            .action-bar {
                gap: 12px;
                /* jarak antar elemen */
            }

            .filter-select {
                min-width: 140px;
                /* ukuran dropdown */
                border-radius: 6px;
            }

            .tambah-btn {
                border-radius: 20px;
                /* tombol membulat sesuai template */
                display: flex;
                align-items: center;
            }

            .tambah-btn i {
                font-size: 14px;
            }

            .toggle-password {
                position: absolute;
                top: 38px;
                right: 10px;
                cursor: pointer;
                z-index: 10;
            }
        </style>


        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Email</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Alamat</th>
                                <th>Spesialis</th>
                                <th>No. Telepon</th>
                                <th>Jam Praktek</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dokters as $dokter)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $dokter->user->email ?? '-' }}</td>
                                    <td>{{ $dokter->nama }}</td>
                                    <td>{{ $dokter->jenis_kelamin }}</td>
                                    <td>{{ $dokter->alamat }}</td>
                                    <td>{{ $dokter->spesialis }}</td>
                                    <td>{{ $dokter->telepon }}</td>
                                    <td>{{ $dokter->jam_praktek }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editDokterModal{{ $dokter->id }}">
                                            Edit
                                        </button>
                                        <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal"
                                            data-bs-target="#ubahAkunModal{{ $dokter->id }}">
                                            Ubah Akun
                                        </button>
                                        <form action="{{ route('dokter.destroy', $dokter->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-light">
                                    <td colspan="8" class="text-center text-muted">Belum ada data dokter.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Dokter -->
    <div class="modal fade" id="tambahDokterModal" tabindex="-1" aria-labelledby="tambahDokterLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('dokter.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahDokterLabel">Tambah Dokter + Akun User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        {{-- Nama Dokter --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control"
                                placeholder="Contoh: Dr. Ahmad Pratama" required>
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Login</label>
                            <input type="email" name="email" class="form-control" placeholder="email@klinik.com"
                                required>
                        </div>

                        {{-- Password --}}
                        <div class="mb-3 position-relative">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control pe-5" id="passwordInput"
                                placeholder="Minimal 6 karakter" required>
                            <span class="toggle-password" onclick="togglePasswordVisibility()">
                                <i id="passwordIcon" class="fa-solid fa-eye-slash"></i>
                            </span>
                        </div>

                        {{-- Jenis Kelamin --}}
                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-control" required>
                                <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>

                        {{-- Alamat --}}
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" name="alamat" class="form-control" placeholder="Alamat lengkap" required>
                        </div>

                        {{-- Spesialis --}}
                        <div class="mb-3">
                            <label for="spesialis" class="form-label">Spesialis</label>
                            <select name="spesialis" class="form-control" required>
                                <option value="" disabled selected>Pilih Spesialis</option>
                                <option value="Umum">Umum</option>
                                <option value="Gigi">Gigi</option>
                                <!-- Tambahkan lagi jika perlu -->
                            </select>
                        </div>

                        {{-- Telepon --}}
                        <div class="mb-3">
                            <label for="telepon" class="form-label">No. Telepon</label>
                            <input type="text" name="telepon" class="form-control" placeholder="08xxxxxxxxxx"
                                required>
                        </div>

                        {{-- Jam Mulai --}}
                        <div class="mb-3">
                            <label for="jam_mulai" class="form-label">Jam Mulai Praktik</label>
                            <input type="time" name="jam_mulai" class="form-control" required>
                        </div>

                        {{-- Jam Selesai --}}
                        <div class="mb-3">
                            <label for="jam_selesai" class="form-label">Jam Selesai Praktik</label>
                            <input type="time" name="jam_selesai" class="form-control" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Dokter -->
    @foreach ($dokters as $dokter)
        <div class="modal fade" id="editDokterModal{{ $dokter->id }}" tabindex="-1"
            aria-labelledby="editDokterLabel{{ $dokter->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('dokter.update', $dokter->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5 class="modal-title">Edit Dokter</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <!-- Email akun pengguna -->
                            <div class="mb-3">
                                <label class="form-label">Email Akun Pengguna</label>
                                <input type="email" class="form-control" value="{{ $dokter->user->email }}" readonly>
                            </div>

                            <!-- Data dokter -->
                            <div class="mb-3">
                                <label class="form-label">Nama Dokter</label>
                                <input type="text" name="nama" class="form-control" value="{{ $dokter->nama }}"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-control" required>
                                    <option value="Laki-laki"
                                        {{ $dokter->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan"
                                        {{ $dokter->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <input type="text" name="alamat" class="form-control" value="{{ $dokter->alamat }}"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Spesialis</label>
                                <select name="spesialis" class="form-control" required>
                                    <option value="Umum" {{ $dokter->spesialis == 'Umum' ? 'selected' : '' }}>Umum
                                    </option>
                                    <option value="Gigi" {{ $dokter->spesialis == 'Gigi' ? 'selected' : '' }}>Gigi
                                    </option>
                                    <!-- Tambah opsi lain jika perlu -->
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">No. Telepon</label>
                                <input type="text" name="telepon" class="form-control"
                                    value="{{ $dokter->telepon }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jam Mulai Praktik</label>
                                <input type="time" name="jam_mulai" class="form-control"
                                    value="{{ $dokter->jam_mulai }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jam Selesai Praktik</label>
                                <input type="time" name="jam_selesai" class="form-control"
                                    value="{{ $dokter->jam_selesai }}" required>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Modal Ubah Akun Dokter -->
    @foreach ($dokters as $dokter)
        <div class="modal fade" id="ubahAkunModal{{ $dokter->id }}" tabindex="-1"
            aria-labelledby="ubahAkunLabel{{ $dokter->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('dokter.updateAkun', $dokter->user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5 class="modal-title">Ubah Akun Dokter</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            {{-- Email --}}
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" value="{{ $dokter->user->email }}"
                                    class="form-control" required>
                            </div>

                            {{-- Password Baru --}}
                            <div class="mb-3 position-relative">
                                <label class="form-label">Password Baru</label>
                                <input type="password" name="password" class="form-control pe-5"
                                    id="passwordInput{{ $dokter->id }}" placeholder="Masukkan Password Baru">
                                <span class="toggle-password" onclick="togglePassword({{ $dokter->id }}, 'password')">
                                    <i id="passwordIcon{{ $dokter->id }}" class="fa-solid fa-eye-slash"></i>
                                </span>
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                            </div>

                            {{-- Konfirmasi Password --}}
                            <div class="mb-3 position-relative">
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control pe-5"
                                    id="confirmPasswordInput{{ $dokter->id }}" placeholder="Masukkan Password Baru">
                                <span class="toggle-password" onclick="togglePassword({{ $dokter->id }}, 'confirm')"
                                    style="position: absolute; top: 38px; right: 10px; cursor: pointer;">
                                    <i id="confirmIcon{{ $dokter->id }}" class="fa-solid fa-eye-slash"></i>
                                </span>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Pagination --}}
    <div class="mt-3 custom-pagination">
        {{ $dokters->appends(request()->except('page'))->links() }}
    </div>


@endsection
