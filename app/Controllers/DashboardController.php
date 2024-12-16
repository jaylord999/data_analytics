<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\PurokPaymentModel;
use App\Models\WaterBillingSummaryModel;

class DashboardController extends Controller {
    public function getTrendData() {
        $purok = $this->request->getGet('purok');
        $model = new PurokPaymentModel();
        
        if (empty($purok)) {
            return $this->response->setJSON(['error' => 'No purok selected']);
        }

        $data = $model->getPaymentTrends($purok);
        return $this->response->setJSON($data);
    }

    public function getMonthlySummary() {
        $month = $this->request->getGet('month') ?? 'January';
        $model = new WaterBillingSummaryModel();

        $purokSummary = $model->getMonthlySummary($month);
        return $this->response->setJSON(['purokSummary' => $purokSummary]);
    }
}