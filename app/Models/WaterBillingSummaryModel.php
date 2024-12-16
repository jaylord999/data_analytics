<?php
namespace App\Models;
use CodeIgniter\Model;

class WaterBillingSummaryModel extends Model {
    protected $table = 'water_billing_summary';

    public function getMonthlySummary($month = 'January') {
        return $this->select('
            purok, 
            SUM(total_billing) as total_billing,
            SUM(total_paid) as total_paid,
            (SUM(total_paid) / SUM(total_billing) * 100) as payment_percentage
        ')
        ->where('month', $month)
        ->groupBy('purok')
        ->get()
        ->getResultArray();
    }
}