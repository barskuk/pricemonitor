<?php

class AdminController
{
    function actionIndex() {

        $countCustomers = Customer::getCountCustomers();
        $countCampaigns = Campaign::getCountCampaigns();
        $countProducts = Product::getCountProducts();
        $countPrices = Competitor::getCountCompetitorPrices();

        require_once(ROOTDIR . '/app/resources/views/admin/index.php');
        return true;
    }
}