function togglePassword(id, type) {
    let inputId = type === 'confirm' ? `confirmPasswordInput${id}` : `passwordInput${id}`;
    let iconId = type === 'confirm' ? `confirmIcon${id}` : `passwordIcon${id}`;

    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    } else {
        input.type = "password";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    }
}

function togglePasswordVisibility() {
    const input = document.getElementById("passwordInput");
    const icon = document.getElementById("passwordIcon");

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    } else {
        input.type = "password";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    }
}