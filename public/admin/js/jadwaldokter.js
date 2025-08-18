document.addEventListener('DOMContentLoaded', function () {
    // Auto-hide flash alerts
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.classList.remove('show');
            alert.classList.add('fade');
            setTimeout(() => alert.remove(), 300);
        }, 3000);
    });

    // Tambah Jadwal - Auto-fill dari dropdown
    const dokterSelect = document.getElementById('dokter');
    if (dokterSelect) {
        const spesialisInput = document.getElementById('spesialis_display');
        const jamMulaiInput = document.getElementById('jam_mulai');
        const jamSelesaiInput = document.getElementById('jam_selesai');
        const jamDisplay = document.getElementById('jam_display');

        dokterSelect.addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];
            const spesialis = selected.getAttribute('data-spesialis') || '';
            const jamMulai = selected.getAttribute('data-jam_mulai') || '';
            const jamSelesai = selected.getAttribute('data-jam_selesai') || '';

            function formatTime(time) {
                if (!time) return '';
                return time.length === 5 ? time : time.slice(0, 5);
            }

            spesialisInput.value = spesialis;
            jamMulaiInput.value = formatTime(jamMulai);
            jamSelesaiInput.value = formatTime(jamSelesai);
            jamDisplay.value = jamMulai && jamSelesai ? `${formatTime(jamMulai)} - ${formatTime(jamSelesai)}` : '';
        });
    }

    // Badge hari untuk Tambah
    const badgeContainer = document.getElementById('badge-hari-container');
    if (badgeContainer) {
        const badges = badgeContainer.querySelectorAll('.badge-hari:not(.badge-setiap)');
        const badgeSetiap = badgeContainer.querySelector('.badge-setiap');
        const inputHidden = document.getElementById('selected-hari');
        let selectedHari = [];

        function updateHiddenInput() {
            inputHidden.value = selectedHari.join(',');
        }

        badges.forEach(badge => {
            badge.addEventListener('click', function () {
                const hari = this.getAttribute('data-hari');
                this.classList.toggle('active');
                if (this.classList.contains('active')) {
                    selectedHari.push(hari);
                } else {
                    selectedHari = selectedHari.filter(h => h !== hari);
                }
                badgeSetiap.classList.remove('active');
                selectedHari = selectedHari.filter(h => h !== 'Setiap Hari');
                updateHiddenInput();
            });
        });

        badgeSetiap.addEventListener('click', function () {
            this.classList.toggle('active');
            if (this.classList.contains('active')) {
                badges.forEach(b => b.classList.remove('active'));
                selectedHari = ['Setiap Hari'];
            } else {
                selectedHari = [];
            }
            updateHiddenInput();
        });

        const form = document.querySelector('#tambahJadwalModal form');
        form.addEventListener('submit', function (e) {
            if (selectedHari.length === 0) {
                e.preventDefault();
                alert('Pilih minimal satu hari praktek!');
            }
        });
    }

    // Badge hari untuk Edit
    document.querySelectorAll('.badge-container-edit').forEach(container => {
        const id = container.getAttribute('data-id');
        const badges = container.querySelectorAll('.badge-hari:not(.badge-setiap)');
        const badgeSetiap = container.querySelector('.badge-setiap');
        const hiddenInput = document.getElementById(`selected-hari-edit-${id}`);
        let selectedHari = hiddenInput.value ? hiddenInput.value.split(',') : [];

        function syncInput() {
            hiddenInput.value = selectedHari.join(',');
        }

        // Inisialisasi aktif
        badges.forEach(badge => {
            if (selectedHari.includes(badge.dataset.hari)) {
                badge.classList.add('active');
            }
        });
        if (selectedHari.includes('Setiap Hari')) {
            badgeSetiap.classList.add('active');
        }

        badges.forEach(badge => {
            badge.addEventListener('click', () => {
                const hari = badge.dataset.hari;
                badge.classList.toggle('active');
                if (badge.classList.contains('active')) {
                    selectedHari.push(hari);
                } else {
                    selectedHari = selectedHari.filter(h => h !== hari);
                }
                badgeSetiap.classList.remove('active');
                selectedHari = selectedHari.filter(h => h !== 'Setiap Hari');
                syncInput();
            });
        });

        badgeSetiap.addEventListener('click', () => {
            badgeSetiap.classList.toggle('active');
            if (badgeSetiap.classList.contains('active')) {
                badges.forEach(b => b.classList.remove('active'));
                selectedHari = ['Setiap Hari'];
            } else {
                selectedHari = [];
            }
            syncInput();
        });
    });
    
});
