<?php

class FeedController
{

    public function actionIndex($param) {

        $campId = $param[0];
        $campaign = Campaign::getCampaign($campId);
        $countInPage = Feed::SHOW_BY_DEFAULT;

        if (isset($_POST['submit'])) {

            $errors = FALSE;

            if ($_POST['is_active'] == 'on') {
                $is_active = 1;
            } else {
                $is_active = 0;
            }

            $type = $_POST['type'];

            $mode = $_POST['mode'];

            $url = $_POST['url'];

            if ($_POST['auto'] == 'on') {
                $auto = 1;
            } else {
                $auto = 0;
            }

            if (!GeneralChecks::isUrl($url)) {
                $errors['url'] = "Неверная форма адреса";
            }

            if ($errors == FALSE) {
                $result = Feed::add($is_active, $type, $mode, $url, $auto, $campId);

                if ($type == "yml"){
                  Feed::importFromYML($url, $campId);
                }

            }

        }

        $countFeeds = Feed::getTotalCountFeedsInCampagn($campId);

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


        $grid = Feed::feedGrid($page, $campId);

        $pagination = new Pagination($countFeeds, $page, Category::SHOW_BY_DEFAULT, '');



        require_once(ROOTDIR . '/app/resources/views/cabinet/feed/index.php');
        return true;

    }

}
