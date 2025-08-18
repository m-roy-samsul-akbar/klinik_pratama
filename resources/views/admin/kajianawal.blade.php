@extends('layouts.admin')

@section('title', 'Kajian Awal Pasien')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Kajian Awal Pasien</h4>
        <!-- Tombol trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalKajianAwal">
            + Buat Kajian Awal
        </button>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pasien</th>
                            <th>Suhu Tubuh (°C)</th>
                            <th>Tekanan Darah (mmHg)</th>
                            <th>Tinggi Badan (cm)</th>
                            <th>Berat Badan (kg)</th>
                            <th>Keluhan</th>
                            <th>Diagnosis</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Ayu Lestari</td>
                            <td>36.7</td>
                            <td>120/80</td>
                            <td>165</td>
                            <td>55.5</td>
                            <td>Sakit kepala dan mual</td>
                            <td>Migrain</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Budi Santoso</td>
                            <td>37.1</td>
                            <td>130/85</td>
                            <td>170</td>
                            <td>68</td>
                            <td>Nyeri perut</td>
                            <td>TBC</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalKajianAwal" tabindex="-1" aria-labelledby="modalKajianAwalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="#" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="modalKajianAwalLabel">Form Kajian Awal Pasien</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label for="nama_pasien" class="form-label">Nama Pasien</label>
                <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" placeholder="Masukkan nama pasien" required>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="suhu_tubuh" class="form-label">Suhu Tubuh (°C)</label>
                    <input type="number" step="0.1" class="form-control" id="suhu_tubuh" name="suhu_tubuh" placeholder="Contoh: 36.5" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="tekanan_darah" class="form-label">Tekanan Darah (mmHg)</label>
                    <input type="text" class="form-control" id="tekanan_darah" name="tekanan_darah" placeholder="Contoh: 120/80" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="tinggi_badan" class="form-label">Tinggi Badan (cm)</label>
                    <input type="number" class="form-control" id="tinggi_badan" name="tinggi_badan" placeholder="Contoh: 170" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="berat_badan" class="form-label">Berat Badan (kg)</label>
                <input type="number" step="0.1" class="form-control" id="berat_badan" name="berat_badan" placeholder="Contoh: 65.5" required>
            </div>

            <div class="mb-3">
                <label for="keluhan" class="form-label">Keluhan Pasien</label>
                <textarea class="form-control" id="keluhan" name="keluhan" rows="4" placeholder="Deskripsikan keluhan pasien" required></textarea>
            </div>

            <div class="mb-3">
                <label for="diagnosis" class="form-label">Diagnosis</label>
                <textarea class="form-control" id="diagnosis" name="diagnosis" rows="4" placeholder="Diagnosis pasien" required></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan Kajian</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
