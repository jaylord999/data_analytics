<?php
namespace App\Models;
use CodeIgniter\Model;

class PurokPaymentModel extends Model {
    protected $table = 'purok_payments';

    public function getPaymentTrends($purok) {
        return $this->select('month, total_amount')
                    ->where('purok_name', $purok)
                    ->orderBy('FIELD(month, "January", "February", "March")')
                    ->get()
                    ->getResultArray();
    }
}