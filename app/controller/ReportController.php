<?php

class ReportController
{

    function actionInstock($param) {
        $campaign_id = $param[0];

        //получаем id всех наших товаров (competitor_product_id)
        $homeCompetitorId = Competitor::getHomeCompetitorId($campaign_id);
        $competitor_product_ids = Competitor::getCompetitorProductIdsByCompetitorId($homeCompetitorId);

        //получаем все цены и остатки на наши товары за последние 30 дней

        $arr = Report::getPricesByCompetitorLastMonth($competitor_product_ids);

        var_dump('<pre>');
        var_dump($arr);
        var_dump('</pre>');

        //формируем массив для очета нужной структуры

        $result = array();

        foreach ($arr as $item) {
            $date = date('d-m', strtotime($item['timestamp']));

            //проверяем есть ли в массиве ключ с нашей датой
            if (!array_key_exists($date, $result)) {
                //если нет, добавляем ключ с датой со значением 1
                $result[$date] = 1;
            } else { // если ключ есть, увеличиваем значение +1
                $temp = $result[$date] + 1;
                $result[$date] = $temp;
            }

        }

        var_dump($result);

        return true;
    }


}