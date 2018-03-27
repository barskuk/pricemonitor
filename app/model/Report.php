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

}