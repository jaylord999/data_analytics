<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Water Billing Data</title>
    <link rel="stylesheet" href="<?= base_url('css/water_billing.css') ?>">
</head>
<body>
    <div class="header">
    <a href="<?= base_url('/') ?>" class="back-button">← Back to Dashboard</a>
        <h1>List of Water Billing Data</h1>
        <div style="width: 150px;"></div>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Month</th>
                    <?php foreach ($puroks as $purok): ?>
                        <th colspan="3"><?= esc($purok) ?></th>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <th></th>
                    <?php foreach ($puroks as $purok): ?>
                        <th>Total Billing</th>
                        <th>Total Paid</th>
                        <th>Payment %</th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($months as $month): ?>
                    <tr>
                        <td class="month-header"><?= esc($month) ?></td>
                        <?php foreach ($puroks as $purok): 
                            $purokData = $data[$month][$purok];
                        ?>
                            <td class="total-billing">
                                ₱ <?= number_format($purokData['total_billing'], 2) ?>
                            </td>
                            <td class="total-paid">
                                ₱ <?= number_format($purokData['total_paid'], 2) ?>
                            </td>
                            <td class="payment-percentage <?php 
                                if ($purokData['payment_percentage'] < 50) echo 'payment-percentage-low';
                                elseif ($purokData['payment_percentage'] < 80) echo 'payment-percentage-medium';
                                else echo 'payment-percentage-high';
                            ?>">
                                <?= number_format($purokData['payment_percentage'], 2) ?>%
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>