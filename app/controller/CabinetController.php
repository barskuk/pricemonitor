<?php

class CabinetController
{
    public function actionIndex() {

        $customerId = Customer::checkAuth();

        $countCampaign = Campaign::getCampaignIds($customerId);

        $countCamp = count($countCampaign);





        require_once(ROOTDIR . '/app/resources/views/cabinet/index.php');
        return true;
    }

    public function actionDashboard($param) {

        $campain_id = $param[0];

        $campaign = Campaign::getCampaign($campain_id);

        $feedCount = Feed::getTotalCountFeedsInCampagn($campain_id);
        $productCount = Product::getTotalCountProductsInCampaign($campain_id);
        $categoryCount = Category::getTotalCountCategoryInCampagn($campain_id);
        $brandCount = Brand::getTotalCountBrandsInCampagn($campain_id);
        $competitorCount = Competitor::getCountCompetitorsInCampagn($campain_id);


        require_once(ROOTDIR . '/app/resources/views/cabinet/campaign/dashboard.php');

        return true;



    }

}