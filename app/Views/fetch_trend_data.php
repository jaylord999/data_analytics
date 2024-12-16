<?php
header('Content-Type: application/json');
include 'db_connection.php';

$purok = $_GET['purok'] ?? '';

if (empty($purok)) {
    echo json_encode(['error' => 'No purok selected']);
    exit;
}

$sql = "SELECT month, total_amount FROM purok_payments 
        WHERE purok_name = ? 
        ORDER BY 
        CASE month
            WHEN 'January' THEN 1
            WHEN 'February' THEN 2
            WHEN 'March' THEN 3
        END";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $purok);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);

$stmt->close();
$conn->close();
?>