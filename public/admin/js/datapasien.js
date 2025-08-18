const detailModal = document.getElementById('modalDetailPasien');
detailModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const fields = [
        'nomorrm', 'nama', 'nik', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin',
        'nama_ayah', 'nama_ibu', 'agama', 'alamat', 'pendidikan', 'pekerjaan', 'status',
        'penanggung_hubungan', 'penanggung_nama', 'penanggung_alamat', 'penanggung_pekerjaan',
        'penanggung_gender', 'penanggung_agama', 'penanggung_status', 'no_whatsapp',
        'poli', 'dokter', 'jam', 'tanggal_registrasi'
    ];

    fields.forEach(field => {
        const element = document.getElementById(`detail_${field}`);
        if (element) {
            const val = button.getAttribute(`data-${field}`);
            if (element.tagName === 'TEXTAREA' || element.tagName === 'INPUT') {
                element.value = val || '';
            }
        }
    });
});

function togglePassword(id, field) {
    const input = document.getElementById(field + 'Input' + id);
    const icon = document.getElementById(field + 'Icon' + id);
    const isHidden = input.type === "password";

    input.type = isHidden ? "text" : "password";
    icon.classList.toggle("fa-eye-slash", !isHidden);
    icon.classList.toggle("fa-eye", isHidden);
}
