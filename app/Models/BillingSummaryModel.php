<?php

namespace App\Models;

use CodeIgniter\Model;

class BillingSummaryModel extends Model
{
    protected $table = 'water_billing_summary'; // Your database table name

    public function getPurokSummary($month)
    {
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->select('
            purok,
            SUM(total_billing) as total_billing,
            SUM(total_paid) as total_paid,
            (SUM(total_paid) / SUM(total_billing) * 100) as payment_percentage
        ');
        $builder->where('month', $month);
        $builder->groupBy('purok');

        return $builder->get()->getResultArray();
    }
}
