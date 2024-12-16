<?php  
namespace App\Models;  

use CodeIgniter\Model;

class PaymentTrendModel extends Model 
{
    protected $table = 'purok_payments'; // Your database table name
    protected $allowedFields = ['purok_name', 'month', 'total_amount'];

    public function getPaymentsByMonth($month)
    {
        return $this->select('purok_name as purok, total_amount')
                    ->where('month', $month)
                    ->findAll();
    }

    public function getPaymentTrend($purok)
    {
        return $this->select('month, total_amount')
                    ->where('purok_name', $purok)
                    ->orderBy("FIELD(month, 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December')")
                    ->findAll();
    }
}