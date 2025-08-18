 const modal = document.getElementById('modalDetailKajianAwal');
    modal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        document.getElementById('detailNama').value = button.getAttribute('data-nama');
        document.getElementById('detailTanggal').value = button.getAttribute('data-tanggal');
        document.getElementById('detailSuhu').value = button.getAttribute('data-suhu');
        document.getElementById('detailTekanan').value = button.getAttribute('data-tekanan');
        document.getElementById('detailTinggi').value = button.getAttribute('data-tinggi');
        document.getElementById('detailBerat').value = button.getAttribute('data-berat');
        document.getElementById('detailKeluhan').value = button.getAttribute('data-keluhan');
        document.getElementById('detailDiagnosis').value = button.getAttribute('data-diagnosis');
        document.getElementById('detailObat').value = button.getAttribute('data-obat');
    });

    
    function fetchAntrianTerkini() {
        fetch('/api/antrian-terkini')
            .then(res => res.json())
            .then(data => {
                document.querySelector('.antrian-number.umum').innerText = data.umum ?? '—';
                document.querySelector('.antrian-number.gigi').innerText = data.gigi ?? '—';
            });
    }

    // Panggil pertama kali dan setiap 3 detik
    fetchAntrianTerkini();
    setInterval(fetchAntrianTerkini, 3000);


    

    