<?php
namespace App\Controllers;

class WaterBilling extends BaseController
{
    public function index()
{
    try {
        log_message('error', 'Water Billing View accessed');
        
        $model = new \App\Models\WaterBillingModel();
        $billingData = $model->getWaterBillingTableData();

        if (empty($billingData)) {
            log_message('error', 'No billing data found');
        }

        return view('water_billing_view', $billingData);
    } catch (\Exception $e) {
        log_message('error', 'Water Billing View Error: ' . $e->getMessage());
        throw $e;
    }
}
}