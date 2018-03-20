<?php

class CampaignController
{

    public function actionAdd() {

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

            if (!Campaign::checkCampaignUrl($c_url)) {
                $errors['c_url'] = "Неверная форма введенного домена";
            }

            //Если нет ошибок при заполнении формы
            if ($errors == FALSE) {
                $result = Campaign::add($c_name, $c_url, $c_region);
            }
        }

        require_once(ROOTDIR . '/app/resources/views/cabinet/campaign/add.php');
        return true;
    }




}