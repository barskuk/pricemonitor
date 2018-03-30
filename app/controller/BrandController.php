<?php

class BrandController
{
    public function actionAll($param) {

        $campId = $param[0];
        $campaign = Campaign::getCampaign($campId);

        $sbd = Brand::SHOW_BY_DEFAULT;

        if (isset($_POST['submit'])) {

            $errors = FALSE;
            $b_name = $_POST['b_name'];


            if (!Brand::checkName($b_name)) {
                $errors['b_name_len'] = "Имя должно быть длиннее 3 символов";
            }

            if (!Brand::checkNameExist($b_name, $campId)) {
                $errors['b_name'] = "Бренд " . $b_name . " был создан ранее";
            }

            if ($errors == FALSE) {
                $result = Brand::add($b_name, $campId);
            }
        }

        $countBrand = Brand::getTotalCountBrandsInCampagn($campId);

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

        $grid = Brand::brandGrid($page, $campId);

        $pagination = new Pagination($countBrand, $page, Brand::SHOW_BY_DEFAULT, '');

        require_once(ROOTDIR . '/app/resources/views/cabinet/brand/all.php');
        return true;

    }

}