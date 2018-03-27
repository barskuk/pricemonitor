<?php

class AdminController
{
    function actionIndex() {

        $countCustomers = Customer::getCountCustomers();
        $countCampaigns = Campaign::getCountCampaigns();
        $countProducts = Product::getCountProducts();
        $countPrices = Competitor::getCountCompetitorPrices();

        if (isset($_POST['submit'])) {
            if($_POST['submit'] == "UpdatePrices"){
                $result = Admin::updatePrices();
            }
        }

        require_once(ROOTDIR . '/app/resources/views/admin/index.php');
        return true;
    }
}