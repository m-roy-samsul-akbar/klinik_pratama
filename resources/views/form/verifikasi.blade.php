@extends('layouts.verifikasi')

@section('title', 'Verifikasi & Booking Pasien')
@section('header', 'FORMULIR VERIFIKASI & PEMILIHAN JADWAL')
@push('styles')
    <style>
        .section-title {
            text-align: center;
            font-size: 1.8rem;
            /* lebih besar, bisa diganti 2rem kalau mau */
            font-weight: bold;
            margin: 3rem 0 3rem;
            /* kasih jarak atas & bawah */
        }
    </style>
@endpush

@section('content')
    <div class="progress-bar">
        <div class="progress-step">1</div>
        <div class="progress-line"></div>
        <div class="progress-step">2</div>
        <div class="progress-line"></div>
        <div class="progress-step">3</div>
        <div class="progress-line"></div>
        <div class="progress-step">4</div>
    </div>

    <form id="formVerifikasi" method="POST" action="{{ route('registerPendaftaran.store') }}">
        @csrf

        {{-- Section 1: Data Pasien --}}
        <section id="step1" class="form-step active">
            <h3>DATA PASIEN</h3>
            <div class="form-group">
                <label>Status Pasien</label>
                <div class="form-radio-group">
                    <label><input type="radio" name="status" value="lama"> Pasien Lama</label>
                    <label><input type="radio" name="status" value="baru" checked> Pasien Baru</label>
                </div>
            </div>

            <div id="formPasienBaru" style="display:none">
                <h4 class="section-title">Data Pasien Baru</h4>
                <div class="form-group"><label>Nama</label><input type="text" name="nama"
                        placeholder="Nama Lengkap" /></div>
                <div class="form-group"><label>NIK</label><input type="text" name="nik" placeholder="NIK" /></div>
                <div class="form-group"><label>Tempat Lahir</label><input type="text" name="tempat_lahir"
                        placeholder="Tempat Lahir" /></div>
                <div class="form-group"><label>Tanggal Lahir</label><input type="date" name="tanggal_lahir" /></div>
                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <div class="radio-group">
                        <label><input type="radio" name="jenis_kelamin" value="Laki-Laki"> Laki-Laki</label>
                        <label><input type="radio" name="jenis_kelamin" value="Perempuan"> Perempuan</label>
                    </div>
                </div>
                <div class="form-group"><label>Nama Ayah</label><input type="text" name="nama_ayah"
                        placeholder="Nama Ayah" /></div>
                <div class="form-group"><label>Nama Ibu</label><input type="text" name="nama_ibu"
                        placeholder="Nama Ibu" /></div>
                <div class="form-group">
                    <label>Agama</label>
                    <select name="agama">
                        <option value="" disabled selected hidden>Pilih agama</option>
                        <option value="Islam">Islam</option>
                        <option value="Kristen">Kristen</option>
                        <option value="Katolik">Katolik</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Buddha">Buddha</option>
                        <option value="Konghucu">Konghucu</option>
                    </select>
                </div>
                <div class="form-group"><label>Alamat</label><input type="text" name="alamat" placeholder="Alamat" />
                </div>
                <div class="form-group">
                    <label>Pendidikan</label>
                    <select name="pendidikan">
                        <option disabled selected>Pilih pendidikan</option>
                        <option value="" disabled selected hidden>Pilih pendidikan</option>
                        <option value="Tidak Sekolah">Tidak Sekolah</option>
                        <option value="SD">SD</option>
                        <option value="SMP">SMP</option>
                        <option value="SMA/SMK">SMA/SMK</option>
                        <option value="Diploma">Diploma</option>
                        <option value="Sarjana">Sarjana</option>
                        <option value="Pascasarjana">Pascasarjana</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Pekerjaan</label>
                    <select name="pekerjaan">
                        <option value="" disabled selected hidden>Pilih pekerjaan</option>
                        <option value="Pelajar">Pelajar</option>
                        <option value="Petani">Petani</option>
                        <option value="Pedagang">Pedagang</option>
                        <option value="Guru">Guru</option>
                        <option value="PNS">PNS</option>
                        <option value="Karyawan Swasta">Karyawan Swasta</option>
                        <option value="Wirausaha">Wirausaha</option>
                        <option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
                        <option value="Tidak Bekerja">Tidak Bekerja</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status_perkawinan">
                        <option disabled selected>Pilih Status</option>
                        <option value="Kawin">Kawin</option>
                        <option value="Belum Kawin">Belum Kawin</option>
                        <option value="Cerai">Cerai</option>
                    </select>
                </div>

                <h4 class="section-title">Data Penanggung Jawab</h4>
                <div class="form-group">
                    <label>Hubungan Keluarga</label>
                    <select name="penanggung_hubungan">
                        <option value="" disabled selected hidden>Pilih hubungan</option>
                        <option value="Ayah">Ayah</option>
                        <option value="Ibu">Ibu</option>
                        <option value="Suami">Suami</option>
                        <option value="Istri">Istri</option>
                        <option value="Anak">Anak</option>
                        <option value="Saudara">Saudara</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="form-group"><label>Nama Penanggung Jawab</label><input type="text" name="nama_penanggung"
                        placeholder="Nama Penanggung Jawab" /></div>
                <div class="form-group"><label>Alamat</label><input type="text" name="alamat_penanggung"
                        placeholder="Alamat" /></div>
                <div class="form-group">
                    <label>Pekerjaan</label>
                    <select name="pekerjaan_penanggung">
                        <option value="" disabled selected hidden>Pilih pekerjaan</option>
                        <option value="Pelajar">Pelajar</option>
                        <option value="Petani">Petani</option>
                        <option value="Pedagang">Pedagang</option>
                        <option value="Guru">Guru</option>
                        <option value="PNS">PNS</option>
                        <option value="Karyawan Swasta">Karyawan Swasta</option>
                        <option value="Wirausaha">Wirausaha</option>
                        <option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
                        <option value="Tidak Bekerja">Tidak Bekerja</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <div class="radio-group">
                        <label><input type="radio" name="penanggung_gender" value="Laki-Laki"> Laki-Laki</label>
                        <label><input type="radio" name="penanggung_gender" value="Perempuan"> Perempuan</label>
                    </div>
                </div>
                <div class="form-group">
                    <label>Agama</label>
                    <select name="agama_penanggung">
                        <option value="" disabled selected hidden>Pilih agama</option>
                        <option value="Islam">Islam</option>
                        <option value="Kristen">Kristen</option>
                        <option value="Katolik">Katolik</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Buddha">Buddha</option>
                        <option value="Konghucu">Konghucu</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status_penanggung">
                        <option disabled selected>Pilih Status</option>
                        <option value="Kawin">Kawin</option>
                        <option value="Belum Kawin">Belum Kawin</option>
                        <option value="Cerai">Cerai</option>
                    </select>
                </div>
                <div class="form-group"><label>No. Whatsapp</label><input type="text" name="no_whatsapp"
                        placeholder="No. Whatsapp" /></div>
            </div>

            <div id="formPasienLama" style="display:none">
                <h4 class="section-title">Data Pasien Lama</h4>
                <div class="form-group"><label>No. Rekam Medis</label><input type="text" name="no_rm"
                        placeholder="Nomor Rekam Medis" /></div>
                <div class="form-group"><label>Tanggal Lahir</label><input type="date" name="tgl_lahir_lama" /></div>
            </div>

            <div class="button-group" style="margin-top:1rem">
                <button type="button" class="btn-back" onclick="history.back()">Kembali</button>
                <button type="button" class="btn-next" onclick="nextStep(2)">Lanjutkan</button>
            </div>
        </section>

        {{-- Section 2: Pilih Jadwal Dokter --}}
        <section id="step2" class="form-step" style="display:none">
            <h3>PILIH JADWAL DOKTER</h3>
            <div class="form-group">
                <label for="poliklinik">Poliklinik</label>
                <select id="poliklinik" name="nama_poli">
                    <option value="" disabled selected>-- Pilih Poliklinik --</option>
                    <option value="Poli Umum">Poli Umum</option>
                    <option value="Poli Gigi">Poli Gigi</option>
                </select>
            </div>

            <div class="form-group">
                <label for="dokter">Dokter</label>
                <select id="dokter" name="nama_dokter">
                    <option value="" disabled selected>-- Pilih Dokter --</option>
                    <option value="Dokter A">Dokter A</option>
                    <option value="Dokter B">Dokter B</option>
                </select>
            </div>

            <div class="form-group"><label>Jam Praktek</label><input type="text" name="jadwal_dokter"
                    placeholder="--,--" /></div>

            <div class="form-group">
                <label for="date">Tanggal Registrasi</label>
                <input type="date" id="date" name="tanggal_registrasi" />
            </div>

            <div class="button-group">
                <button type="button" class="btn-back" onclick="prevStep(1)">Kembali</button>
                <button type="button" class="btn-next" onclick="nextStep(3)">Lanjutkan</button>
            </div>
        </section>

        {{-- Section 2: Kode Antrian --}}
        <section id="step3" class="form-step" style="display:none; margin-top:2rem">
            <h3>NOTIFIKASI KODE ANTRIAN</h3>
            <p class="text-muted" style="margin-bottom:1rem">Masukkan nomor WhatsApp untuk menerima <strong>notifikasi
                    nomor antrian</strong>.</p>

            <div class="form-group @error('whatsapp') has-error @enderror">
                <label for="whatsapp">Nomor WhatsApp <small>(format Indonesia)</small></label>
                <input id="whatsapp" type="tel" name="whatsapp" inputmode="tel" autocomplete="tel"
                    placeholder="contoh: 0812xxxxxxx atau +62812xxxxxxx" value="{{ old('whatsapp') }}"
                    class="form-control" />
                <small class="text-muted">Gunakan awalan <strong>+62</strong> atau <strong>0</strong> (misal: +62812… atau
                    0812…).</small>
                @error('whatsapp')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="checkbox-group @error('consent') has-error @enderror" style="margin-top:1rem">
                <input type="checkbox" id="consent" name="consent" value="1"
                    {{ old('consent') ? 'checked' : '' }} />
                <label for="consent">Saya menyetujui menerima pesan WhatsApp terkait kode antrian.</label>
                @error('consent')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="button-group" style="margin-top:1rem">
                <button type="button" class="btn-back" onclick="prevStep(2)">Kembali</button>
                <button type="button" class="btn-next" onclick="nextStep(4)">Lanjutkan</button>
            </div>
        </section>

        {{-- STEP 4: PREVIEW & KONFIRMASI --}}
        <section id="step4" class="form-step" style="display:none; margin-top:2rem">
            <h3>REVIEW DATA & KONFIRMASI</h3>
            <p class="text-muted" style="margin-bottom:1rem">Periksa kembali data Anda. Jika sudah benar, tekan
                <strong>Kirim</strong>.
            </p>

            <div class="preview-grid">
                <div class="preview-card">
                    <h4>Data Pasien</h4>
                    <ul>
                        <li><strong>Status:</strong> <span data-preview="status"></span></li>
                        <li><strong>Nama:</strong> <span data-preview="nama"></span></li>
                        <li><strong>NIK:</strong> <span data-preview="nik"></span></li>
                        <li><strong>TTL:</strong> <span data-preview="ttl"></span></li>
                        <li><strong>Jenis Kelamin:</strong> <span data-preview="jenis_kelamin"></span></li>
                        <li><strong>No. HP:</strong> <span data-preview="no_hp"></span></li>
                        <li><strong>Agama:</strong> <span data-preview="agama"></span></li>
                        <li><strong>Alamat:</strong> <span data-preview="alamat"></span></li>
                        <li><strong>Pendidikan:</strong> <span data-preview="pendidikan"></span></li>
                        <li><strong>Pekerjaan:</strong> <span data-preview="pekerjaan"></span></li>
                        <li><strong>Status Kawin:</strong> <span data-preview="status_perkawinan"></span></li>
                    </ul>
                </div>
                <div class="preview-card">
                    <h4>Penanggung Jawab</h4>
                    <ul>
                        <li><strong>Hubungan:</strong> <span data-preview="hubungan"></span></li>
                        <li><strong>Nama:</strong> <span data-preview="nama_penanggung"></span></li>
                        <li><strong>Alamat:</strong> <span data-preview="alamat_penanggung"></span></li>
                        <li><strong>Gender:</strong> <span data-preview="penanggung_gender"></span></li>
                        <li><strong>Agama:</strong> <span data-preview="agama_penanggung"></span></li>
                        <li><strong>Pekerjaan:</strong> <span data-preview="pekerjaan_penanggung"></span></li>
                        <li><strong>Status:</strong> <span data-preview="status_penanggung"></span></li>
                        <li><strong>No. HP:</strong> <span data-preview="no_hp_penanggung"></span></li>
                    </ul>
                </div>
                <div class="preview-card">
                    <h4>Jadwal & Notifikasi</h4>
                    <ul>
                        <li><strong>Poliklinik:</strong> <span data-preview="nama_poli"></span></li>
                        <li><strong>Dokter:</strong> <span data-preview="nama_dokter"></span></li>
                        <li><strong>Tanggal Booking:</strong> <span data-preview="tanggal_booking"></span></li>
                        <li><strong>WhatsApp:</strong> <span data-preview="whatsapp"></span></li>
                        <li><strong>Persetujuan WA:</strong> <span data-preview="consent"></span></li>
                    </ul>
                </div>
            </div>

            <div class="button-group" style="margin-top:1rem">
                <button type="button" class="btn-back" onclick="prevStep(3)">Kembali</button>
                <button type="submit" class="btn-next">Kirim</button>
            </div>
        </section>

    </form>
@endsection

@push('styles')
    <style>
        .preview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 12px
        }

        .preview-card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 12px;
            background: #fff
        }

        .preview-card h4 {
            margin: 0 0 8px 0
        }
    </style>
@endpush

@push('styles')
    <style>
        /* Kartu & header section */
        #step3 {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, .04);
        }

        #step3 h3 {
            text-align: center;
            font-size: 1.6rem;
            letter-spacing: .3px;
            margin: 0 0 .25rem 0;
        }

        #step3 .text-muted {
            text-align: center;
            color: #6b7280;
            margin-bottom: 1rem !important;
        }

        /* Field & label */
        #step3 .form-group {
            margin-top: 1.25rem;
        }

        #step3 label {
            display: block;
            font-weight: 600;
            margin-bottom: .5rem;
        }

        #step3 .form-control {
            width: 100%;
            padding: .85rem 1rem;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            background: #f8fafc;
            transition: box-shadow .15s, border-color .15s, background .15s;
        }

        #step3 .form-control::placeholder {
            color: #9ca3af;
        }

        #step3 .form-control:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, .15);
            background: #fff;
        }

        /* Helper & error */
        #step3 .error {
            color: #dc2626;
            margin-top: .5rem;
            font-size: .875rem;
        }

        #step3 .has-error .form-control {
            border-color: #ef4444;
        }

        /* Checkbox lebih rapi */
        #step3 .checkbox-group {
            margin-top: 1.1rem !important;
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            padding: 12px 14px;
            border-radius: 10px;
            display: flex;
            align-items: flex-start;
            gap: .6rem;
        }

        #step3 .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-top: 2px;
        }

        #step3 .checkbox-group label {
            margin: 0;
            font-weight: 500;
        }

        /* Tombol */
        #step3 .button-group {
            display: flex;
            justify-content: space-between;
            gap: .75rem;
            margin-top: 1.25rem !important;
        }

        #step3 .btn-back,
        #step3 .btn-next {
            padding: .75rem 1rem;
            border-radius: 10px;
            border: 1px solid transparent;
            cursor: pointer;
        }

        #step3 .btn-next {
            background: #6366f1;
            color: #fff;
        }

        #step3 .btn-next:hover {
            background: #4f46e5;
        }

        #step3 .btn-back {
            background: #f3f4f6;
            color: #374151;
            border-color: #e5e7eb;
        }

        #step3 .btn-back:hover {
            background: #e5e7eb;
        }
    </style>
@endpush


@push('scripts')
    <script src="{{ asset('assets/js/verifikasi.js') }}"></script>
    <script>
        (function() {
            // --- Step Navigation ---
            function setActiveProgress(step) {
                const steps = document.querySelectorAll('.progress-step');
                steps.forEach((el, idx) => {
                    if (idx < step) el.classList.add('active');
                    else el.classList.remove('active');
                });
            }

            window.showStep = function(step) {
                document.querySelectorAll('.form-step').forEach(el => el.style.display = 'none');
                const section = document.getElementById('step' + step);
                if (section) section.style.display = 'block';
                setActiveProgress(step);
                if (step === 4) {
                    buildPreview();
                }
            }
            window.nextStep = function(step) {
                showStep(step);
            }
            window.prevStep = function(step) {
                showStep(step);
            }

            // --- Toggle Pasien Baru/Lama ---
            function bindStatusToggle() {
                const radios = document.querySelectorAll('input[name="status"]');
                const formBaru = document.getElementById('formPasienBaru');
                const formLama = document.getElementById('formPasienLama');

                function refresh(val) {
                    if (val === 'baru') {
                        formBaru.style.display = 'block';
                        formLama.style.display = 'none';
                    } else {
                        formBaru.style.display = 'none';
                        formLama.style.display = 'block';
                    }
                }
                radios.forEach(r => r.addEventListener('change', e => refresh(e.target.value)));
                const checked = document.querySelector('input[name="status"]:checked');
                refresh(checked ? checked.value : 'baru');
            }

            // --- Normalize WhatsApp to +62 ---
            function normalizeWhatsApp() {
                const input = document.getElementById('whatsapp');
                if (!input) return;
                const normalize = (raw) => {
                    raw = (raw || '').toString().trim().replace(/\s+/g, '');
                    if (raw.startsWith('+')) return '+' + raw.slice(1).replace(/\D/g, '');
                    return raw.replace(/\D/g, '');
                };
                const toE164ID = (val) => {
                    let v = normalize(val);
                    if (!v) return '';
                    if (v.startsWith('+62')) return '+62' + v.slice(3);
                    if (v.startsWith('62')) return '+62' + v.slice(2);
                    if (v.startsWith('0')) return '+62' + v.slice(1);
                    if (v.startsWith('+')) return v;
                    return '+62' + v;
                };
                input.addEventListener('blur', function() {
                    this.value = toE164ID(this.value);
                });
            }

            // --- Build Preview Step 4 ---
            function textOf(name) {
                const el = document.querySelector('[name="' + name + '"]');
                if (!el) return '';
                if (el.tagName === 'SELECT') return el.options[el.selectedIndex]?.text || '';
                if (el.type === 'radio') {
                    const checked = document.querySelector('[name="' + name + '"]:checked');
                    return checked ? checked.value : '';
                }
                return el.value || '';
            }

            function dateID(val) {
                if (!val) return '';
                try {
                    return new Date(val).toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: 'long',
                        year: 'numeric'
                    });
                } catch (e) {
                    return val;
                }
            }

            function setPreview(key, val) {
                const span = document.querySelector('[data-preview="' + key + '"]');
                if (span) span.textContent = val || '-';
            }

            function buildPreview() {
                // status
                setPreview('status', textOf('status'));
                // pasien baru
                setPreview('nama', textOf('nama'));
                setPreview('nik', textOf('nik'));
                setPreview('ttl', [textOf('tempat_lahir'), dateID(textOf('tanggal_lahir'))].filter(Boolean).join(', '));
                setPreview('jenis_kelamin', textOf('jenis_kelamin'));
                setPreview('no_hp', textOf('no_hp'));
                setPreview('agama', textOf('agama'));
                setPreview('alamat', textOf('alamat'));
                setPreview('pendidikan', textOf('pendidikan'));
                setPreview('pekerjaan', textOf('pekerjaan'));
                setPreview('status_perkawinan', textOf('status_perkawinan'));

                // penanggung jawab
                setPreview('hubungan', textOf('hubungan'));
                setPreview('nama_penanggung', textOf('nama_penanggung'));
                setPreview('alamat_penanggung', textOf('alamat_penanggung'));
                setPreview('penanggung_gender', textOf('penanggung_gender'));
                setPreview('agama_penanggung', textOf('agama_penanggung'));
                setPreview('pekerjaan_penanggung', textOf('pekerjaan_penanggung'));
                setPreview('status_penanggung', textOf('status_penanggung'));
                setPreview('no_hp_penanggung', textOf('no_hp_penanggung'));

                // jadwal & notifikasi
                setPreview('nama_poli', textOf('nama_poli'));
                setPreview('nama_dokter', textOf('nama_dokter'));
                setPreview('tanggal_booking', dateID(textOf('tanggal_booking')));
                setPreview('whatsapp', textOf('whatsapp'));
                setPreview('consent', document.getElementById('consent')?.checked ? 'Disetujui' : 'Tidak');
            }

            document.addEventListener('DOMContentLoaded', function() {
                showStep(1);
                bindStatusToggle();
                normalizeWhatsApp();
            });
        })();
    </script>
@endpush
