<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Water Billing Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h2>Payments by Purok</h2>
    <canvas id="purokChart"></canvas>

    <script>
        // Fetch the data from the API
        fetch('<?= base_url('Purok/getPaymentByPurok/January') ?>')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                const labels = data.map(item => item.purok);
                const totalAmount = data.map(item => item.total_amount);

                // Set up chart data
                const chartData = {
                    labels: labels,
                    datasets: [{
                        label: 'Payment Amount by Purok',
                        data: totalAmount,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                };

                // Create the chart
                const ctx = document.getElementById('purokChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: chartData,
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                // Optionally display an error message on the page
                document.getElementById('purokChart').innerHTML = 'Error loading chart data';
            });
    </script>
</body>
</html>