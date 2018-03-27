<?php

class admin{
    static public function updatePrices(){
      $listOfURLs = static::getProductURLs();
      $list = [];
      foreach ($listOfURLs as $URL) {
        if($URL["product_url"] != NULL){
          $list[$URL["customerID"]][$URL["campaignID"]][$URL["productID"]] = $URL["product_url"];
        }
      }

      $priceList =[];
      foreach ($list as $customerID => $campaigns) {
        foreach ($campaigns as $campaignID => $products) {
          $priceList[$customerID][$campaignID] = Parser::getPrice($products);
        }
      }

      self::insertPrices($priceList);
    }

    public static function getProductURLs() {

        $db = new DB();
        $sql = 'SELECT customer.id as customerID, campaign.id as campaignID, competitor_product.id as productID, competitor_product.product_url FROM customer
                  LEFT JOIN campaign ON (customer.id = campaign.customer_id)
                  LEFT JOIN  product ON (campaign.id = product.campaign_id)
                  LEFT JOIN  competitor_product ON (product.id = competitor_product.product_id);';
        $query = $db->prepare($sql);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $result = $query->fetchAll();

        return $result;
    }

    public static function insertPrices($priceList) {
      $db = new DB();
      $sql = "INSERT INTO price (price, competitor_product_id, in_stock) VALUES ";
      foreach ($priceList as $campaigns) {
        foreach ($campaigns as  $products) {
          foreach($products as $productID => $data){
            $sql = $sql . "(" . $data["price"] . ", " . $productID . ", " . $data["in_stock"]  . "), ";
          }
        }
      }
      $sql = (substr($sql, 0, -2)) . ";";
      $result = $db->exec($sql);
    }
}

class Curl{
  private $ch;

  function init(){
     $this->ch = curl_init();
  }

  function close(){
    curl_close($this->ch);
  }

  function get($url, $referer = "http://google.com"){
     curl_setopt($this->ch, CURLOPT_URL, $url);
     curl_setopt($this->ch, CURLOPT_HEADER, 1);
     curl_setopt($this->ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36");
     curl_setopt($this->ch, CURLOPT_REFERER, $referer);
     curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, TRUE);
     $data = curl_exec($this->ch);
     return $data;
   }
}

class Parser {

  public static function getURLHOST($product_url){
     return parse_url($product_url, PHP_URL_HOST);
  }

public static function getSelector(/*$product_url*/){

      //запрос к БД: получить селектор по имени хоста parse_url($url, PHP_URL_HOST)/ SELECT * FROM competitor WHERE url = [url];
      $db = new DB();
      $sql = 'SELECT host_url, selector FROM parser_settings;';
      $query = $db->prepare($sql);
      $query->execute();
      $query->setFetchMode(PDO::FETCH_ASSOC);
      $result = $query->fetchAll();

      foreach($result as $el){
        $selectors[$el["host_url"]] = $el["selector"];
      }
      return $selectors;
    }

    public static function getPrice($product_url_list){
        $curl = new Curl();
        $curl->init();
        $selectors = static::getSelector();
        foreach($product_url_list as $productID => $product_url){
              $selector = $selectors[static::getURLHOST($product_url)];
              $data = $curl->get($product_url);

              $simple_html = str_get_html($data);

              if ($simple_html != FALSE){
                $price_html = $simple_html->find($selector, 0);
                if($price_html != NULL){
                  $price = $price_html->innertext;
                  $price = intval(str_replace(array(' ','&nbsp;'),'',$price));
                  $price_list[$productID]["price"] = $price;
                  $price_list[$productID]["in_stock"] = 1; //
                }
                else{
                  //No price found
                  $price_list[$productID]["price"] = -1;
                  $price_list[$productID]["in_stock"] = 0; //
                }
        }
        else {
          //$price_list[$product_url] = "Error: simple_html";
        }
      }
      $curl->close();

      return $price_list;
    }
  }


?>
