
    /**
     * Update jam digital setiap detik
     */
    function updateClock() {
        const now = new Date();
        const time = now.toLocaleTimeString('id-ID', { hour12: false });
        $('#clock').text(time);
    }

    setInterval(updateClock, 1000);
    updateClock(); // panggil pertama kali

    /**
     * Ambil data antrian terkini setiap 5 detik
     */
    function fetchAntrianTerkini() {
        $.ajax({
            url: '/admin/pendaftaran/antrian-terkini',
            method: 'GET',
            success: function(response) {
                $('.antrian-number.umum').text(response.umum ?? 'U000');
                $('.antrian-number.gigi').text(response.gigi ?? 'G000');
            },
            error: function() {
                console.error('Gagal mengambil data antrian.');
            }
        });
    }

    setInterval(fetchAntrianTerkini, 5000);
    fetchAntrianTerkini(); // panggil pertama kali
