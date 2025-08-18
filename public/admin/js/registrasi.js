// registrasi.js - Script untuk menangani toggle radio button dan form registrasi

$(document).ready(function () {
    // Inisialisasi form saat halaman dimuat
    initializeForm();

    // Event listener untuk radio button jenis pasien
    $('input[name="jenis_pasien"]').on('change', function () {
        toggleFormPasien();
    });

    // Event listener untuk dropdown poli pada form pasien lama
    $('#poli_lama').on('change', function () {
        loadDokterByPoli($(this).val(), 'lama');
    });

    // Event listener untuk dropdown poli pada form pasien baru
    $('#poli_baru').on('change', function () {
        loadDokterByPoli($(this).val(), 'baru');
    });

    // Event listener untuk dropdown dokter pada form pasien lama
    $('#dokter_lama').on('change', function () {
        loadJamPraktek($(this).val(), 'lama');
    });

    // Event listener untuk dropdown dokter pada form pasien baru
    $('#dokter_baru').on('change', function () {
        loadJamPraktek($(this).val(), 'baru');
    });
});

/**
 * Inisialisasi form saat halaman dimuat
 */
function initializeForm() {
    // Pastikan radio button "Pasien Lama" terpilih secara default
    $('input[name="jenis_pasien"][value="lama"]').prop('checked', true);

    // Tampilkan form yang sesuai
    toggleFormPasien();

    // Reset semua form
    resetAllForms();
}

/**
 * Toggle antara form pasien lama dan pasien baru
 */
function toggleFormPasien() {
    const jenisPasien = $('input[name="jenis_pasien"]:checked').val();

    if (jenisPasien === 'lama') {
        // Tampilkan form pasien lama, sembunyikan form pasien baru
        $('#formPasienLama').show();
        $('#formPasienBaru').hide();

        // Reset form pasien baru
        resetFormPasienBaru();

        console.log('Form Pasien Lama ditampilkan');
    } else if (jenisPasien === 'baru') {
        // Tampilkan form pasien baru, sembunyikan form pasien lama
        $('#formPasienBaru').show();
        $('#formPasienLama').hide();

        // Reset form pasien lama
        resetFormPasienLama();

        console.log('Form Pasien Baru ditampilkan');
    }
}

/**
 * Reset semua form
 */
function resetAllForms() {
    $('#formRegistrasi')[0].reset();
    $('#infoPasienLama').hide();
    $('#detailPasienLama').empty();

    // Reset dropdown dokter dan jam praktek
    resetDokterDropdown('lama');
    resetDokterDropdown('baru');
}

/**
 * Reset form pasien lama
 */
function resetFormPasienLama() {
    // Reset input fields
    $('#nik_lama').val('');
    $('#tanggal_lahir_lama').val('');
    $('#tanggal_registrasi_lama').val('');

    // Reset dropdown
    $('#poli_lama').val('').trigger('change');

    // Hide info pasien
    $('#infoPasienLama').hide();
    $('#detailPasienLama').empty();

    // Reset dokter dropdown
    resetDokterDropdown('lama');
}

/**
 * Reset form pasien baru
 */
function resetFormPasienBaru() {
    // Reset semua input text
    $('#nama, #nik, #tempat_lahir, #tanggal_lahir, #nama_ayah, #nama_ibu, #alamat').val('');
    $('#penanggung_nama, #penanggung_alamat, #no_whatsapp, #tanggal_registrasi_baru').val('');

    // Reset radio buttons
    $('input[name="jenis_kelamin"]').prop('checked', false);
    $('input[name="penanggung_gender"]').prop('checked', false);

    // Reset dropdown
    $('#agama, #pendidikan, #pekerjaan, #status').val('');
    $('#penanggung_hubungan, #penanggung_pekerjaan, #penanggung_agama, #penanggung_status').val('');
    $('#poli_baru').val('').trigger('change');

    // Reset dokter dropdown
    resetDokterDropdown('baru');
}

/**
 * Reset dropdown dokter dan jam praktek
 */
function resetDokterDropdown(jenis) {
    $(`#dokter_${jenis}`).empty().append('<option value="" disabled selected hidden>Pilih dokter</option>');
    $(`#jam_${jenis}`).val('');
}

/**
 * Load dokter berdasarkan poli yang dipilih
 */
function loadDokterByPoli(spesialis, jenis) {
    if (!spesialis) {
        resetDokterDropdown(jenis);
        return;
    }

    // Tampilkan loading
    $(`#dokter_${jenis}`).empty().append('<option value="" disabled selected>Loading...</option>');

    // AJAX request untuk mengambil data dokter
    $.ajax({
        url: `/admin/api/dokter/by-spesialis/${spesialis}`, // Fixed URL
        method: 'GET',
        success: function (response) {
            let options = '<option value="" disabled selected hidden>Pilih dokter</option>';

            // Handle response - check if it's array or object with data property
            const dokters = Array.isArray(response) ? response : response.data || response;

            if (dokters && dokters.length > 0) {
                dokters.forEach(function (dokter) {
                    options += `<option value="${dokter.id}">${dokter.nama} - ${dokter.spesialis}</option>`;
                });
            } else {
                options += '<option value="" disabled>Tidak ada dokter tersedia</option>';
            }

            $(`#dokter_${jenis}`).html(options);
        },
    });
}

/**
 * Load jam praktek berdasarkan dokter yang dipilih
 */
function loadJamPraktek(dokterId, jenis) {
    if (!dokterId) {
        $(`#jam_${jenis}`).val('');
        return;
    }

    // AJAX request untuk mengambil jam praktek dokter
    $.ajax({
        url: '/admin/api/dokter/jam-praktek', // You may need to create this route
        method: 'GET',
        data: { dokter_id: dokterId },
        success: function (response) {
            if (response.data && response.data.jam_praktek) {
                $(`#jam_${jenis}`).val(response.data.jam_praktek);
            } else {
                $(`#jam_${jenis}`).val('Jam praktek tidak tersedia');
            }
        },
        error: function (xhr, status, error) {
            console.error('Error loading jam praktek:', error);

            // Fallback - data dummy untuk testing
            const dummySchedule = {
                '1': '08:00 - 12:00',
                '2': '13:00 - 17:00',
                '3': '09:00 - 15:00',
                '4': '10:00 - 14:00'
            };
            $(`#jam_${jenis}`).val(dummySchedule[dokterId] || '08:00 - 12:00');
        }
    });
}

/**
 * Cek data pasien lama berdasarkan NIK dan tanggal lahir
 */
function cekPasienLama() {
    const nik = $('#nik_lama').val().trim();
    const tanggalLahir = $('#tanggal_lahir_lama').val();

    // Validasi input
    if (!nik || !tanggalLahir) {
        alert('Mohon isi NIK dan Tanggal Lahir terlebih dahulu!');
        return;
    }

    // Tampilkan loading
    $('#infoPasienLama').hide();
    $('#detailPasienLama').html('<div class="text-center">Mencari data pasien...</div>');
    $('#infoPasienLama').show();

    // AJAX request untuk cek data pasien
    $.ajax({
        url: '/admin/api/pasien/cek', // Fixed URL
        method: 'POST',
        data: {
            nik: nik,
            tanggal_lahir: tanggalLahir,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.status === 'found' && response.data) {
                const pasien = response.data;
                let detailHtml = `
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Nama:</strong> ${pasien.nama}<br>
                            <strong>NIK:</strong> ${pasien.nik}<br>
                            <strong>Jenis Kelamin:</strong> ${pasien.jenis_kelamin}<br>
                        </div>
                        <div class="col-md-6">
                            <strong>Tempat Lahir:</strong> ${pasien.tempat_lahir}<br>
                            <strong>Tanggal Lahir:</strong> ${pasien.tanggal_lahir}<br>
                            <strong>Alamat:</strong> ${pasien.alamat}<br>
                        </div>
                    </div>
                `;
                $('#detailPasienLama').html(detailHtml);
                $('#infoPasienLama').removeClass('alert-danger').addClass('alert-info');
            } else {
                $('#detailPasienLama').html('<div class="text-center text-danger">Data pasien tidak ditemukan!</div>');
                $('#infoPasienLama').removeClass('alert-info').addClass('alert-danger');
            }
        },
        error: function (xhr, status, error) {
            console.error('Error cek pasien:', error);
            $('#detailPasienLama').html('<div class="text-center text-danger">Terjadi kesalahan saat mencari data pasien!</div>');
            $('#infoPasienLama').removeClass('alert-info').addClass('alert-danger');
        }
    });
}

/**
 * Simpan data registrasi
 */
function simpanRegistrasi() {
    const jenisPasien = $('input[name="jenis_pasien"]:checked').val();

    // Validasi form berdasarkan jenis pasien
    if (!validateForm(jenisPasien)) {
        return;
    }

    // Tampilkan loading
    const btnSimpan = $('button[onclick="simpanRegistrasi()"]');
    const originalText = btnSimpan.text();
    btnSimpan.prop('disabled', true).text('Menyimpan...');

    // Siapkan data form
    const formData = new FormData($('#formRegistrasi')[0]);
    formData.append('jenis_pasien', jenisPasien);

    // AJAX request untuk simpan registrasi
    $.ajax({
        url: '/admin/pendaftaran', // Fixed URL
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            if (response.status === 'success') {
                alert('Registrasi berhasil disimpan!\n\nNomor Antrian: ' + response.data.nomor_antrian);
                $('#buatRegistrasiModal').modal('hide');

                // Reload halaman atau update tabel
                location.reload();
            } else {
                alert('Gagal menyimpan registrasi: ' + (response.message || 'Unknown error'));
            }
        },
        error: function (xhr, status, error) {
            console.error('Error simpan registrasi:', xhr.responseJSON);

            let errorMessage = 'Terjadi kesalahan saat menyimpan data.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                errorMessage = 'Validasi gagal:\n';
                Object.keys(xhr.responseJSON.errors).forEach(function (key) {
                    errorMessage += '- ' + xhr.responseJSON.errors[key][0] + '\n';
                });
            }

            alert(errorMessage);
        },
        complete: function () {
            // Kembalikan button ke kondisi semula
            btnSimpan.prop('disabled', false).text(originalText);
        }
    });
}

/**
 * Validasi form berdasarkan jenis pasien
 */
function validateForm(jenisPasien) {
    let isValid = true;
    let errorMessages = [];

    if (jenisPasien === 'lama') {
        // Validasi form pasien lama
        if (!$('#nik_lama').val().trim()) {
            errorMessages.push('NIK harus diisi');
            isValid = false;
        }

        if (!$('#tanggal_lahir_lama').val()) {
            errorMessages.push('Tanggal lahir harus diisi');
            isValid = false;
        }

        if (!$('#poli_lama').val()) {
            errorMessages.push('Poli harus dipilih');
            isValid = false;
        }

        if (!$('#dokter_lama').val()) {
            errorMessages.push('Dokter harus dipilih');
            isValid = false;
        }

        if (!$('#tanggal_registrasi_lama').val()) {
            errorMessages.push('Tanggal registrasi harus diisi');
            isValid = false;
        }
    } else if (jenisPasien === 'baru') {
        // Validasi form pasien baru - field wajib
        const requiredFields = [
            { field: '#nama', name: 'Nama pasien' },
            { field: '#nik', name: 'NIK' },
            { field: '#tempat_lahir', name: 'Tempat lahir' },
            { field: '#tanggal_lahir', name: 'Tanggal lahir' },
            { field: '#nama_ayah', name: 'Nama ayah' },
            { field: '#nama_ibu', name: 'Nama ibu' },
            { field: '#alamat', name: 'Alamat' },
            { field: '#penanggung_nama', name: 'Nama penanggung jawab' },
            { field: '#no_whatsapp', name: 'No. WhatsApp' },
            { field: '#tanggal_registrasi_baru', name: 'Tanggal registrasi' }
        ];

        requiredFields.forEach(function (item) {
            if (!$(item.field).val().trim()) {
                errorMessages.push(item.name + ' harus diisi');
                isValid = false;
            }
        });

        // Validasi radio button
        if (!$('input[name="jenis_kelamin"]:checked').val()) {
            errorMessages.push('Jenis kelamin harus dipilih');
            isValid = false;
        }

        if (!$('input[name="penanggung_gender"]:checked').val()) {
            errorMessages.push('Jenis kelamin penanggung jawab harus dipilih');
            isValid = false;
        }

        // Validasi dropdown
        const requiredSelects = [
            { field: '#agama', name: 'Agama' },
            { field: '#pendidikan', name: 'Pendidikan' },
            { field: '#pekerjaan', name: 'Pekerjaan' },
            { field: '#status', name: 'Status' },
            { field: '#penanggung_hubungan', name: 'Hubungan keluarga' },
            { field: '#penanggung_pekerjaan', name: 'Pekerjaan penanggung jawab' },
            { field: '#penanggung_agama', name: 'Agama penanggung jawab' },
            { field: '#penanggung_status', name: 'Status penanggung jawab' },
            { field: '#poli_baru', name: 'Poli' },
            { field: '#dokter_baru', name: 'Dokter' }
        ];

        requiredSelects.forEach(function (item) {
            if (!$(item.field).val()) {
                errorMessages.push(item.name + ' harus dipilih');
                isValid = false;
            }
        });
    }

    if (!isValid) {
        alert('Mohon lengkapi data berikut:\n\n' + errorMessages.join('\n'));
    }

    return isValid;
}

/**
 * Reset modal saat ditutup
 */
$('#buatRegistrasiModal').on('hidden.bs.modal', function () {
    resetAllForms();
    initializeForm();
});

/**
 * Set tanggal minimum untuk input tanggal registrasi (hari ini)
 */
$(document).ready(function () {
    const today = new Date().toISOString().split('T')[0];
    $('#tanggal_registrasi_lama, #tanggal_registrasi_baru').attr('min', today);
});

/**
 * Format nomor WhatsApp
 */
$('#no_whatsapp').on('input', function () {
    let value = $(this).val().replace(/\D/g, ''); // Hapus semua karakter non-digit

    // Tambahkan 62 jika dimulai dengan 08
    if (value.startsWith('08')) {
        value = '62' + value.substring(1);
    }

    $(this).val(value);
});

/**
 * Validasi NIK (harus 16 digit)
 */
$('#nik, #nik_lama').on('input', function () {
    let value = $(this).val().replace(/\D/g, ''); // Hapus semua karakter non-digit

    // Batasi maksimal 16 digit
    if (value.length > 16) {
        value = value.substring(0, 16);
    }

    $(this).val(value);
});

//kajian awal
  function isiDataKajianAwal(namaPasien, pendaftaranId) {
    document.getElementById('nama_pasien').value = namaPasien;
    document.getElementById('kajian_pendaftaran_id').value = pendaftaranId;
}


console.log('registrasi.js loaded successfully');