const modal = document.getElementById('modalDetailKajianAwal');
if (modal) {
    modal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        document.getElementById('detailNomorRM').value = button.getAttribute('data-nomor');
        document.getElementById('detailNama').value = button.getAttribute('data-nama');
        document.getElementById('detailSuhu').value = button.getAttribute('data-suhu');
        document.getElementById('detailTekanan').value = button.getAttribute('data-tekanan');
        document.getElementById('detailTinggi').value = button.getAttribute('data-tinggi');
        document.getElementById('detailBerat').value = button.getAttribute('data-berat');
        document.getElementById('detailKeluhan').value = button.getAttribute('data-keluhan');
        document.getElementById('detailDiagnosis').value = button.getAttribute('data-diagnosis');
        document.getElementById('detailObat').value = button.getAttribute('data-obat');
        document.getElementById('detailTanggal').value = button.getAttribute('data-tanggal');
    });
}

const editModal = document.getElementById('modalEditRekamMedis');
if (editModal) {
    editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        document.getElementById('editKajianId').value = button.getAttribute('data-id');
        document.getElementById('editNomorRM').value = button.getAttribute('data-nomor');
        document.getElementById('editNama').value = button.getAttribute('data-nama');
        document.getElementById('editSuhu').value = button.getAttribute('data-suhu');
        document.getElementById('editTekanan').value = button.getAttribute('data-tekanan');
        document.getElementById('editTinggi').value = button.getAttribute('data-tinggi');
        document.getElementById('editBerat').value = button.getAttribute('data-berat');
        document.getElementById('editTanggal').value = button.getAttribute('data-tanggal');
        document.getElementById('editKeluhan').value = button.getAttribute('data-keluhan');
        document.getElementById('editDiagnosis').value = button.getAttribute('data-diagnosis');
        document.getElementById('editObat').value = button.getAttribute('data-obat');
    });
}
