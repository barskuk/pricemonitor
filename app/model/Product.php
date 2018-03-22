<?php

class Product
{
    const SHOW_BY_DEFAULT = 5;

    private static function getProducts($page, $campaignId, $count = self::SHOW_BY_DEFAULT) {

        $page = intval($page);
        $offset = ($page - 1) * $count;

        $db = new DB();
        $sql = 'SELECT * FROM product WHERE campaign_id=:campaign_id ORDER BY name ASC '
            . 'LIMIT ' . $count
            . ' OFFSET ' . $offset;

        $result = $db->prepare($sql);
        $result->bindParam(':campaign_id', $campaignId, PDO::PARAM_INT);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);

            $i = 0;
            while ($row = $result->fetch()) {
                $productsList[$i]['id'] = $row['id'];
                $productsList[$i]['name'] = $row['name'];
                $productsList[$i]['code'] = $row['code'];
                $productsList[$i]['vendor_code'] = $row['vendor_code'];
                $productsList[$i]['is_active'] = $row['is_active'];
                $productsList[$i]['brand_id'] = $row['brand_id'];
                $productsList[$i]['category_id'] = $row['category_id'];
                $i++;
            }
            if (isset($productsList)) {
                return $productsList;
            } else {
                return false;
            }

    }


    public static function productsGrid($page, $campaignId, $count= self::SHOW_BY_DEFAULT) {

        $products = self::getProducts($page, $campaignId);
        $grid = '';

        if (count($products) > 0 && $products != false) {

            $grid = "<table class='table table-bordered'>
                        <thead>
                            <tr>
                                <th scope='col'>Название / Бренд / Категория</th>
                                <th scope='col'>Имя</th>
                                <th scope='col'>Дата</th>
                                <th scope='col'>Черновик</th>
                                <th scope='col'>Url</th>
                                <th scope='col'>Действия</th>
                            </tr>
                        </thead>
                    <tbody>";

            foreach ($products as $product) {

                $grid .= '<tr>
                            <th scope="row">' . $product['name'] . '<br> </th>
                            <td>1</td>
                            <td>2</td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>';

            }

            $grid .= "</tbody></table>";
            return $grid;
        }
        return $grid;
    }


    public static function getTotalCountProductsInCampaign($campaignId) {

        $db = new DB();
        $sql = 'SELECT COUNT(*) from product WHERE campaign_id=:campaign_id';
        $result = $db->prepare($sql);
        $result->bindParam(':campaign_id', $campaignId, PDO::PARAM_STR);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_NUM);
        $count = $result->fetch();

        return $count[0];
    }


    public static function add($campaignId, $p_name, $p_code, $p_vendor_code, $p_category, $p_brand, $p_is_active) {

        if ($p_brand != 1) {
            $p_brand = self::addBrand();
        }

        if ($p_category != 1) {
            $p_category = self::addCategory();
        }

        $db = new DB();

        $sql = "INSERT INTO product (
                                      name, 
                                      code, 
                                      vendor_code, 
                                      is_active, 
                                      brand_id, 
                                      category_id, 
                                      campaign_id ) 
                                       
                            VALUES (
                                      :name, 
                                      :code, 
                                      :vendor_code, 
                                      :is_active,
                                      :brand_id,
                                      :category_id,
                                      :campaign_id )";
        $result = $db->prepare($sql);
        $result->bindParam(':name', $p_name, PDO::PARAM_STR);
        $result->bindParam(':code', $p_code, PDO::PARAM_STR);
        $result->bindParam(':vendor_code', $p_vendor_code, PDO::PARAM_STR);
        $result->bindParam(':is_active', $p_is_active, PDO::PARAM_STR);
        $result->bindParam(':brand_id', $p_brand, PDO::PARAM_STR);
        $result->bindParam(':category_id', $p_category, PDO::PARAM_STR);
        $result->bindParam(':campaign_id', $campaignId, PDO::PARAM_STR);

        return $result->execute();

        //$arr = $result->errorInfo();
        //print_r($arr);
    }


    public static function checkCodeProductExist($code, $campaignId) {

        $db = new DB();
        $sql = 'SELECT COUNT(*) FROM product WHERE code=:code AND campaign_id=:campaign_id';
        $result = $db->prepare($sql);
        $result->bindParam(':code', $code, PDO::PARAM_STR);
        $result->bindParam(':campaign_id', $campaignId, PDO::PARAM_STR);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_NUM);
        $count = $result->fetch();

        if ($count[0] == 0) {
            return TRUE;
        } else {
            return FALSE;
        }

    }



    private static function addBrand() {
        return true;
    }

}