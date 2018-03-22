<?php

class ProductController
{

    public function actionAdd($campaignId) {

        $campaignId = intval($campaignId[0]);

        $p_name = '';
        $p_code = '';
        $p_vendor_code = '';
        $p_category = '';
        $p_brand = '';

        $result = FALSE;

        if (isset($_POST['submit'])) {

            $errors = FALSE;

            $p_name = $_POST['p_name'];

            if (strlen($_POST['p_code']) == 0) {
                $p_code = NULL;
            } else {
                $check = Product::checkCodeProductExist($_POST['p_code'], $campaignId);

                if ($check) {
                    $p_code = $_POST['p_code'];
                } else {
                    $errors['p_code'] = "Поле 'Внутренний код' должно быть уникально в рамках Кампании.";
                }
            }

            if (strlen($_POST['p_vendor_code']) == 0) {
                $p_vendor_code = NULL;
            } else {
                $p_vendor_code = $_POST['p_vendor_code'];
            }

            //если категория не указана - устанавливаем системное значение "Без категории"
            if (strlen($_POST['p_category']) == 0) {
                $p_category = 1;
            } else {
                $p_category = $_POST['p_category'];
            }

            //если бренд не указан - устанавливаем системное значение "Без бренда"
            if (strlen($_POST['p_brand']) == 0) {
                $p_brand = 1;
            } else {
                $p_brand = $_POST['p_brand'];
            }

            if (isset($_POST['p_is_active'])) {
                $p_is_active = 1;
            } else {
                $p_is_active = 0;
            }

            if (!Campaign::checkCampaignName($p_name)) {
                $errors['p_name'] = "Имя должно быть длиннее 3 символов";
            }

            if ($errors == FALSE) {
                $result = Product::add($campaignId, $p_name, $p_code, $p_vendor_code, $p_category, $p_brand, $p_is_active);

            }

        }



        ////





        ///////

        require_once(ROOTDIR . '/app/resources/views/cabinet/product/add.php');
        return true;
    }

    public function actionAll($param) {

        $campaignId = $param[0];

        $campaign = Campaign::getCampaign($campaignId);

        $sbd = Product::SHOW_BY_DEFAULT;


        //если не получаем второй параметр (номер страницы) - показываем первую страницу
        if (isset($param[1])) {
            if (strlen($param[1]) == 0) {
                $page = 1;
            } else {
                $page = $param[1];
            }
        } else {
            $page = 1;
        }

        //var_dump($param);

        $totalProducts = Product::getTotalCountProductsInCampaign($campaignId);

            $grid = Product::productsGrid($page, $campaignId);

            $pagination = new Pagination($totalProducts, $page, $sbd, '');

        require_once(ROOTDIR . '/app/resources/views/cabinet/product/all.php');
        return true;

    }

}