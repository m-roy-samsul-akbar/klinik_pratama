(function () {
    // ---------- Mini helpers ----------
    const $ = (sel, ctx = document) => ctx.querySelector(sel);
    const $$ = (sel, ctx = document) => Array.from(ctx.querySelectorAll(sel));

    const hasJson = (res) =>
        (res.headers.get("content-type") || "").toLowerCase().includes("application/json");

    async function safeJson(res) {
        // Cegah error "Unexpected token <"
        const txt = await res.text();
        try {
            return JSON.parse(txt);
        } catch (_) {
            return { __raw: txt };
        }
    }

    function swal(opts) {
        if (window.Swal) return Swal.fire(opts);
        alert((opts.title ? opts.title + "\n" : "") + (opts.text || opts.html || ""));
    }

    // ---------- Progress + Step ----------
    function setActiveProgress(step) {
        $$(".progress-step").forEach((el, idx) => {
            if (idx < step) el.classList.add("active");
            else el.classList.remove("active");
        });
    }
    function showStep(step) {
        $$(".form-step").forEach((el) => (el.style.display = "none"));
        const sc = $("#step" + step);
        if (sc) sc.style.display = "block";
        setActiveProgress(step);
        if (step === 4) buildPreview();
    }
    window.nextStep = (s) => showStep(s);
    window.prevStep = (s) => showStep(s);

    // ---------- Value helpers ----------
    function textOf(name) {
        const el = document.querySelector('[name="' + name + '"]');
        if (!el) return "";
        if (el.tagName === "SELECT")
            return el.options[el.selectedIndex]?.text || "";
        if (el.type === "radio") {
            const c = document.querySelector('[name="' + name + '"]:checked');
            return c ? c.value : "";
        }
        return el.value || "";
    }

    function dateID(val) {
        if (!val) return "";
        try {
            return new Date(val).toLocaleDateString("id-ID", {
                day: "2-digit",
                month: "long",
                year: "numeric",
            });
        } catch (e) {
            return val;
        }
    }

    function setPreview(key, val) {
        const span = document.querySelector('[data-preview="' + key + '"]');
        if (span) span.textContent = val || "-";
    }

    // ---------- Toggle pasien lama/baru ----------
    function bindJenisPasien() {
        const radios = $$('input[name="jenis_pasien"]');
        const formBaru = $("#formPasienBaru");
        const formLama = $("#formPasienLama");
        const jadwalBaru = $("#blokJadwalBaru");
        const jadwalLama = $("#blokJadwalLama");

        function safeShow(el, show) {
            if (el) el.style.display = show ? "block" : "none";
        }
        function refresh(v) {
            const isBaru = v === "baru";
            safeShow(formBaru, isBaru);
            safeShow(jadwalBaru, isBaru);
            safeShow(formLama, !isBaru);
            safeShow(jadwalLama, !isBaru);
        }
        radios.forEach((r) => r.addEventListener("change", (e) => refresh(e.target.value)));
        const checked = $('input[name="jenis_pasien"]:checked');
        refresh(checked ? checked.value : "baru");
    }

    // ---------- Normalisasi WhatsApp ----------
    function bindNoWA() {
        const input = $("#no_whatsapp");
        if (!input) return;
        input.addEventListener("input", function () {
            let v = this.value.replace(/\D/g, "");
            if (v.startsWith("08")) v = "62" + v.substring(1);
            this.value = v;
        });
    }

    // ---------- Load dokter by spesialis + jam ----------
    async function fetchJSON(url) {
        const r = await fetch(url, { credentials: "same-origin" });
        if (hasJson(r)) return r.json();
        return safeJson(r); // fallback
    }

    function bindPoliDokter() {
        const maps = [
            { poli: '#poli_baru', dokter: '#dokter_baru', jam: '#jam_baru' },
            { poli: '#poli_lama', dokter: '#dokter_lama', jam: '#jam_lama' }
        ];

        maps.forEach(({ poli, dokter, jam }) => {
            const sp = document.querySelector(poli);
            const sd = document.querySelector(dokter);
            const sj = document.querySelector(jam);
            if (!sp || !sd || !sj) return;

            sp.addEventListener('change', async function () {
                sd.innerHTML = '<option value="" disabled selected>Loading...</option>';
                sj.value = '';
                const spes = this.value;
                if (!spes) {
                    sd.innerHTML = '<option value="" disabled selected hidden>Pilih dokter</option>';
                    return;
                }
                try {
                    const res = await fetch(`/api/dokter/by-spesialis/${encodeURIComponent(spes)}`);
                    const ct = res.headers.get('content-type') || '';
                    if (!ct.includes('application/json')) throw new Error('Non-JSON response');
                    const data = await res.json();
                    let opts = '<option value="" disabled selected hidden>Pilih dokter</option>';
                    (Array.isArray(data) ? data : (data.data || [])).forEach(d => {
                        opts += `<option value="${d.id}">${d.nama} - ${d.spesialis}</option>`;
                    });
                    sd.innerHTML = opts;
                } catch {
                    sd.innerHTML = '<option value="" disabled>Gagal memuat</option>';
                }
            });

            sd.addEventListener('change', async function () {
                sj.value = '';
                const id = this.value;
                if (!id) return;
                try {
                    const res = await fetch(`/api/dokter/jam-praktek?dokter_id=${encodeURIComponent(id)}`);
                    const ct = res.headers.get('content-type') || '';
                    if (!ct.includes('application/json')) throw new Error('Non-JSON response');
                    const j = await res.json();
                    sj.value = (j.data && j.data.jam_praktek) ? j.data.jam_praktek : 'Jam praktek tidak tersedia';
                } catch {
                    sj.value = '08:00 - 12:00'; // fallback
                }
            });
        });
    }

    // ---------- Preview ----------
    function markEmptyPreview() {
        $$('#step4 [data-preview]').forEach((el) => {
            const v = (el.textContent || "").trim();
            if (!v || v === "-" || /^Pilih\s/i.test(v)) {
                el.textContent = "-";
                el.classList.add("empty");
            } else {
                el.classList.remove("empty");
            }
        });
    }

    function buildPreview() {
        const jenis = textOf("jenis_pasien");
        setPreview("jenis_pasien", jenis);

        if (jenis === "baru") {
            setPreview("nama", textOf("nama"));
            setPreview("nik", textOf("nik"));
            setPreview("ttl", [textOf("tempat_lahir"), dateID(textOf("tanggal_lahir"))].filter(Boolean).join(", "));
            setPreview("jenis_kelamin", textOf("jenis_kelamin"));
            setPreview("agama", textOf("agama"));
            setPreview("alamat", textOf("alamat"));
            setPreview("pendidikan", textOf("pendidikan"));
            setPreview("pekerjaan", textOf("pekerjaan"));
            setPreview("status", textOf("status"));

            setPreview("penanggung_hubungan", textOf("penanggung_hubungan"));
            setPreview("penanggung_nama", textOf("penanggung_nama"));
            setPreview("penanggung_alamat", textOf("penanggung_alamat"));
            setPreview("penanggung_gender", textOf("penanggung_gender"));
            setPreview("penanggung_agama", textOf("penanggung_agama"));
            setPreview("penanggung_pekerjaan", textOf("penanggung_pekerjaan"));
            setPreview("penanggung_status", textOf("penanggung_status"));
            setPreview("no_whatsapp", textOf("no_whatsapp"));

            setPreview("poli", textOf("poli_baru"));
            setPreview("dokter", $("#dokter_baru")?.selectedOptions[0]?.text || "");
            setPreview("jam", $("#jam_baru")?.value || "");
            setPreview("tanggal_registrasi", dateID(textOf("tanggal_registrasi_baru")));
        } else {
            setPreview("nama", "(Pasien Lama)");
            setPreview("nik", textOf("nik_lama"));
            setPreview("ttl", dateID(textOf("tanggal_lahir_lama")));
            setPreview("poli", textOf("poli_lama"));
            setPreview("dokter", $("#dokter_lama")?.selectedOptions[0]?.text || "");
            setPreview("jam", $("#jam_lama")?.value || "");
            setPreview("tanggal_registrasi", dateID(textOf("tanggal_registrasi_lama")));
        }

        setPreview("whatsapp", textOf("whatsapp"));
        const c = $("#consent")?.checked;
        const chip = document.querySelector('[data-preview="consent"]');
        if (chip) {
            chip.textContent = c ? "Disetujui" : "Tidak";
            chip.classList.remove("chip", "success", "danger", "empty");
            chip.classList.add("chip", c ? "success" : "danger");
        }

        markEmptyPreview();
    }

    // ---------- Submit form verifikasi ----------
    function bindSubmit() {
        const form = document.getElementById("formVerifikasi");
        if (!form) return;

        form.addEventListener("submit", async function (e) {
            e.preventDefault();

            // Isi hidden master tanggal registrasi
            const jenis = document.querySelector('input[name="jenis_pasien"]:checked')?.value;
            const master = document.getElementById("tanggal_registrasi_master");
            if (master) {
                master.value =
                    (jenis === "baru"
                        ? document.getElementById("tanggal_registrasi_baru")?.value
                        : document.getElementById("tanggal_registrasi_lama")?.value) || "";
            }

            const formData = new FormData(form); // sudah ada _token dari @csrf

            try {
                const res = await fetch(form.action, { method: "POST", body: formData, credentials: "same-origin" });
                const data = hasJson(res) ? await res.json() : await safeJson(res);

                if (res.ok && data.status === "success") {
                    const noAntrian = data?.data?.nomor_antrian || "-";
                    await swal({
                        title: "Berhasil!",
                        html: `Pendaftaran berhasil.<br>Nomor Antrian: <b>${noAntrian}</b>`,
                        icon: "success",
                        confirmButtonText: "Ke Beranda",
                        draggable: true
                    });
                    window.location.href = "/";
                    return;
                }

                let msg = data?.message || "Terjadi kesalahan";
                if (data?.errors) {
                    const list = Object.values(data.errors).map((arr) => `• ${arr[0]}`).join("<br>");
                    msg = msg + "<br><br>" + list;
                }
                swal({ title: "Gagal", html: msg, icon: "error", confirmButtonText: "OK", allowOutsideClick: false });
            } catch (err) {
                swal({
                    title: "Gagal terhubung ke server",
                    text: err?.message || "Periksa koneksi Anda.",
                    icon: "error",
                    confirmButtonText: "OK",
                    allowOutsideClick: false
                });
            }
        });
    }

    // ---------- Cek Pasien Lama ----------
    function bindCekPasienLama() {
        const btn = document.getElementById("btnCekPasienLama");
        if (!btn) return;

        // Prioritas: data-url tombol -> meta -> endpoint publik (default) -> admin
        const url =
            btn.dataset.url ||
            document.querySelector('meta[name="pasien-cek-url"]')?.content ||
            "/api/pasien/cek" || // endpoint publik yang tidak butuh auth
            "/admin/api/pasien/cek";

        // CSRF token: ambil dari hidden input @csrf atau meta
        const token =
            document.querySelector('#formVerifikasi input[name="_token"]')?.value ||
            document.querySelector('meta[name="csrf-token"]')?.content ||
            "";

        btn.addEventListener("click", async function () {
            const nik = (document.getElementById("nik_lama")?.value || "").replace(/\D/g, "");
            const tgl =
                document.getElementById("tanggal_lahir_lama")?.value ||
                document.getElementById("tgl_lahir_lama")?.value || "";

            if (nik.length !== 16) {
                return swal({ title: "NIK tidak valid", text: "NIK harus 16 digit.", icon: "warning" });
            }
            if (!tgl || isNaN(new Date(tgl).getTime())) {
                return swal({ title: "Tanggal lahir kosong", text: "Isi tanggal lahir.", icon: "warning" });
            }

            const info = document.getElementById("infoPasienLama");
            const detail = document.getElementById("detailPasienLama");
            if (info && detail) {
                info.style.display = "block";
                info.className = "alert alert-info";
                detail.textContent = "Mencari data pasien...";
            }
            btn.disabled = true;

            try {
                const res = await fetch(url, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/json",
                        "X-CSRF-TOKEN": token
                    },
                    body: JSON.stringify({ nik: nik, tanggal_lahir: tgl }),
                    credentials: "same-origin"
                });

                const data = hasJson(res) ? await res.json() : await safeJson(res);

                if (res.ok && data.status === "found" && data.data) {
                    const p = data.data;
                    if (info && detail) {
                        info.className = "alert alert-success";
                        detail.innerHTML = `
              <div><strong>Nama:</strong> ${p.nama}</div>
              <div><strong>NIK:</strong> ${p.nik}</div>
              <div><strong>Jenis Kelamin:</strong> ${p.jenis_kelamin}</div>
              <div><strong>TTL:</strong> ${p.tempat_lahir}, ${p.tanggal_lahir}</div>
              <div><strong>Alamat:</strong> ${p.alamat}</div>
            `;
                    }
                    // Bisa auto lanjut step:
                    // nextStep(2);
                } else {
                    if (info && detail) {
                        info.className = "alert alert-warning";
                        detail.textContent = data.message || "Data pasien tidak ditemukan. Silakan periksa NIK & tanggal lahir.";
                    }
                }
            } catch (e) {
                console.error(e);
                if (info && detail) {
                    info.className = "alert alert-danger";
                    detail.textContent = "Terjadi kesalahan saat menghubungi server.";
                }
            } finally {
                btn.disabled = false;
            }
        });
    }

    // ---------- Validasi ringan Step 1 ----------
    function minimalValidateStep1() {
        const nextBtn = $$('#step1 .btn-next')[0];
        if (!nextBtn) return;

        nextBtn.addEventListener("click", () => {
            const jenis = textOf("jenis_pasien");
            if (jenis === "baru") {
                const req = [
                    "nama", "nik", "tempat_lahir", "tanggal_lahir", "agama", "alamat",
                    "pendidikan", "pekerjaan", "status", "penanggung_hubungan", "penanggung_nama",
                    "penanggung_alamat", "penanggung_pekerjaan", "penanggung_agama",
                    "penanggung_status", "no_whatsapp"
                ];
                if (!textOf("jenis_kelamin")) {
                    swal({ title: "Perhatian", text: "Pilih jenis kelamin.", icon: "warning" }); return;
                }
                if (!textOf("penanggung_gender")) {
                    swal({ title: "Perhatian", text: "Pilih jenis kelamin penanggung.", icon: "warning" }); return;
                }
                for (const f of req) {
                    if (!textOf(f)) {
                        swal({ title: "Perhatian", text: "Mohon lengkapi field: " + f.replaceAll("_", " "), icon: "warning" });
                        return;
                    }
                }
            } else {
                if (!textOf("nik_lama") || !textOf("tanggal_lahir_lama")) {
                    swal({ title: "Perhatian", text: "Isi NIK & Tanggal Lahir pasien lama.", icon: "warning" });
                    return;
                }
            }
            nextStep(2);
        });
    }

    // ---------- Tanggal minimal hari ini ----------
    function bindMinDate() {
        const today = new Date().toISOString().split("T")[0];
        $("#tanggal_registrasi_lama")?.setAttribute("min", today);
        $("#tanggal_registrasi_baru")?.setAttribute("min", today);
    }

    // ---------- Ready ----------
    document.addEventListener("DOMContentLoaded", function () {
        showStep(1);
        bindJenisPasien();
        bindNoWA();
        bindPoliDokter();
        bindSubmit();
        minimalValidateStep1();
        bindMinDate();
        bindCekPasienLama();

        // Mask NIK numeric
        ["nik", "nik_lama"].forEach((id) => {
            const el = $('[name="' + id + '"]');
            if (!el) return;
            el.addEventListener("input", function () {
                let v = this.value.replace(/\D/g, "").slice(0, 16);
                this.value = v;
            });
        });
    });
})();

