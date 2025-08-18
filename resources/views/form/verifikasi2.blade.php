@extends('layouts.verifikasi2')

@section('title', 'Pilih Jadwal Dokter')

@section('header', 'Pilih Jadwal Dokter')

@section('content')
  <p><b>Silahkan Pilih Jadwal Dokter</b></p>

  <div class="progress-bar">
    <div class="progress-step">1</div>
    <div class="progress-line"></div>
    <div class="progress-step active">2</div>
    <div class="progress-line"></div>
    <div class="progress-step">3</div>
    <div class="progress-line"></div>
    <div class="progress-step">4</div>
  </div>

    <div class="form-group">
      <label for="poliklinik">Poliklinik</label>
      <select id="poliklinik" name="nama_poli" required>
        <option value="" disabled selected>-- Pilih Poliklinik --</option>
        <option value="Poliklinik A">Poli Umum</option>
        <option value="Poliklinik B">Poli Gigi</option>
      </select>
    </div>

    <div class="form-group">
      <label for="dokter">Dokter</label>
      <select id="dokter" name="nama_dokter" required>
        <option value="" disabled selected>-- Pilih Dokter --</option>
        <option value="Dokter A">Dokter A</option>
        <option value="Dokter B">Dokter B</option>
      </select>
    </div>

    <div class="form-group">
      <label for="date">Tanggal Booking</label>
      <input type="date" id="date" name="tanggal_booking" required />
    </div>

    <div class="buttons">
      <button class="btn btn-secondary" type="button" onclick="history.back()">Kembali</button>
      <button class="btn btn-primary" type="submit">Lanjutkan</button>
    </div>
  </form>
@endsection
