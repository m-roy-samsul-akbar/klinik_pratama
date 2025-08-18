@extends('layouts.admin')

@section('title', 'Jadwal Dokter')

@section('content')

    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Jadwal Dokter</h4>

            <div class="d-flex align-items-center action-bar">
            {{-- Filter Poli --}}
            <form method="GET" action="{{ route('jadwaldokter.index') }}" class="me-3">
                <select name="spesialis" class="form-control form-control-sm text-dark" onchange="this.form.submit()">
                    <option value="">Semua Poli</option>
                    <option value="Umum" {{ request('spesialis') == 'Umum' ? 'selected' : '' }}>Poli Umum</option>
                    <option value="Gigi" {{ request('spesialis') == 'Gigi' ? 'selected' : '' }}>Poli Gigi</option>
                </select>
            </form>

            {{-- Tombol Tambah Data --}}
                <button type="button" class="btn btn-primary btn-sm px-3 tambah-btn" data-bs-toggle="modal"
                    data-bs-target="#tambahJadwalModal">
                    <i class="mdi mdi-plus-circle-outline me-1"></i> Tambah Jadwal Dokter
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
        </style>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Dokter</th>
                                <th>Spesialis</th>
                                <th>Hari</th>
                                <th>Jam Praktek</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jadwals as $index => $jadwal)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $jadwal->dokter->nama }}</td>
                                    <td>{{ $jadwal->dokter->spesialis }}</td>
                                    <td>
                                        @foreach ((array) $jadwal->hari as $hari)
                                            <span class="badge-hari active me-1">{{ $hari }}</span>
                                        @endforeach
                                    </td>
                                    <td>{{ $jadwal->jam_praktek }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editJadwalModal{{ $jadwal->id }}">
                                            Edit
                                        </button>
                                        <form action="{{ route('jadwaldokter.destroy', $jadwal->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal Edit Jadwal -->
                                <div class="modal fade" id="editJadwalModal{{ $jadwal->id }}" tabindex="-1"
                                    aria-labelledby="editJadwalModalLabel{{ $jadwal->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('jadwaldokter.update', $jadwal->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Jadwal Dokter</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="dokter_id"
                                                        value="{{ $jadwal->dokter->id }}">

                                                    <div class="mb-3">
                                                        <label class="form-label">Nama Dokter</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $jadwal->dokter->nama }}" readonly>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Hari Praktek</label>
                                                        <div class="d-flex flex-wrap gap-2 badge-container-edit"
                                                            data-id="{{ $jadwal->id }}">
                                                            @php
                                                                $hariList = [
                                                                    'Senin',
                                                                    'Selasa',
                                                                    'Rabu',
                                                                    'Kamis',
                                                                    'Jumat',
                                                                    'Sabtu',
                                                                ];
                                                            @endphp
                                                            @foreach ($hariList as $hari)
                                                                <span
                                                                    class="badge-hari {{ in_array($hari, $jadwal->hari) ? 'active' : '' }}"
                                                                    data-hari="{{ $hari }}">{{ $hari }}</span>
                                                            @endforeach
                                                            <span
                                                                class="badge-hari badge-setiap {{ in_array('Setiap Hari', $jadwal->hari) ? 'active' : '' }}"
                                                                data-hari="Setiap Hari">Setiap Hari</span>
                                                        </div>
                                                        <input type="hidden" name="hari"
                                                            id="selected-hari-edit-{{ $jadwal->id }}"
                                                            value="{{ implode(',', $jadwal->hari) }}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Jam Praktek</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $jadwal->jam_praktek }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Belum ada jadwal dokter.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Jadwal Dokter -->
    <div class="modal fade" id="tambahJadwalModal" tabindex="-1" aria-labelledby="tambahJadwalModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('jadwaldokter.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahJadwalModalLabel">Tambah Jadwal Dokter</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="dokter" class="form-label">Nama Dokter</label>
                            <select name="dokter_id" id="dokter" class="form-control" required>
                                <option value="" disabled selected hidden>Pilih Nama Dokter</option>
                                @foreach ($dokters as $dokter)
                                    <option value="{{ $dokter->id }}" data-spesialis="{{ $dokter->spesialis }}"
                                        data-jam_mulai="{{ date('H:i', strtotime($dokter->jam_mulai)) }}"
                                        data-jam_selesai="{{ date('H:i', strtotime($dokter->jam_selesai)) }}">
                                        {{ $dokter->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="spesialis_display" class="form-label">Spesialis</label>
                            <input type="text" id="spesialis_display" class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Hari Praktek</label>
                            <div class="d-flex flex-wrap gap-2" id="badge-hari-container">
                                @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                                    <span class="badge-hari" data-hari="{{ $hari }}">{{ $hari }}</span>
                                @endforeach
                                <span class="badge-hari badge-setiap" data-hari="Setiap Hari">Setiap Hari</span>
                            </div>
                            <input type="hidden" name="hari" id="selected-hari">
                        </div>

                        <div class="mb-3">
                            <label for="jam_display" class="form-label">Jam Praktek</label>
                            <input type="text" id="jam_display" class="form-control" readonly>
                        </div>

                        <input type="hidden" name="jam_mulai" id="jam_mulai">
                        <input type="hidden" name="jam_selesai" id="jam_selesai">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
