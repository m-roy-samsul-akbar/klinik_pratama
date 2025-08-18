document.addEventListener('DOMContentLoaded', function() {
            const filterHariRadio = document.getElementById('filter_hari');
            const filterBulanRadio = document.getElementById('filter_bulan');
            const filterHariContainer = document.getElementById('filterHariContainer');
            const filterBulanContainer = document.getElementById('filterBulanContainer');

            function toggleFilter() {
                if (filterHariRadio.checked) {
                    filterHariContainer.style.display = '';
                    filterBulanContainer.style.display = 'none';
                } else if (filterBulanRadio.checked) {
                    filterHariContainer.style.display = 'none';
                    filterBulanContainer.style.display = '';
                }
            }

            filterHariRadio.addEventListener('change', toggleFilter);
            filterBulanRadio.addEventListener('change', toggleFilter);
        });