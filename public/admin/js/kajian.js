// public/admin/js/kajian.js

document.addEventListener("DOMContentLoaded", function () {
    console.log("📦 File kajian.js loaded");

    /**
     * Mengisi data modal tambah diagnosis berdasarkan data dari tabel
     */
    window.isiDataDiagnosa = function (id, nama, suhu, tekanan, tinggi, berat, keluhan, tanggal, obat = '') {
        // Hidden input
        const idField = document.getElementById('kajian_id');

        // Field readonly (informasi kajian awal)
        const namaField = document.getElementById('nama_pasien');
        const suhuField = document.getElementById('suhu_tubuh');
        const tekananField = document.getElementById('tekanan_darah');
        const tinggiField = document.getElementById('tinggi_badan');
        const beratField = document.getElementById('berat_badan');
        const keluhanField = document.getElementById('keluhan');
        const tanggalField = document.getElementById('tanggal_periksa');

        // Diagnosis dan Obat (editable)
        const diagnosisField = document.getElementById('diagnosis');
        const obatField = document.getElementById('obat');

        if (idField && namaField && diagnosisField && obatField) {
            idField.value = id;
            namaField.value = nama;
            suhuField.value = suhu;
            tekananField.value = tekanan;
            tinggiField.value = tinggi;
            beratField.value = berat;
            keluhanField.value = keluhan;
            tanggalField.value = tanggal;
            diagnosisField.value = '';
            obatField.value = obat;

            console.log("📝 Data diagnosa disiapkan:", {
                id, nama, suhu, tekanan, tinggi, berat, keluhan, tanggal, obat
            });
        } else {
            console.error("❌ Beberapa elemen input modal tidak ditemukan.");
        }
    };

    /**
     * Validasi diagnosis dan obat sebelum submit form
     */
    const form = document.querySelector("form[action$='kajian.update']");
    if (form) {
        form.addEventListener("submit", function (e) {
            const diagnosis = document.getElementById("diagnosis").value.trim();
            const obat = document.getElementById("obat").value.trim();

            if (!diagnosis) {
                e.preventDefault();
                alert("Diagnosis tidak boleh kosong.");
                return;
            }

            if (!obat) {
                e.preventDefault();
                alert("Obat tidak boleh kosong.");
                return;
            }
        });
    }
});
