<?php

class Competitor
{
    public static function add($url, $campaign_id, $is_home = 0) {

        $db = new DB();

        $sql = "INSERT INTO competitor (url, is_home, campaign_id) VALUES (:url, :is_home, :campaign_id)";
        $result = $db->prepare($sql);
        $result->bindParam(':url', $url, PDO::PARAM_STR);
        $result->bindParam(':is_home', $is_home, PDO::PARAM_STR);
        $result->bindParam(':campaign_id', $campaign_id, PDO::PARAM_STR);
        $result->execute();

        return $lastId = $db->lastInsertId();
    }


    public static function getCompetitors($campaign_id) {

        $db = new DB();
        $sql = 'SELECT * FROM competitor WHERE campaign_id = :campaign_id AND is_home != 1';
        $result = $db->prepare($sql);
        $result->bindParam(':campaign_id', $campaign_id, PDO::PARAM_INT);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);

        $i = 0;
        while ($row = $result->fetch()) {
            $item[$i]['id'] = $row['id'];
            $item[$i]['url'] = $row['url'];
            $i++;
        }
        if (isset($item)) {
            return $item;
        } else {
            return false; //Warning: count(): Parameter must be an array or an object that implements Countable in D:\xampp\htdocs\Proj\pricemonitor\app\model\Feed.php on line 84 => (false -> [])
        }
    }


    public static function checkCompetitorExist($url, $campaign_id) {

        $db = new DB();
        $sql = 'SELECT id FROM competitor WHERE url=:url AND campaign_id=:campaign_id';
        $result = $db->prepare($sql);
        $result->bindParam(':url', $url, PDO::PARAM_STR);
        $result->bindParam(':campaign_id', $campaign_id, PDO::PARAM_STR);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_NUM);
        $id = $result->fetch();

        return $id[0];
    }

    public static function getHomeCompetitorId($campaign_id) {

        $db = new DB();
        $sql = 'SELECT id FROM competitor WHERE campaign_id=:campaign_id AND is_home=1';
        $result = $db->prepare($sql);
        $result->bindParam(':campaign_id', $campaign_id, PDO::PARAM_STR);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_NUM);
        $id = $result->fetch();

        return $id[0];
    }

    public static function getCountCompetitorsInCampagn($campaign_id) {

        $db = new DB();
        $sql = 'SELECT COUNT(*) FROM competitor WHERE campaign_id=:campaign_id AND is_home != 1';
        $result = $db->prepare($sql);
        $result->bindParam(':campaign_id', $campaign_id, PDO::PARAM_STR);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_NUM);
        $count = $result->fetch();

        return $count[0];

    }

    public static function getLastCompetitorPriceByCompetitorProductId($competitor_product_ids) {


        $db = new DB();

        $res = array();


        foreach ($competitor_product_ids as $competitor_product) {

            $id = $competitor_product;

            $sql = 'SELECT * FROM price WHERE competitor_product_id=:competitor_product_id';

            $result = $db->prepare($sql);
            $result->bindParam(':competitor_product_id', $id, PDO::PARAM_INT);
            $result->execute();
            $result->setFetchMode(PDO::FETCH_ASSOC);


            while ($row = $result->fetch()) {

                array_push($res, $row['price']);


            }

        }
        return $res;

    }


    public static function competitorProductAdd($product_url, $product_id, $competitor_id) {

        $db = new DB();

        $sql = "INSERT INTO competitor_product (product_url, product_id, competitor_id) VALUES (:product_url, :product_id, :competitor_id)";
        $result = $db->prepare($sql);
        $result->bindParam(':product_url', $product_url, PDO::PARAM_STR);
        $result->bindParam(':product_id', $product_id, PDO::PARAM_STR);
        $result->bindParam(':competitor_id', $competitor_id, PDO::PARAM_STR);
        $result->execute();

        return $lastId = $db->lastInsertId();

    }


    public static function getTotalCountCompetitorProducts($product_id) {

        $db = new DB();
        $sql = 'SELECT COUNT(*) from competitor_product WHERE product_id=:product_id';
        $result = $db->prepare($sql);
        $result->bindParam(':product_id', $product_id, PDO::PARAM_STR);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_NUM);
        $count = $result->fetch();

        return $count[0];
    }

    public static function checkCompetitorUrlExist($url, $prodId) {

        $db = new DB();
        $sql = 'SELECT COUNT(*) FROM competitor_product WHERE product_url=:product_url AND product_id=:product_id';
        $result = $db->prepare($sql);
        $result->bindParam(':product_url', $url, PDO::PARAM_STR);
        $result->bindParam(':product_id', $prodId, PDO::PARAM_STR);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_NUM);
        $count = $result->fetch();

        if ($count[0] == 0) {
            return TRUE;
        } else {
            return FALSE;
        }

    }

    public static function getCompetitorProductId($url, $prodId) {

        $db = new DB();
        $sql = 'SELECT id FROM competitor_product WHERE product_url=:product_url AND product_id=:product_id';
        $result = $db->prepare($sql);
        $result->bindParam(':product_url', $url, PDO::PARAM_STR);
        $result->bindParam(':product_id', $prodId, PDO::PARAM_STR);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_NUM);
        $id = $result->fetch();

        return $id[0];
    }

    public static function getCompetitorProductIdsByCompetitorId($competitor_id) {

        $db = new DB();
        $sql = 'SELECT id FROM competitor_product WHERE competitor_id=:competitor_id';
        $result = $db->prepare($sql);
        $result->bindParam(':competitor_id', $competitor_id, PDO::PARAM_STR);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);

        $ids = array();

        $i = 0;
        while ($row = $result->fetch()) {
            $id = intval($row['id']);
            array_push($ids, $id);
            $i++;
        }

        return $ids;
    }

    public static function addCompetitorPrice($competitor_product_id, $price, $in_stock = 1) {

        $db = new DB();

        $sql = "INSERT INTO price (competitor_product_id, price, in_stock) VALUES (:competitor_product_id, :price, :in_stock)";
        $result = $db->prepare($sql);
        $result->bindParam(':competitor_product_id', $competitor_product_id, PDO::PARAM_STR);
        $result->bindParam(':price', $price, PDO::PARAM_STR);
        $result->bindParam(':in_stock', $in_stock, PDO::PARAM_STR);
        $result->execute();

        return $lastId = $db->lastInsertId();

    }

    public static function getCompetitorProducts($product_id)
    {

        $db = new DB();
        $sql = 'SELECT * FROM competitor_product WHERE product_id=:product_id';

        $result = $db->prepare($sql);
        $result->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);


        $i = 0;
        while ($row = $result->fetch()) {
            $item[$i]['id'] = $row['id'];
            $item[$i]['product_url'] = $row['product_url'];
            $item[$i]['create_time'] = $row['create_time'];
            $item[$i]['competitor_id'] = $row['competitor_id'];
            $i++;
        }
        if (isset($item)) {
            return $item;
        } else {
            return false;
        }

    }
    public static function getCompetitorProductsWithOutHome($product_id, $home_competitor_id)
    {

        $db = new DB();
        $sql = 'SELECT * FROM competitor_product WHERE competitor_id != :competitor_id AND product_id=:product_id';

        $result = $db->prepare($sql);
        $result->bindParam(':competitor_id', $home_competitor_id, PDO::PARAM_INT);
        $result->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);


        $i = 0;
        while ($row = $result->fetch()) {
            $item[$i]['id'] = $row['id'];
            $item[$i]['product_url'] = $row['product_url'];
            $item[$i]['create_time'] = $row['create_time'];
            $item[$i]['competitor_id'] = $row['competitor_id'];
            $i++;
        }
        if (isset($item)) {
            return $item;
        } else {
            return false;
        }

    }

    public static function gridCompetitorProducts($product_id, $campaign_id) {

        $items = self::getCompetitorProducts($product_id);

        $homeCompetitorId = Competitor::getHomeCompetitorId($campaign_id);

        $grid = '';

        if (count($items) > 0 && $items != false) {

            $grid = "<table class='table table-hover'>
                        <thead class='thead-light'>
                            <tr>
                                <th scope='col'>Конкурент</th>
                                <th scope='col'>Последнее изменение</th>
                                <th scope='col'>Цена</th>
                                <th scope='col'>Наличие</th>
                                <th scope='col'></th>
                            </tr>
                        </thead>
                    <tbody>";

            foreach ($items as $item) {

                $lastPrice = Report::getLastPrice($item['id']);

                if (intval($lastPrice['in_stock']) == 1) {
                    $in_stock = '<i class="far fa-check text-success"></i>';
                } else {
                    $in_stock ='';
                }

                if ((int)$lastPrice['price'] > 0) {
                    $lstprc = '<span class="font-weight-bold">' . $lastPrice['price'] . ' руб.</span>';
                } else {
                    $lstprc = '';
                }



                $url = '<a href="' . $item['product_url'] . '" target="_blank">' . GeneralChecks::parseHost($item['product_url']) . '</a>';


                if ($homeCompetitorId == $item['competitor_id']) {
                    $is_home = '<i class="fas fa-home text-success mr-2"></i>';
                } else {
                    $is_home = '';
                }


                $grid .= '<tr>
                            <td scope="row">' . $is_home . $url . ' <i class="far fa-external-link text-primary"></i></td>
                            <td><span class="text-muted">' . $lastPrice['timestamp'] . '</span></td>
                            <td>'. $lstprc . '</td>
                            <td>' . $in_stock . '</td>
                            <td></td>
                          </tr>';

            }

            $grid .= "</tbody></table>";
            return $grid;
        }
        return $grid;

    }

    public static function getCountCompetitorPrices() {

        $db = new DB();
        $sql = 'SELECT COUNT(*) from price';
        $result = $db->prepare($sql);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_NUM);
        $count = $result->fetch();

        return $count[0];
    }


    public static function competitorsGrid($campaign_id)
    {

        $items = self::getCompetitors($campaign_id);

        $grid = '';

        if (count($items) > 0 && $items != false) {

            $grid = "<table class='table'>
                        <thead class='thead-light'>
                            <tr>
                                <th scope='col'>Конкурент</th>
                                <th scope='col'>Индекс цены</th>
                                <th scope='col'>Цены</th>
                            </tr>
                        </thead>
                    <tbody>";

            foreach ($items as $item) {

                $competitor = $item['url'];



                $grid .= '<tr>
                            <td scope="row">' . $competitor . '

                            </td>
                            <td></td>
                            <td></td>
                          </tr>';

            }

            $grid .= "</tbody></table>";
            return $grid;
        }
        return $grid;

    }




}
