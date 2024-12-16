<?php

namespace App\Controllers;
use App\Models\FetchDataModel;

class Dashboard extends BaseController
{
    public function index()
    {
        // This would load the main dashboard page (with charts)
        return view('dashboard');
    }

    public function getPurokSummary($month)
    {
        $model = new FetchDataModel();
        $summaryData = $model->getPurokSummary($month);
        
        // Return the data as JSON
        return $this->response->setJSON(['purokSummary' => $summaryData]);
    }

    public function getPaymentTrends($purok)
    {
        $model = new FetchDataModel();
        $paymentTrends = $model->getPaymentTrends($purok);
        
        // Return the data as JSON
        return $this->response->setJSON($paymentTrends);
    }
}
