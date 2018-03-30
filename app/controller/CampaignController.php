<?php

class CampaignController
{

    public function actionAdd() {

        $customer_id = Customer::checkAuth();


        $c_name = '';
        $c_url = '';
        $c_region = '';
        $result = FALSE;

        if(isset($_POST['submit'])) {
            $c_name = $_POST['c_name'];
            $c_url = $_POST['c_url'];
            $c_region = $_POST['c_region'];

            $errors = FALSE;

            if (!Campaign::checkCampaignName($c_name)) {
                $errors['c_name'] = "Имя должно быть длиннее 3 символов";
            }

            if (!Campaign::checkCampaingExist($c_name, $customer_id)) {
                $errors['c_name_exist'] = "Название кампании должно быть уникально";
            }

            if(strlen($c_url) > 3) {
                if (!GeneralChecks::isUrl($c_url)) {
                    $errors['c_url'] = "Неверная форма введенного домена";
                }

                if (GeneralChecks::getHttpResponseCode($c_url) != 200) {
                    $errors['c_url_error_code'] = "Введенный вами урл не доступен - код ответа сервера: " . GeneralChecks::getHttpResponseCode($c_url);
                }
            }

            //Если нет ошибок при заполнении формы
            if ($errors == FALSE) {

                $result = Campaign::add($c_name, $c_url, $c_region);

                if(strlen($c_url) > 3) {
                    $hostArr = parse_url($c_url);
                    $host = $hostArr['host'];
                    if (Competitor::checkCompetitorExist($host, $result)) {
                        $newCompetitor = Competitor::add($host, $result, 1);
                    }
                }

            }
        }

        require_once(ROOTDIR . '/app/resources/views/cabinet/campaign/add.php');
        return true;
    }




}