document.addEventListener("DOMContentLoaded", function () {
    const lanjutBtn = document.getElementById("lanjutBtn");
    const checkbox = document.getElementById("agree");

    if (!lanjutBtn || !checkbox) return;

    lanjutBtn.addEventListener("click", function (e) {
        e.preventDefault();

        if (!checkbox.checked) {
            alert("Silakan setujui ketentuan terlebih dahulu.");
            return;
        }

        const container = document.querySelector(".container");

        if (container) {
            container.classList.remove("fade-in");
            container.classList.add("fade-out");

            setTimeout(() => {
                const redirectUrl = lanjutBtn.dataset.redirect;
                if (redirectUrl) {
                    window.location.href = redirectUrl;
                } else {
                    console.warn("Redirect URL tidak ditemukan.");
                }
            }, 600); // durasi animasi fade-out
        }
    });
});
