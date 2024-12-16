<?php
header('Content-Type: application/json');
include 'db_connection.php';

$month = $_GET['month'] ?? 'January';

// Fetch purok summary data
$purokSummarySql = "SELECT 
    purok, 
    SUM(total_billing) as total_billing, 
    SUM(total_paid) as total_paid, 
    (SUM(total_paid) / SUM(total_billing) * 100) as payment_percentage 
FROM water_billing_summary 
WHERE month = ? 
GROUP BY purok";

$stmt = $conn->prepare($purokSummarySql);
$stmt->bind_param("s", $month);
$stmt->execute();
$purokSummaryResult = $stmt->get_result();

$purokSummary = [];
while ($row = $purokSummaryResult->fetch_assoc()) {
    $purokSummary[] = $row;
}

$response = [
    'purokSummary' => $purokSummary
];

echo json_encode($response);

$stmt->close();
$conn->close();
?>