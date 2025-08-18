document.addEventListener('DOMContentLoaded', () => {
    const alert = document.querySelector('.alert');
    if (alert) {
        alert.classList.add('fade-in');
        setTimeout(() => {
            alert.classList.remove('fade-in');
            alert.classList.add('fade-out');
        }, 5000);
    }

    const radioBaru = document.querySelector('input[name="status"][value="baru"]');
    const radioLama = document.querySelector('input[name="status"][value="lama"]');
    const formBaru = document.getElementById('formPasienBaru');
    const formLama = document.getElementById('formPasienLama');

    function updateFormDisplay() {
        formBaru.style.display = radioBaru.checked ? 'block' : 'none';
        formLama.style.display = radioLama.checked ? 'block' : 'none';
    }

    if (radioBaru && radioLama) {
        radioBaru.addEventListener('change', updateFormDisplay);
        radioLama.addEventListener('change', updateFormDisplay);
        updateFormDisplay();
    }
});

function goBack() {
    window.history.back();
}

function goNext() {
    alert("Lanjutkan ke langkah berikutnya");
    window.location.href = "/verifikasi2";
}

function showAlert() {
    if (document.getElementById('agreement').checked) {
        alert("Anda telah menyetujui syarat dan ketentuan.");
    }
}
