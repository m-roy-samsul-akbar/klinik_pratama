(function () {
    // ---------- Helpers ----------
    const $ = (sel, ctx = document) => ctx.querySelector(sel);
    const $$ = (sel, ctx = document) => Array.from(ctx.querySelectorAll(sel));

    function setActiveProgress(step) {
        const steps = $$('.progress-step');
        steps.forEach((el, idx) => {
            if (idx < step) el.classList.add('active');
            else el.classList.remove('active');
        });
    }

    function showStep(step) {
        $$('.form-step').forEach(el => el.style.display = 'none');
        const sc = $('#step' + step);
        if (sc) sc.style.display = 'block';
        setActiveProgress(step);
        if (step === 4) buildPreview();
    }
    window.nextStep = (s) => showStep(s);
    window.prevStep = (s) => showStep(s);

    function textOf(name) {
        const el = document.querySelector('[name="' + name + '"]');
        if (!el) return '';
        if (el.tagName === 'SELECT') return el.options[el.selectedIndex]?.text || '';
        if (el.type === 'radio') {
            const c = document.querySelector('[name="' + name + '"]:checked');
            return c ? c.value : '';
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

    // ---------- Toggle pasien lama/baru ----------
    function bindJenisPasien() {
        const radios = $$('input[name="jenis_pasien"]');
        const formBaru = $('#formPasienBaru');
        const formLama = $('#formPasienLama');
        const jadwalBaru = $('#blokJadwalBaru');
        const jadwalLama = $('#blokJadwalLama');

        function refresh(v) {
            const isBaru = v === 'baru';
            formBaru.style.display = isBaru ? 'block' : 'none';
            jadwalBaru.style.display = isBaru ? 'block' : 'none';
            formLama.style.display = !isBaru ? 'block' : 'none';
            jadwalLama.style.display = !isBaru ? 'block' : 'none';
        }
        radios.forEach(r => r.addEventListener('change', e => refresh(e.target.value)));
        const checked = $('input[name="jenis_pasien"]:checked');
        refresh(checked ? checked.value : 'baru');
    }

    // ---------- Normalisasi WA (penanggung) ----------
    function bindNoWA() {
        const input = $('#no_whatsapp');
        if (!input) return;
        input.addEventListener('input', function () {
            let v = this.value.replace(/\D/g, '');
            if (v.startsWith('08')) v = '62' + v.substring(1);
            this.value = v;
        });
    }

    // ---------- Load dokter by spesialis ----------
    async function fetchJSON(url) {
        const r = await fetch(url);
        return r.json();
    }

    function bindPoliDokter() {
        const maps = [{
            poli: '#poli_baru',
            dokter: '#dokter_baru',
            jam: '#jam_baru'
        },
        {
            poli: '#poli_lama',
            dokter: '#dokter_lama',
            jam: '#jam_lama'
        }
        ];
        maps.forEach(({
            poli,
            dokter,
            jam
        }) => {
            const sp = $(poli),
                sd = $(dokter),
                sj = $(jam);
            if (!sp || !sd || !sj) return;

            sp.addEventListener('change', async function () {
                sd.innerHTML = '<option value="" disabled selected>Loading...</option>';
                sj.value = '';
                const spes = this.value;
                if (!spes) {
                    sd.innerHTML =
                        '<option value="" disabled selected hidden>Pilih dokter</option>';
                    return;
                }
                try {
                    const data = await fetchJSON(`/admin/api/dokter/by-spesialis/${spes}`);
                    let opts =
                        '<option value="" disabled selected hidden>Pilih dokter</option>';
                    (Array.isArray(data) ? data : (data.data || [])).forEach(d => {
                        opts +=
                            `<option value="${d.id}">${d.nama} - ${d.spesialis}</option>`;
                    });
                    sd.innerHTML = opts;
                } catch (e) {
                    sd.innerHTML = '<option value="" disabled>Gagal memuat</option>';
                }
            });

            sd.addEventListener('change', async function () {
                sj.value = '';
                const id = this.value;
                if (!id) return;
                try {
                    const res = await fetch(
                        `/admin/api/dokter/jam-praktek?dokter_id=${id}`);
                    const j = await res.json();
                    if (j.data && j.data.jam_praktek) sj.value = j.data.jam_praktek;
                    else sj.value = 'Jam praktek tidak tersedia';
                } catch (e) {
                    sj.value = '08:00 - 12:00';
                }
            });
        });
    }

    // ---------- Build preview ----------
    function buildPreview() {
        const jenis = textOf('jenis_pasien');
        setPreview('jenis_pasien', jenis);

        if (jenis === 'baru') {
            setPreview('nama', textOf('nama'));
            setPreview('nik', textOf('nik'));
            setPreview('ttl', [textOf('tempat_lahir'), dateID(textOf('tanggal_lahir'))].filter(Boolean).join(
                ', '));
            setPreview('jenis_kelamin', textOf('jenis_kelamin'));
            setPreview('agama', textOf('agama'));
            setPreview('alamat', textOf('alamat'));
            setPreview('pendidikan', textOf('pendidikan'));
            setPreview('pekerjaan', textOf('pekerjaan'));
            setPreview('status', textOf('status'));

            setPreview('penanggung_hubungan', textOf('penanggung_hubungan'));
            setPreview('penanggung_nama', textOf('penanggung_nama'));
            setPreview('penanggung_alamat', textOf('penanggung_alamat'));
            setPreview('penanggung_gender', textOf('penanggung_gender'));
            setPreview('penanggung_agama', textOf('penanggung_agama'));
            setPreview('penanggung_pekerjaan', textOf('penanggung_pekerjaan'));
            setPreview('penanggung_status', textOf('penanggung_status'));
            setPreview('no_whatsapp', textOf('no_whatsapp'));

            setPreview('poli', textOf('poli_baru'));
            setPreview('dokter', $('#dokter_baru')?.selectedOptions[0]?.text || '');
            setPreview('jam', $('#jam_baru')?.value || '');
            setPreview('tanggal_registrasi', dateID(textOf('tanggal_registrasi_baru')));
        } else {
            // pasien lama: preview inti
            setPreview('nama', '(Pasien Lama)');
            setPreview('nik', textOf('nik_lama'));
            setPreview('ttl', dateID(textOf('tanggal_lahir_lama')));
            setPreview('poli', textOf('poli_lama'));
            setPreview('dokter', $('#dokter_lama')?.selectedOptions[0]?.text || '');
            setPreview('jam', $('#jam_lama')?.value || '');
            setPreview('tanggal_registrasi', dateID(textOf('tanggal_registrasi_lama')));
        }

        setPreview('whatsapp', textOf('whatsapp'));
        setPreview('consent', $('#consent')?.checked ? 'Disetujui' : 'Tidak');
    }
    

    // ---------- Submit hook: set tanggal_registrasi master ----------
    function bindSubmit() {
        const form = document.getElementById("formVerifikasi");
        form.addEventListener("submit", async function (e) {
            e.preventDefault();

            // pastikan hidden tanggal_registrasi_master ikut terisi
            const jenis = document.querySelector('input[name="jenis_pasien"]:checked')?.value;
            const master = document.getElementById('tanggal_registrasi_master');
            master.value =
                (jenis === 'baru'
                    ? document.getElementById('tanggal_registrasi_baru')?.value
                    : document.getElementById('tanggal_registrasi_lama')?.value) || '';

            const formData = new FormData(form); // sudah termasuk _token dari @csrf

            try {
                const res = await fetch(form.action, {
                    method: "POST",
                    body: formData,
                    credentials: "same-origin"
                });

                const data = await res.json();

                if (res.ok && data.status === "success") {
                    // ✅ SweetAlert2 saat sukses, lalu redirect ke home
                    const noAntrian = data?.data?.nomor_antrian || "-";
                    await Swal.fire({
                        title: "Berhasil!",
                        html: `Pendaftaran berhasil.<br>Nomor Antrian: <b>${noAntrian}</b>`,
                        icon: "success",
                        draggable: true,
                        confirmButtonText: "Ke Beranda"
                    });
                    window.location.href = "/";
                    return;
                }

                // ❌ Validasi / error dari server
                let msg = data?.message || "Terjadi kesalahan";
                if (data?.errors) {
                    const list = Object.values(data.errors).map(arr => `• ${arr[0]}`).join("<br>");
                    msg = msg + "<br><br>" + list;
                }
                Swal.fire({
                    title: "Gagal",
                    html: msg,
                    icon: "error",
                    confirmButtonText: "OK",
                    allowOutsideClick: false
                });
            } catch (err) {
                // ❌ Error jaringan / parsing
                Swal.fire({
                    title: "Gagal terhubung ke server",
                    text: err.message,
                    icon: "error",
                    confirmButtonText: "OK",
                    allowOutsideClick: false
                });
            }
        });
    }

    function bindCekPasienLama() {
        const btn = document.getElementById("btnCekPasienLama");
        if (!btn) return;

        // URL prioritas dari data-url tombol, lalu meta (jika ada), lalu fallback
        const url =
            btn.dataset.url ||
            document.querySelector('meta[name="pasien-cek-url"]')?.content ||
            "/admin/api/pasien/cek";

        // Ambil token CSRF dari hidden input @csrf (fallback ke meta jika ada)
        const token =
            document.querySelector('#formVerifikasi input[name="_token"]')?.value ||
            document.querySelector('meta[name="csrf-token"]')?.content ||
            "";

        btn.addEventListener("click", async function () {
            const nik = (document.getElementById("nik_lama")?.value || "").replace(/\D/g, "");

            // ⬇️ Perbaikan ID: cocokkan dengan HTML (tanggal_lahir_lama)
            const tgl =
                document.getElementById("tanggal_lahir_lama")?.value ||
                document.getElementById("tgl_lahir_lama")?.value || // fallback kalau ada variasi lama
                "";

            // Validasi ringan
            if (nik.length !== 16) {
                return window.Swal
                    ? Swal.fire({ title: "NIK tidak valid", text: "NIK harus 16 digit.", icon: "warning" })
                    : alert("NIK harus 16 digit.");
            }
            if (!tgl || isNaN(new Date(tgl).getTime())) {
                return window.Swal
                    ? Swal.fire({ title: "Tanggal lahir kosong", text: "Isi tanggal lahir.", icon: "warning" })
                    : alert("Tanggal lahir harus diisi.");
            }

            // Loading state
            const info = document.getElementById("infoPasienLama");
            const detail = document.getElementById("detailPasienLama");
            info.style.display = "block";
            info.className = "alert alert-info";
            detail.textContent = "Mencari data pasien...";
            btn.disabled = true;

            try {
                const res = await fetch(url, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": token
                    },
                    body: JSON.stringify({ nik: nik, tanggal_lahir: tgl }),
                    credentials: "same-origin"
                });

                const data = await res.json();

                if (res.ok && data.status === "found" && data.data) {
                    const p = data.data;
                    info.className = "alert alert-success";
                    detail.innerHTML = `
          <div><strong>Nama:</strong> ${p.nama}</div>
          <div><strong>NIK:</strong> ${p.nik}</div>
          <div><strong>Jenis Kelamin:</strong> ${p.jenis_kelamin}</div>
          <div><strong>TTL:</strong> ${p.tempat_lahir}, ${p.tanggal_lahir}</div>
          <div><strong>Alamat:</strong> ${p.alamat}</div>
        `;
                    // Jika ingin lanjut otomatis ke step 2:
                    // window.nextStep(2);
                } else {
                    info.className = "alert alert-warning";
                    detail.textContent = data.message || "Data pasien tidak ditemukan. Silakan periksa NIK & tanggal lahir.";
                }
            } catch (e) {
                console.error(e);
                info.className = "alert alert-danger";
                detail.textContent = "Terjadi kesalahan saat menghubungi server.";
            } finally {
                btn.disabled = false;
            }
        });
    }

    // panggil saat DOM siap
    document.addEventListener("DOMContentLoaded", bindCekPasienLama);



    // ---------- Validasi sangat ringkas sebelum step 2 ----------
    function minimalValidateStep1() {
        const nextBtn = $$('#step1 .btn-next')[0];
        nextBtn.addEventListener('click', () => {
            const jenis = textOf('jenis_pasien');
            if (jenis === 'baru') {
                const req = ['nama', 'nik', 'tempat_lahir', 'tanggal_lahir', 'agama', 'alamat',
                    'pendidikan', 'pekerjaan', 'status', 'penanggung_hubungan', 'penanggung_nama',
                    'penanggung_alamat', 'penanggung_pekerjaan', 'penanggung_agama',
                    'penanggung_status', 'no_whatsapp'
                ];
                // radio
                if (!textOf('jenis_kelamin')) {
                    alert('Pilih jenis kelamin');
                    return;
                }
                if (!textOf('penanggung_gender')) {
                    alert('Pilih jenis kelamin penanggung');
                    return;
                }
                // input/select required
                for (const f of req) {
                    if (!textOf(f)) {
                        alert('Mohon lengkapi field: ' + f.replaceAll('_', ' '));
                        return;
                    }
                }
            } else {
                if (!textOf('nik_lama') || !textOf('tanggal_lahir_lama')) {
                    alert('Isi NIK & Tanggal Lahir pasien lama.');
                    return;
                }
            }
            nextStep(2);
        });
    }

    function bindMinDate() {
        const today = new Date().toISOString().split('T')[0];
        $('#tanggal_registrasi_lama')?.setAttribute('min', today);
        $('#tanggal_registrasi_baru')?.setAttribute('min', today);
    }

    document.addEventListener('DOMContentLoaded', function () {
        showStep(1);
        bindJenisPasien();
        bindNoWA();
        bindPoliDokter();
        bindSubmit();
        minimalValidateStep1();
        bindMinDate();

        // Auto-mask NIK numeric
        ['nik', 'nik_lama'].forEach(id => {
            const el = $('[name="' + id + '"]');
            if (!el) return;
            el.addEventListener('input', function () {
                let v = this.value.replace(/\D/g, '').slice(0, 16);
                this.value = v;
            });
        });
    });
})();