<?php

class CompetitorController
{
    public function actionAll($param) {

        $campId = $param[0];


        $competitors = Competitor::getCompetitors($campId);
        $campaign = Campaign::getCampaign($campId);



        if (isset($_POST['submit'])) {

            $errors = FALSE;
            $competitor_url = $_POST['competitor_url'];


            if (GeneralChecks::isUrl($competitor_url)) {

                $httpCode = GeneralChecks::getHttpResponseCode($new_url);

                if ($httpCode == 200) {

                    $hostArr = parse_url($competitor_url);
                    $host = $hostArr['host'];

                    if (!Competitor::checkCompetitorExist($host,$campId)) {

                        $result = Competitor::add($host,$campId);

                    } else {
                        $errors['competitor_url'] = "Конкурент был добавлен ранее";
                    }

                } else {
                    $errors['competitor_url'] = "Ошибка сервера, получена ошибка " . $httpCode;
                }
            } else {
                $errors['competitor_url'] = "Неверный формат ссылки";
            }

        }

        $countCompetitors = Competitor::getCountCompetitorsInCampagn($campId);


        $grid = Competitor::competitorsGrid($campId);

        require_once(ROOTDIR . '/app/resources/views/cabinet/competitor/all.php');
        return true;

    }

}