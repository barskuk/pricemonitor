<?php

class Feed
{

    const SHOW_BY_DEFAULT = 10;

    public static function getTotalCountFeedsInCampagn($campId)
    {

        $db = new DB();
        $sql = 'SELECT COUNT(*) from feed WHERE campaign_id=:campaign_id';
        $result = $db->prepare($sql);
        $result->bindParam(':campaign_id', $campId, PDO::PARAM_STR);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_NUM);
        $count = $result->fetch();

        return $count[0];

    }
    public static function checkFeedUrlExist($url, $campaign_id) {

        $db = new DB();
        $sql = 'SELECT COUNT(*) FROM feed WHERE url=:url AND campaign_id=:campaign_id';
        $result = $db->prepare($sql);
        $result->bindParam(':url', $url, PDO::PARAM_STR);
        $result->bindParam(':campaign_id', $campaign_id, PDO::PARAM_STR);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_NUM);
        $count = $result->fetch();

        if ($count[0] == 0) {
            return TRUE;
        } else {
            return FALSE;
        }

    }

    public static function add($is_active, $type, $mode, $url, $auto, $campId)
    {

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

    private static function getFeeds($page, $campaignId, $count = self::SHOW_BY_DEFAULT)
    {

        $page = intval($page);
        $offset = ($page - 1) * $count;

        $db = new DB();
        $sql = 'SELECT * FROM feed WHERE campaign_id=:campaign_id ORDER BY create_time ASC '
            . 'LIMIT ' . $count
            . ' OFFSET ' . $offset;

        $result = $db->prepare($sql);
        $result->bindParam(':campaign_id', $campaignId, PDO::PARAM_INT);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);

        $i = 0;
        while ($row = $result->fetch()) {
            $feedsList[$i]['id'] = $row['id'];
            $feedsList[$i]['url'] = $row['url'];
            $feedsList[$i]['type'] = $row['type'];
            $feedsList[$i]['mode'] = $row['mode'];
            $feedsList[$i]['is_active'] = $row['is_active'];
            $feedsList[$i]['auto'] = $row['auto'];
            $feedsList[$i]['campaign_id'] = $row['campaign_id'];
            $feedsList[$i]['create_time'] = $row['create_time'];
            $i++;
        }
        if (isset($feedsList)) {
            return $feedsList;
        } else {
            return false; //Warning: count(): Parameter must be an array or an object that implements Countable in D:\xampp\htdocs\Proj\pricemonitor\app\model\Feed.php on line 84 => (false -> [])
        }

    }

    public static function feedGrid($page, $campId)
    {

        $items = self::getFeeds($page, $campId);

        $grid = '';

        if (count($items) > 0 && $items != false) {

            $grid = "<table class='table table-hover'>
                        <thead class='thead-light'>
                            <tr>
                                <th scope='col'>Ссылка на фид</th>
                                <th scope='col'>Авто</th>
                                <th scope='col'>Активен</th>
                                <th scope='col' class='text-right'>Действия</th>
                            </tr>
                        </thead>
                    <tbody>";

            foreach ($items as $item) {

                $feed = '<a href="' . $item['url'] . '" target="_blank">' . $item['url'] . ' <i class="far fa-external-link-alt"></i></a>';

                if ($item['type'] == 'yml') {

                    $badgeType = '<span class="badge badge-success mr-2">YML файл</span>';

                } elseif ($item['type'] == 'excel2003') {

                    $badgeType = '<span class="badge badge-success">Файл Excel 2003</span>';

                } elseif ($item['type'] == 'custom') {

                    $badgeType = '<span class="badge badge-success">Произвольный файл</span>';

                }

                if ($item['mode'] == 'add') {

                    $badgeMode = '<span class="badge badge-warning">Режим добавления</span>';

                } elseif ($item['mode'] == 'update') {

                    $badgeMode = '<span class="badge badge-warning">Режим обновления</span>';

                }

                if (intval($item['auto']) == 1) {

                    $auto = '<i class="far fa-check text-success"></i>';

                } else {

                    $auto = '<i class="far fa-times-circle text-secondary"></i>';

                }

                $is_active = intval($item['is_active']);
                if ($is_active == 1) {
                    $active_color = ' text-success';
                } else {
                    $active_color = ' text-danger';
                }

                $grid .= '<tr>
                            <td scope="row">' . $feed . '<div class="mt-2">' . $badgeType . $badgeMode . '</div>

                            </td>
                            <td>' . $auto . '</td>
                            <td><i class="far fa-circle' . $active_color . '"></i></td>
                            <td class="text-right"><i class="far fa-trash-alt text-danger"></i> <i class="far fa-pencil text-success ml-2"></i></td>
                          </tr>';

            }

            $grid .= "</tbody></table>";
            return $grid;
        }
        return $grid;

    }

    //
    public static function importFromYML($feed_url, $campId)
    {
        $yml_obj = simplexml_load_file($feed_url);
        $categories = [];
        $categoriesDB = [];
        $offers = [];
        $vendors = [];

        foreach ($yml_obj->children() as $shop) {
            foreach ($shop->children() as $param) {
                if ($param->getName() == "categories") {
                    foreach ($param->children() as $category) {
                        $categories[(int)$category["id"]] = (string)$category;
                    }
                }
                if ($param->getName() == "offers") {
                    foreach ($param->children() as $offer) {
                        //default parametrs for each offer
                        $offers[(int)$offer["id"]]["vendor"] = "Без бренда";
                        $vendors["Без бренда"] = -1;

                        foreach ($offer->children() as $data) {
                            $offers[(int)$offer["id"]]["available"] = ($offer["available"] == TRUE) ? 1 : 0;
                            if ($data->getName() == "url") $offers[(int)$offer["id"]][$data->getName()] = (string)$data;
                            if ($data->getName() == "price") $offers[(int)$offer["id"]][$data->getName()] = (int)$data;
                            if ($data->getName() == "currencyId") $offers[(int)$offer["id"]][$data->getName()] = (string)$data;
                            if ($data->getName() == "categoryId") $offers[(int)$offer["id"]][$data->getName()] = (int)$data;
                            if ($data->getName() == "name") $offers[(int)$offer["id"]][$data->getName()] = (string)$data;
                            if ($data->getName() == "vendor") {
                                $offers[(int)$offer["id"]][$data->getName()] = (string)$data;
                                $vendors[(string)$data] = -1;
                            }
                            if ($data->getName() == "vendorCode") $offers[(int)$offer["id"]][$data->getName()] = (string)$data;
                            if ($data->getName() == "url") $offers[(int)$offer["id"]][$data->getName()] = (string)$data;
                        }
                    }
                }
            }
        }

        foreach ($categories as $key => $cat_name) {
            if (Category::checkNameExist($cat_name, $campId)) Category::add($cat_name, $campId);
            $categoriesDB[$cat_name] = Category::getId($cat_name, $campId);
        }

        foreach ($vendors as $vendor_name => $vendor_id) {
            if (Brand::checkNameExist($vendor_name, $campId)) Brand::add($vendor_name, $campId);
            $vendors[$vendor_name] = Brand::getId($vendor_name, $campId);
        }

        foreach ($offers as $code => $offer) {
            if (Product::checkCodeProductExist($code, $campId)) {
                $product_id = Product::add($campId, $offer["name"], $code, $offer["vendorCode"], (int)$categoriesDB[$categories[$offer["categoryId"]]], (int)$vendors[$offer["vendor"]], $offer["available"]);


                //проверяем создан ли наш Competitor
                if (Competitor::getHomeCompetitorId($campId)) {
                    $homeCompetitotId = Competitor::getHomeCompetitorId($campId);
                } else {
                    //если нет, то создаем
                    $hostArr = parse_url($offer["url"]);
                    $host = $hostArr['host'];
                    $homeCompetitotId = Competitor::add($host, $campId, 1);
                }

                $competitor_product_id = Competitor::competitorProductAdd($offer["url"], (int)$product_id, $homeCompetitotId);
                //подтягиваем нашу цену первый раз
                Competitor::addCompetitorPrice($competitor_product_id, $offer["price"]);


            }
        }

    }
}
