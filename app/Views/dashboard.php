<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Water Billing Dashboard</title>
    <link rel="stylesheet" href="<?php echo base_url('css/style.css'); ?>">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
  

    </style>
</head>
<body>
    <div class="sidebar">
        <button class="sidebar-toggle" aria-label="Toggle Sidebar">
            <i class="fas fa-bars"></i>
        </button>
        
        <div class="sidebar-header">
            <img src="water_bill.jpg" alt="Dashboard Logo" class="sidebar-logo">
            <span class="sidebar-title">Water Billing</span>
        </div>
        
        <nav class="sidebar-nav">
            <ul>
                <li>
                    <a href="#" class="active">
                        <i class="fas fa-chart-pie"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="../pie_chart/index.php">
                        <i class="fas fa-dollar-sign"></i>
                        <span>list</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="sidebar-overlay"></div>
    
    <main>
        <header>
            <h1>DA18_GROUP5 - Water Billing Dashboard</h1>
            <div class="dropdown">
                <div>Members</div>
                <div class="dropdown-content">
                    <a href="#">Mila Rose</a>
                    <a href="#">Riza Abangan</a>
                    <a href="#">Jaylord de Guzman</a>
                </div>
            </div>
        </header>
        
        <div>
            <label for="monthSelect">Select Month:</label>
            <select id="monthSelect">
                <option value="January">January</option>
                <option value="February">February</option>
                <option value="March">March</option>
            </select>
        </div>

        <div class="dashboard-container">
            <div class="chart-wrapper">
                <h2>Payments by Purok</h2>
                <canvas id="purokChart"></canvas>
            </div>
            
            <div class="chart-wrapper">
                <h2>Payment Percentage by Purok</h2>
                <canvas id="purokPaymentChart"></canvas>
            </div>
            
            <div class="chart-wrapper">
                <h2>Total Billing vs Paid Amount</h2>
                <canvas id="billingComparisonChart"></canvas>
            </div>
            
            <div class="chart-wrapper" style="grid-column: span 3;">
                <h2>Purok Payment Trends</h2>
                <select id="purokSelect">
                    <option value="">Select Purok</option>
                    <option value="Purok 1">Purok 1</option>
                    <option value="Purok 2">Purok 2</option>
                    <option value="Purok 3">Purok 3</option>
                    <option value="Purok 4">Purok 4</option>
                    <option value="Purok 5">Purok 5</option>
                    <option value="Purok 6">Purok 6</option>
                    <option value="Purok 7">Purok 7</option>
                </select>
                <canvas id="paymentTrendsChart"></canvas>
            </div>
        </div>
    </main>

    <script>
      
    </script>
    <script src="<?= base_url('js/script.js') ?>"></script>
</body>
</html>