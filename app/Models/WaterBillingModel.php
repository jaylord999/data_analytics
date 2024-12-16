<?php
namespace App\Models;

use CodeIgniter\Model;

class WaterBillingModel extends Model
{
    public function getWaterBillingTableData()
    {
        $db = \Config\Database::connect();

        // Fetch unique months
        $monthQuery = $db->query("SELECT DISTINCT month FROM water_billing_summary ORDER BY 
            CASE month 
                WHEN 'January' THEN 1 
                WHEN 'February' THEN 2 
                WHEN 'March' THEN 3 
            END");
        $months = $monthQuery->getResultArray();
        $months = array_column($months, 'month');

        // Fetch unique puroks
        $purokQuery = $db->query("SELECT DISTINCT purok FROM water_billing_summary ORDER BY purok");
        $puroks = $purokQuery->getResultArray();
        $puroks = array_column($puroks, 'purok');

        // Create data matrix
        $dataMatrix = [];
        foreach ($months as $month) {
            $monthData = [];
            foreach ($puroks as $purok) {
                $sql = "SELECT total_billing, total_paid, 
                        ROUND((total_paid / total_billing * 100), 2) as payment_percentage 
                        FROM water_billing_summary 
                        WHERE month = ? AND purok = ?";
                $result = $db->query($sql, [$month, $purok]);
                
                if ($result->getNumRows() > 0) {
                    $row = $result->getRowArray();
                    $monthData[$purok] = $row;
                } else {
                    $monthData[$purok] = [
                        'total_billing' => 0,
                        'total_paid' => 0,
                        'payment_percentage' => 0
                    ];
                }
            }
            $dataMatrix[$month] = $monthData;
        }

        return [
            'months' => $months,
            'puroks' => $puroks,
            'data' => $dataMatrix
        ];
    }
}