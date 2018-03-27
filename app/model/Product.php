<?php

class Product
{
    const SHOW_BY_DEFAULT = 10;

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
                                <th scope='col'>Дата</th>
                                <th scope='col'>Индекс цены</th>
                                <th scope='col'>Своя цена</th>
                                <th scope='col'>Конкуренты</th>
                                <th scope='col'></th>
                            </tr>
                        </thead>
                    <tbody>";

            foreach ($products as $product) {

                $prod = '<a href="' . ROOTSITE . 'cabinet/campaign/' . $campaignId . '/product/' . $product['id'] . '">' . $product['name'] . '</a>';

                if ($product['code'] != NULL) {
                    $code = $product['code'];
                } else {
                    $code = '';
                }
                if ($product['vendor_code'] != NULL) {
                    $vendor_code = $product['vendor_code'];
                } else {
                    $vendor_code = '';
                }
                if ($product['code'] != NULL && $product['vendor_code'] != NULL) {
                    $razdel = ' / ';
                } else {
                    $razdel = '';
                }
                if ($product['code'] != NULL || $product['vendor_code'] != NULL) {
                    $icon_bar = "<i class='fas fa-barcode'></i> ";
                    $code_start = '<small class="text-muted pt-1">';
                    $code_end = '</small>';
                } else {
                    $icon_bar = '';
                    $code_start = '';
                    $code_end = '';
                }
                if ($product['brand_id'] != 1 || $product['category_id'] != 1) {
                    $icon_cat = "<i class='far fa-folder-open'></i> ";
                    $code_start = '<small class="text-muted pt-1">';
                    $code_end = '</small>';
                } else {
                    $icon_cat = '';
                    $code_start = '';
                    $code_end = '';
                }
                if ($product['brand_id'] != NULL && $product['category_id'] != NULL) {
                    $razdel = ' / ';
                } else {
                    $razdel = '';
                }
                if ($product['category_id'] != 1) {
                    $categoryId = $product['category_id'];
                    $categoryArr = Category::getCategoryById($categoryId);
                    $category = $categoryArr['name'];
                } else {
                    $category = '';
                }
                if ($product['brand_id'] != 1) {
                    $brandId = $product['brand_id'];
                    $brandArr = Brand::getBrandById($brandId);
                    $brand = $brandArr['name'];
                } else {
                    $brand = '';
                }


                $is_active = intval($product['is_active']);
                if ($is_active == 1) {
                    $active_color = ' text-success';
                } else {
                    $active_color = ' text-danger';
                }

                $cates = $code_start . $icon_cat . $category . $razdel . $brand . $code_end;

                $codes = $code_start . $icon_bar . $code . $razdel . $vendor_code . $code_end;

                $grid .= '<tr>
                            <th scope="row">' . $prod . '<br>' . $codes . '<br>' . $cates . '

                            </th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><i class="far fa-circle' . $active_color . '"></i></td>
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



    public static function add($campaignId, $p_name, $p_code, $p_vendor_code, $p_category = 1, $p_brand = 1, $p_is_active) {


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
        $result->execute();

        return $lastId = $db->lastInsertId();

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

    //
    public static function getProductId($code, $campaignId) {

        $db = new DB();
        $sql = 'SELECT COUNT(*) FROM product WHERE code=:code AND campaign_id=:campaign_id';
        $result = $db->prepare($sql);
        $result->bindParam(':code', $code, PDO::PARAM_STR);
        $result->bindParam(':campaign_id', $campaignId, PDO::PARAM_STR);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_NUM);
        $id = $result->fetch();

        return $id;
    }
    //

    public static function getProductById($id) {

        $db = new DB();
        $sql = 'SELECT * FROM product WHERE id=:id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);
        return $result->fetch();
    }


}
