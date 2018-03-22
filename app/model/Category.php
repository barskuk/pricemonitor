<?php

class Category
{
    const SHOW_BY_DEFAULT = 5;

    public static function add($cat_name, $campId) {

        $db = new DB();

        $sql = "INSERT INTO category (name, campaign_id) VALUES (:name, :campaign_id )";
        $result = $db->prepare($sql);
        $result->bindParam(':name', $cat_name, PDO::PARAM_STR);
        $result->bindParam(':campaign_id', $campId, PDO::PARAM_STR);

        return $result->execute();

        //$arr = $result->errorInfo();
        //print_r($arr);
    }

    public static function checkName($cat_name) {
        if (strlen($cat_name) >= 3) {
            return TRUE;
        }
            return FALSE;
    }

    public static function checkNameExist($cat_name, $campId) {

        $db = new DB();
        $sql = 'SELECT COUNT(*) FROM category WHERE name=:name AND campaign_id=:campaign_id';
        $result = $db->prepare($sql);
        $result->bindParam(':name', $cat_name, PDO::PARAM_STR);
        $result->bindParam(':campaign_id', $campId, PDO::PARAM_STR);
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
    public static function getId($cat_name, $campId) {

        $db = new DB();
        $sql = 'SELECT id FROM category WHERE name=:name AND campaign_id=:campaign_id';
        $result = $db->prepare($sql);
        $result->bindParam(':name', $cat_name, PDO::PARAM_STR);
        $result->bindParam(':campaign_id', $campId, PDO::PARAM_STR);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_NUM);
        $id = $result->fetch();
        return $id[0];

    }
    //

    public static function getTotalCountCategoryInCampagn($campId) {

        $db = new DB();
        $sql = 'SELECT COUNT(*) from category WHERE campaign_id=:campaign_id';
        $result = $db->prepare($sql);
        $result->bindParam(':campaign_id', $campId, PDO::PARAM_STR);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_NUM);
        $count = $result->fetch();

        return $count[0];

    }


    public static function categoryGrid($page, $camId, $count= self::SHOW_BY_DEFAULT) {

        $category = self::getCategory($page, $camId);
        $grid = '';

        if (count($category) > 0 && $category != false) {
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

            foreach ($category as $cat) {

                $grid .= '<tr>
                            <th scope="row">' . $cat['name'] . '<br> </th>
                            <td>1</td>
                            <td>2</td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>';

            }

            $grid .= "</tbody></table>";
            return $grid;
        } else {
            return $grid;
        }
    }

    private static function getCategory($page, $camId, $count = self::SHOW_BY_DEFAULT) {

        $page = intval($page);
        $offset = ($page - 1) * $count;

        $db = new DB();
        $sql = 'SELECT * FROM category WHERE campaign_id=:campaign_id ORDER BY name ASC '
            . 'LIMIT ' . $count
            . ' OFFSET ' . $offset;

        $result = $db->prepare($sql);
        $result->bindParam(':campaign_id', $camId, PDO::PARAM_INT);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);

            $i = 0;
            while ($row = $result->fetch()) {
                $categoryList[$i]['id'] = $row['id'];
                $categoryList[$i]['name'] = $row['name'];
                $i++;
            }
            if (isset($categoryList)) {
                return $categoryList;
            } else {
                return false;
            }
    }


}
