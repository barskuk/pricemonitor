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

        $campaign = Campaign::getCampaign($campaignId);

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


        $totalProducts = Product::getTotalCountProductsInCampaign($campaignId);

            $grid = Product::productsGrid($page, $campaignId);

            $pagination = new Pagination($totalProducts, $page, $sbd, '');

        require_once(ROOTDIR . '/app/resources/views/cabinet/product/all.php');
        return true;

    }

    public function actionCard($param) {

        $campaignId = $param[0];
        $productId = $param[1];
        $campaign = Campaign::getCampaign($campaignId);


        $product = Product::getProductById($productId);

        $catName = Category::getCategoryById($product['category_id']);
        $brandName = Brand::getBrandById($product['brand_id']);

        $countCompetitorProducts = Competitor::getTotalCountCompetitorProducts($productId);

        if (isset($_POST['submit_add_url'])) {

            $new_url = $_POST['product_url'];

            if (GeneralChecks::isUrl($new_url)) {

                $httpCode = GeneralChecks::getHttpResponseCode($new_url);

                if ($httpCode == 200) {

                    if (Competitor::checkCompetitorUrlExist($new_url, $productId)) {

                        //получаем хост
                        $hostArr = parse_url($new_url);
                        $host = $hostArr['host'];

                        //проверяем есть ли Конкурент с таким хостом
                        $competitor_id = Competitor::checkCompetitorExist($host,$campaignId);

                        //если есть то добавляем товар
                        if ($competitor_id) {
                            $result = Competitor::competitorProductAdd($new_url,$productId,$competitor_id);
                        } else { //если нет добавляем нового Конкурента после чего добавляем товар
                            $new_competitor_id = Competitor::add($host,$campaignId);
                            $result = Competitor::competitorProductAdd($new_url,$productId,$new_competitor_id);

                        }

                    } else {
                        $errors['new_url_exist'] = 'Ссылка уже была добавлена!';
                    }

                } else {
                    $errors['new_url_check'] = 'Ссылка не доступна, полученый код ошибки! ' . $httpCode;
                }

            } else {
                $errors['new_url_check'] = 'Неверный формат ссылки!';
            }

        }


        $grid = Competitor::gridCompetitorProducts($productId, $campaignId);



        require_once(ROOTDIR . '/app/resources/views/cabinet/product/card.php');
        return true;

    }

}