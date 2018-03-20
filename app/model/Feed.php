<?php

class Feed
{
    public static function getTotalCountFeedsInCampagn($campId) {

        $db = new DB();
        $sql = 'SELECT COUNT(*) from feed WHERE campaign_id=:campaign_id';
        $result = $db->prepare($sql);
        $result->bindParam(':campaign_id', $campId, PDO::PARAM_STR);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_NUM);
        $count = $result->fetch();

        return $count[0];

    }

    public static function add($is_active, $type, $mode, $url, $auto, $campId) {

        $db = new DB();
        $sql = "INSERT INTO feed (url, type, mode, is_active, auto, campaign_id) 
                VALUES (:url, :type, :mode, :is_active, :auto, :campaign_id)";
        $result = $db->prepare($sql);
        $result->bindParam(':url', $url, PDO::PARAM_STR);
        $result->bindParam(':type', $type, PDO::PARAM_STR);
        $result->bindParam(':mode', $mode, PDO::PARAM_STR);
        $result->bindParam(':is_active', $is_active, PDO::PARAM_STR);
        $result->bindParam(':auto', $auto, PDO::PARAM_STR);
        $result->bindParam(':campaign_id', $campId, PDO::PARAM_STR);

        return $result->execute();

    }

    public static function feedGrid($page, $campId) {

        return true;

    }

}