<?php

class Report
{

    public static function getLastPrice($competitor_product_id) {

        $db = new DB();
        $sql = 'SELECT * FROM price WHERE competitor_product_id=:competitor_product_id ORDER BY timestamp DESC';

        $result = $db->prepare($sql);
        $result->bindParam(':competitor_product_id', $competitor_product_id, PDO::PARAM_INT);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);


        return $row = $result->fetch();

    }

    public static function getOurCompetitorProductId($product_id) {

        $db = new DB();
        $sql = 'SELECT * FROM competitor_product WHERE product_id=:product_id AND is_home=1';

        $result = $db->prepare($sql);
        $result->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();

        return $row['id'];

    }

    public static function getOurLastPrice($product_id, $campaign_id) {

        $homeCompetitorId = Competitor::getHomeCompetitorId($campaign_id);


        $db = new DB();
        $sql = 'SELECT id FROM competitor_product WHERE competitor_id=:competitor_id AND product_id=:product_id';

        $result = $db->prepare($sql);
        $result->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $result->bindParam(':competitor_id', $homeCompetitorId, PDO::PARAM_INT);

        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();

        if ($row) {

            $result = self::getLastPrice($row['id']);
            return $result;

        } else {

            return FALSE;

        }

    }

    public static function getPricesByCompetitorLastMonth($competitor_product_id) {

        $db = new DB();
        $resultArr = array();
        $i = 0;
        foreach ($competitor_product_id as $cpi) {

            $sql = 'SELECT id, price, competitor_product_id, in_stock, timestamp FROM price WHERE competitor_product_id=:competitor_product_id 
                                          AND timestamp > NOW() - INTERVAL 30 DAY ORDER BY timestamp';

            $result = $db->prepare($sql);
            $result->bindParam(':competitor_product_id', $cpi, PDO::PARAM_INT);
            $result->execute();
            $result->setFetchMode(PDO::FETCH_ASSOC);


            while ($row = $result->fetch()) {
                $resultArr[$i]['id'] = $row['id'];
                $resultArr[$i]['price'] = $row['price'];
                $resultArr[$i]['competitor_product_id'] = $row['competitor_product_id'];
                $resultArr[$i]['in_stock'] = $row['in_stock'];
                $resultArr[$i]['timestamp'] = $row['timestamp'];
                $i++;
            }
        }
        return $resultArr;

    }


    public static function getCompetitorPricesByProduct($product_id, $campaign_id) {

        $home_competitor_id = Competitor::getHomeCompetitorId($campaign_id);

        //получаем все competitor_products для товара
        $competitor_products = (array)Competitor::getCompetitorProductsWithOutHome($product_id,$home_competitor_id);

        $ids = array();

        foreach ($competitor_products as $competitor_product) {
            array_push($ids,(int)$competitor_product['id']);
        }

        //получаем последние цены для товара
        $prices = Competitor::getLastCompetitorPriceByCompetitorProductId($ids);

        return $prices;




    }

}