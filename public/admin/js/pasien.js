 // Modal Detail Pasien
    $('#modalDetailPasien').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        
        $('#detail_nomorrm').val(button.data('nomorrm'));
        $('#detail_nama').val(button.data('nama'));
        $('#detail_nik').val(button.data('nik'));
        $('#detail_tempat_lahir').val(button.data('tempat_lahir'));
        $('#detail_tanggal_lahir').val(button.data('tanggal_lahir'));
        $('#detail_jenis_kelamin').val(button.data('jenis_kelamin'));
        $('#detail_nama_ayah').val(button.data('nama_ayah'));
        $('#detail_nama_ibu').val(button.data('nama_ibu'));
        $('#detail_agama').val(button.data('agama'));
        $('#detail_alamat').val(button.data('alamat'));
        $('#detail_pendidikan').val(button.data('pendidikan'));
        $('#detail_pekerjaan').val(button.data('pekerjaan'));
        $('#detail_status').val(button.data('status'));
        $('#detail_penanggung_hubungan').val(button.data('penanggung_hubungan'));
        $('#detail_penanggung_nama').val(button.data('penanggung_nama'));
        $('#detail_penanggung_alamat').val(button.data('penanggung_alamat'));
        $('#detail_penanggung_pekerjaan').val(button.data('penanggung_pekerjaan'));
        $('#detail_penanggung_gender').val(button.data('penanggung_gender'));
        $('#detail_penanggung_agama').val(button.data('penanggung_agama'));
        $('#detail_penanggung_status').val(button.data('penanggung_status'));
        $('#detail_no_whatsapp').val(button.data('no_whatsapp'));
        $('#detail_poli').val(button.data('poli'));
        $('#detail_dokter').val(button.data('dokter'));
        $('#detail_jam').val(button.data('jam'));
        $('#detail_tanggal_registrasi').val(button.data('tanggal_registrasi'));
    });

    // Modal Edit Pasien
    $('#modalEditPasien').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        
        $('#edit_kajian_id').val(button.data('kajian_id'));
        $('#edit_nama').val(button.data('nama'));
        $('#edit_nik').val(button.data('nik'));
        $('#edit_tempat_lahir').val(button.data('tempat_lahir'));
        $('#edit_tanggal_lahir').val(button.data('tanggal_lahir'));
        $('#edit_jenis_kelamin').val(button.data('jenis_kelamin'));
        $('#edit_nama_ayah').val(button.data('nama_ayah'));
        $('#edit_nama_ibu').val(button.data('nama_ibu'));
        $('#edit_agama').val(button.data('agama'));
        $('#edit_alamat').val(button.data('alamat'));
        $('#edit_pendidikan').val(button.data('pendidikan'));
        $('#edit_pekerjaan').val(button.data('pekerjaan'));
        $('#edit_status').val(button.data('status'));
        $('#edit_penanggung_hubungan').val(button.data('penanggung_hubungan'));
        $('#edit_penanggung_nama').val(button.data('penanggung_nama'));
        $('#edit_penanggung_alamat').val(button.data('penanggung_alamat'));
        $('#edit_penanggung_pekerjaan').val(button.data('penanggung_pekerjaan'));
        $('#edit_penanggung_gender').val(button.data('penanggung_gender'));
        $('#edit_penanggung_agama').val(button.data('penanggung_agama'));
        $('#edit_penanggung_status').val(button.data('penanggung_status'));
        $('#edit_no_whatsapp').val(button.data('no_whatsapp'));
        $('#edit_tanggal_registrasi').val(button.data('tanggal_registrasi'));
    });

    // Konfirmasi Hapus
    function confirmDelete(id, nama) {
        $('#namaDataHapus').text(nama);
        $('#formHapus').attr('action', '{{ route("dokter.datapasien.hapus", "") }}/' + id);
        $('#modalKonfirmasiHapus').modal('show');
    }

    // Form validation
    $('#formEditPasien').on('submit', function(e) {
        var isValid = true;
        var requiredFields = $(this).find('[required]');
        
        requiredFields.each(function() {
            if ($(this).val() === '') {
                $(this).addClass('is-invalid');
                isValid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang wajib diisi.');
        }
    });

    // Remove invalid class when user starts typing
    $('[required]').on('input change', function() {
        if ($(this).val() !== '') {
            $(this).removeClass('is-invalid');
        }
    });
