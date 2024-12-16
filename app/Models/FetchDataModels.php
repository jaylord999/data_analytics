<?php

namespace App\Models;
use CodeIgniter\Model;

class FetchDataModel extends Model
{
    protected $table = 'water_billing_summary'; // Replace with your table name
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    public function getPurokSummary($month)
    {
        // Fetch summary data based on month
        return $this->db->table('water_billing_summary')
                        ->select('purok, SUM(total_billing) as total_billing, SUM(total_paid) as total_paid, (SUM(total_paid) / SUM(total_billing) * 100) as payment_percentage')
                        ->where('month', $month)
                        ->groupBy('purok')
                        ->get()
                        ->getResultArray();
    }

    public function getPaymentTrends($purok)
    {
        // Fetch payment trends data for specific purok
        return $this->db->table('purok_payments')
                        ->select('month, total_amount')
                        ->where('purok_name', $purok)
                        ->orderBy('FIELD(month, "January", "February", "March")')
                        ->get()
                        ->getResultArray();
    }
}
