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

    //
    public static function importFromYML($feed_url, $campId){
      $yml_obj = simplexml_load_file($feed_url);
      $categories = [];
      $categoriesDB = [];
      $offers = [];
      $vendors = [];

      foreach ($yml_obj->children() as $shop) {
        foreach ($shop->children() as $param) {
          if($param->getName() == "categories"){
            foreach ($param->children() as $category) {
              $categories[(int)$category["id"]] = (string)$category;
            }
          }
          if($param->getName() == "offers"){
            foreach ($param->children() as $offer) {
              foreach ($offer->children() as $data) {
                $offers[(int)$offer["id"]]["available"] = ($offer["available"] == TRUE) ? 1 : 0 ;
                if($data->getName() == "url") $offers[(int)$offer["id"]][$data->getName()] = (string)$data;
                if($data->getName() == "price") $offers[(int)$offer["id"]][$data->getName()] = (int)$data;
                if($data->getName() == "currencyId") $offers[(int)$offer["id"]][$data->getName()] = (string)$data;
                if($data->getName() == "categoryId") $offers[(int)$offer["id"]][$data->getName()] = (int)$data;
                if($data->getName() == "name") $offers[(int)$offer["id"]][$data->getName()] = (string)$data;
                if($data->getName() == "vendor"){
                    $offers[(int)$offer["id"]][$data->getName()] = (string)$data;
                    $vendors[(string)$data] = -1;
                }
                if($data->getName() == "vendorCode") $offers[(int)$offer["id"]][$data->getName()] = (string)$data;
              }
            }
          }
        }
      }

      foreach($categories as $key => $cat_name){
        if (Category::checkNameExist($cat_name, $campId))Category::add($cat_name, $campId);
        $categoriesDB[$cat_name] = Category::getId($cat_name, $campId);
      }


      foreach($vendors as $vendor_name => $vendor_id){
        if (Brand::checkNameExist($vendor_name, $campId)) Brand::add($vendor_name, $campId);
        $vendors[$vendor_name] = Brand::getId($vendor_name, $campId);
      }

      foreach($offers as $code => $offer){
        if (Product::checkCodeProductExist($code, $campId)){
          Product::add($campId, $offer["name"], $code, $offer["vendorCode"], (int)$categoriesDB[$categories[$offer["categoryId"]]], (int)$vendors[$offer["vendor"]], $offer["available"]);
        }
      }
    }
    //
}
