<?php

class Brand
{
    const SHOW_BY_DEFAULT = 5;

    public static function add($b_name, $campId) {

        $db = new DB();

        $sql = "INSERT INTO brand (name, campaign_id) VALUES (:name, :campaign_id )";
        $result = $db->prepare($sql);
        $result->bindParam(':name', $b_name, PDO::PARAM_STR);
        $result->bindParam(':campaign_id', $campId, PDO::PARAM_STR);

        return $result->execute();

        //$arr = $result->errorInfo();
        //print_r($arr);
    }

    public static function checkName($b_name) {
        if (strlen($b_name) >= 3) {
            return TRUE;
        }
        return FALSE;
    }

    public static function checkNameExist($b_name, $campId) {

        $db = new DB();
        $sql = 'SELECT COUNT(*) FROM brand WHERE name=:name AND campaign_id=:campaign_id';
        $result = $db->prepare($sql);
        $result->bindParam(':name', $b_name, PDO::PARAM_STR);
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

    public static function getTotalCountBrandsInCampagn($campId) {

        $db = new DB();
        $sql = 'SELECT COUNT(*) from brand WHERE campaign_id=:campaign_id';
        $result = $db->prepare($sql);
        $result->bindParam(':campaign_id', $campId, PDO::PARAM_STR);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_NUM);
        $count = $result->fetch();

        return $count[0];

    }


    public static function brandGrid($page, $camId, $count= self::SHOW_BY_DEFAULT) {

        $brand = self::getBrand($page, $camId);

        $grid = '';

        if (count($brand) > 0 && $brand != false) {
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

            foreach ($brand as $brnd) {

                $grid .= '<tr>
                            <th scope="row">' . $brnd['name'] . '<br> </th>
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
    }

    private static function getBrand($page, $camId, $count = self::SHOW_BY_DEFAULT) {

        $page = intval($page);
        $offset = ($page - 1) * $count;

        $db = new DB();
        $sql = 'SELECT * FROM brand WHERE campaign_id=:campaign_id ORDER BY name ASC '
            . 'LIMIT ' . $count
            . ' OFFSET ' . $offset;

        $result = $db->prepare($sql);
        $result->bindParam(':campaign_id', $camId, PDO::PARAM_INT);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);

        if ($result->fetch() == true) {
            $i = 0;
            while ($row = $result->fetch()) {
                $brandList[$i]['id'] = $row['id'];
                $brandList[$i]['name'] = $row['name'];
                $i++;
            }
            return $brandList;
        } else {
            return false;
        }
    }

}