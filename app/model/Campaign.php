<?php

class Campaign
{
    public static function add($c_name, $c_url, $c_region) {

        $customerId = Customer::checkAuth();

        $db = new DB();
        $sql = "INSERT INTO campaign (name, url, region, customer_id) VALUES (:name, :url, :region, :customer_id)";
        $result = $db->prepare($sql);
        $result->bindParam(':name', $c_name, PDO::PARAM_STR);
        $result->bindParam(':url', $c_url, PDO::PARAM_STR);
        $result->bindParam(':region', $c_region, PDO::PARAM_STR);
        $result->bindParam(':customer_id', $customerId, PDO::PARAM_STR);
        $result->execute();

        return $lastId = $db->lastInsertId();
    }

    public static function checkCampaingExist($name, $customer_id) {

        $db = new DB();
        $sql = 'SELECT COUNT(*) FROM campaign WHERE name=:name AND customer_id=:customer_id';
        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':customer_id', $customer_id, PDO::PARAM_STR);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_NUM);
        $count = $result->fetch();

        if ($count[0] == 0) {
            return TRUE;
        } else {
            return FALSE;
        }


    }


    public static function checkCampaignName($c_name) {
        if (strlen($c_name) >= 3) {
            return TRUE;
        }
        return FALSE;
    }


    public static function getCampaignIds($customerId) {

        $db = new DB();
        $sql = 'SELECT * FROM campaign WHERE customer_id = :customer_id';
        $result = $db->prepare($sql);
        $result->bindParam(':customer_id', $customerId, PDO::PARAM_INT);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_NUM);

        $campaignIds = FALSE;

        $i = 0;
        while ($row = $result->fetch()) {
            $campaignIds[$i] = $row[0];
            $i++;
        }
        if (isset($campaignIds)) {
            return $campaignIds;
        } else {
            return false;
        }
    }

    public static function getCampaign($id) {

        $db = new DB();
        $sql = 'SELECT * FROM campaign WHERE id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $campaign = $result->fetch();

        return $campaign;
    }

    public static function getCountCampaigns() {

        $db = new DB();
        $sql = 'SELECT COUNT(*) from campaign';
        $result = $db->prepare($sql);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_NUM);
        $count = $result->fetch();

        return $count[0];
    }


}