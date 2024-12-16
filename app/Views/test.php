<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Chart Display</title>
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h2>Billing Summary - Payment Percentage</h2>
    <canvas id="myChart" width="400" height="200"></canvas>
    
    <script>
        // Fetch data from the BillingSummary API
        fetch('/BillingSummary/index?month=January')  // Adjust this URL if needed
            .then(response => response.json())
            .then(data => {
                const purokSummary = data.purokSummary;
                const labels = purokSummary.map(item => item.purok);  // Labels for X-axis (Purok names)
                const paymentPercentage = purokSummary.map(item => item.payment_percentage);  // Payment Percentage

                // Setup data for the chart
                const chartData = {
                    labels: labels,
                    datasets: [{
                        label: 'Payment Percentage',
                        data: paymentPercentage,  // Using payment percentage for Y-axis
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: false
                    }]
                };

                // Create a new chart using Chart.js
                const ctx = document.getElementById('myChart').getContext('2d');
                const myChart = new Chart(ctx, {
                    type: 'line',  // You can change this to 'bar', 'pie', etc.
                    data: chartData,
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching data:', error));
    </script>
</body>
</html>
