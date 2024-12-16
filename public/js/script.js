// Dashboard Initialization and Management
class DashboardManager {
    constructor() {
        // Chart instances to manage memory
        this.chartInstances = {
            purokBarChart: null,
            purokPieChart: null,
            billingComparisonChart: null,
            paymentTrendsLineChart: null
        };

        // Initialize event listeners and setup
        this.initializeSidebar();
        this.initializeCharts();
    }

    // Sidebar Toggle Functionality
    initializeSidebar() {
        const sidebarToggle = document.querySelector('.sidebar-toggle');
        const sidebarOverlay = document.querySelector('.sidebar-overlay');
        const sidebar = document.querySelector('.sidebar');

        if (sidebarToggle && sidebarOverlay && sidebar) {
            // Toggle sidebar on button click
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('open');
                document.body.classList.toggle('sidebar-open');
            });

            // Close sidebar when overlay is clicked
            sidebarOverlay.addEventListener('click', () => {
                sidebar.classList.remove('open');
                document.body.classList.remove('sidebar-open');
            });
        }

        // Active menu item handling
        const navLinks = document.querySelectorAll('.sidebar-nav a');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                navLinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });
    }

    // Chart Initialization and Data Fetching
    initializeCharts() {
        const monthSelect = document.getElementById('monthSelect');
        const purokSelect = document.getElementById('purokSelect');

        // Chart contexts
        const purokChartCtx = document.getElementById('purokChart')?.getContext('2d');
        const purokPaymentChartCtx = document.getElementById('purokPaymentChart')?.getContext('2d');
        const billingComparisonChartCtx = document.getElementById('billingComparisonChart')?.getContext('2d');
        const paymentTrendsChartCtx = document.getElementById('paymentTrendsChart')?.getContext('2d');

        // Fetch and render monthly data
        const fetchMonthlyData = (month) => {
            // Destroy existing charts
            Object.keys(this.chartInstances).forEach(key => {
                if (this.chartInstances[key]) {
                    this.chartInstances[key].destroy();
                    this.chartInstances[key] = null;
                }
            });

            // Show loading indicator
            this.showLoadingIndicator();

            fetch(`fetch_data?month=${encodeURIComponent(month)}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Hide loading indicator
                    this.hideLoadingIndicator();

                    const purokSummary = data.purokSummary;
                    const puroks = purokSummary.map(item => item.purok);
                    const amounts = purokSummary.map(item => parseFloat(item.total_paid));
                    const paymentPercentages = purokSummary.map(item => parseFloat(item.payment_percentage));
                    const totalBilling = purokSummary.map(item => parseFloat(item.total_billing));
                    const totalPaid = purokSummary.map(item => parseFloat(item.total_paid));

                    // Purok Payments Bar Chart
                    if (purokChartCtx) {
                        this.chartInstances.purokBarChart = new Chart(purokChartCtx, {
                            type: 'bar',
                            data: {
                                labels: puroks,
                                datasets: [{
                                    label: `Payments for ${month}`,
                                    data: amounts,
                                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    yAxes: [{
                                        display: true,
                                        ticks: {
                                            beginAtZero: true
                                        }
                                    }]
                                }
                            }
                        });
                    }

                    // Purok Payment Percentage Pie Chart
                    if (purokPaymentChartCtx) {
                        this.chartInstances.purokPieChart = new Chart(purokPaymentChartCtx, {
                            type: 'pie',
                            data: {
                                labels: puroks,
                                datasets: [{
                                    data: paymentPercentages,
                                    backgroundColor: [
                                        'rgba(255, 99, 132, 0.6)',
                                        'rgba(54, 162, 235, 0.6)',
                                        'rgba(255, 206, 86, 0.6)',
                                        'rgba(75, 192, 192, 0.6)',
                                        'rgba(153, 102, 255, 0.6)'
                                    ]
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    title: {
                                        display: true,
                                        text: `Payment Percentage by Purok - ${month}`
                                    }
                                }
                            }
                        });
                    }

                    // Billing Comparison Chart
                    if (billingComparisonChartCtx) {
                        this.chartInstances.billingComparisonChart = new Chart(billingComparisonChartCtx, {
                            type: 'bar',
                            data: {
                                labels: puroks,
                                datasets: [
                                    {
                                        label: 'Total Billing',
                                        data: totalBilling,
                                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                        borderWidth: 1
                                    },
                                    {
                                        label: 'Total Paid',
                                        data: totalPaid,
                                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                                        borderWidth: 1
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'Amount (₱)'
                                        }
                                    }
                                },
                                plugins: {
                                    title: {
                                        display: true,
                                        text: `Billing vs Paid Amount - ${month}`
                                    }
                                }
                            }
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    this.hideLoadingIndicator();
                    this.showErrorMessage('Failed to load chart data');
                });
        };

        // Payment Trends Chart
        const fetchPaymentTrends = (selectedPurok) => {
            if (!selectedPurok) return;

            // Show loading indicator
            this.showLoadingIndicator();

            fetch(`fetch_trend_data?purok=${encodeURIComponent(selectedPurok)}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Hide loading indicator
                    this.hideLoadingIndicator();

                    // Destroy existing payment trends chart
                    if (this.chartInstances.paymentTrendsLineChart) {
                        this.chartInstances.paymentTrendsLineChart.destroy();
                    }

                    const months = data.map(item => item.month);
                    const amounts = data.map(item => parseFloat(item.total_amount));

                    // Create new payment trends chart
                    if (paymentTrendsChartCtx) {
                        this.chartInstances.paymentTrendsLineChart = new Chart(paymentTrendsChartCtx, {
                            type: 'line',
                            data: {
                                labels: months,
                                datasets: [{
                                    label: `${selectedPurok} Payment Trends`,
                                    data: amounts,
                                    borderColor: 'blue',
                                    tension: 0.1
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'Total Amount (₱)'
                                        }
                                    }
                                }
                            }
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching trend data:', error);
                    this.hideLoadingIndicator();
                    this.showErrorMessage('Failed to load payment trends');
                });
        };

        // Event Listeners
        if (monthSelect) {
            monthSelect.addEventListener('change', (e) => {
                fetchMonthlyData(e.target.value);
            });
        }

        if (purokSelect) {
            purokSelect.addEventListener('change', (e) => {
                fetchPaymentTrends(e.target.value);
            });
        }

        // Initial data load
        fetchMonthlyData('January');
    }

    // Utility Methods for User Feedback
    showLoadingIndicator() {
        const loadingEl = document.getElementById('loading-indicator');
        if (loadingEl) loadingEl.style.display = 'block';
    }

    hideLoadingIndicator() {
        const loadingEl = document.getElementById('loading-indicator');
        if (loadingEl) loadingEl.style.display = 'none';
    }

    showErrorMessage(message) {
        const errorEl = document.getElementById('error-message');
        if (errorEl) {
            errorEl.textContent = message;
            errorEl.style.display = 'block';
            
            // Auto-hide error after 5 seconds
            setTimeout(() => {
                errorEl.style.display = 'none';
            }, 5000);
        }
    }
}

// Initialize the dashboard when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', () => {
    new DashboardManager();
});