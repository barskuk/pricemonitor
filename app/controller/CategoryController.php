<?php

class CategoryController
{
    public function actionAll($param) {

        $campId = $param[0];
        $campaign = Campaign::getCampaign($campId);

        if (isset($_POST['submit'])) {

            $errors = FALSE;
            $cat_name = $_POST['cat_name'];


            if (!Category::checkName($cat_name)) {
                $errors['cat_name_len'] = "Имя должно быть длиннее 3 символов";
            }

            if (!Category::checkNameExist($cat_name, $campId)) {
                $errors['cat_name'] = "Категория " . $cat_name . " была создана ранее";
            }

            if ($errors == FALSE) {
                $result = Category::add($cat_name, $campId);
            }

        }

        $countCategory = Category::getTotalCountCategoryInCampagn($campId);

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

        $grid = Category::categoryGrid($page, $campId);

        $pagination = new Pagination($countCategory, $page, Category::SHOW_BY_DEFAULT, '');





        require_once(ROOTDIR . '/app/resources/views/cabinet/category/all.php');
        return true;

    }



}