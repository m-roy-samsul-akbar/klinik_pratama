fetch("{{ route('dashboard.chart-data') }}")
    .then(res => res.json())
    .then(res => {
        const ctx = document.getElementById("pendaftaranChart").getContext("2d");
        new Chart(ctx, {
            type: "line",
            data: {
                labels: res.labels,
                datasets: [{
                    label: "Pendaftaran",
                    data: res.data,
                    backgroundColor: "rgba(255, 255, 255, 0.3)",
                    borderColor: "#ffffff",
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: "white"
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        labels: {
                            color: "#fff"
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: "#fff"
                        },
                        grid: {
                            color: "rgba(255,255,255,0.1)"
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: "#fff"
                        },
                        grid: {
                            color: "rgba(255,255,255,0.1)"
                        }
                    }
                }
            }
        });
    });