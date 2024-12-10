
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Site</title>
    <link rel="stylesheet" href="/movie/public/assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <header>
        <h1>Movie Explorer and Ratings Hub</h1>
        <nav>
            <ul>
                <li><a href="/movie/index.php?action=movies">Home</a></li>
                <li><a href="/movie/index.php?action=discussion">Discussion</a></li>
                <li><a href="http://localhost:5000/form">Getting bored?</a></li>
                <li><a href="/movie/app/views/statistic.html">Statistic</a></li>
                <li> <a href="/movie/public/logout.php">Log Out</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section >
            <h2>Total Gross Revenue by Genre</h2>

            <div id="chart-container">
                <canvas id="genreChart" width="800" height="400"></canvas>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 MovieWorld</p>
    </footer>

    <script>
        // Fetch the data from PHP
        fetch('http://localhost:8080/movie/app/utils/get_chart_data.php')
            .then(response => response.json())
            .then(data => {
                const genres = data.map(item => item.genre);
                const totalGross = data.map(item => item.total_gross);

                // Render the chart
                const ctx = document.getElementById('genreChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: genres,
                        datasets: [{
                            label: 'Total Gross Revenue (USD)',
                            data: totalGross,
                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top'
                            },
                            title: {
                                display: true,
                                text: 'Total Gross Revenue by Genre'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching chart data:', error));
    </script>
</body>
</html>
