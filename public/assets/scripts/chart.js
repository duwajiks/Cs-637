fetch('localhost:5000/statistics')
    .then(response => response.json())
    .then(data => {
        const ctx = document.getElementById('genreChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.genre,
                datasets: [{
                    label: 'Total Gross (USD)',
                    data: data.total_gross,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            }
        });
    });