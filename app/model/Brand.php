<?php

class Brand
{
    const SHOW_BY_DEFAULT = 10;

    public static function add($b_name, $campId) {

        $db = new DB();

        $sql = "INSERT INTO brand (name, campaign_id) VALUES (:name, :campaign_id )";
        $result = $db->prepare($sql);
        $result->bindParam(':name', $b_name, PDO::PARAM_STR);
        $result->bindParam(':campaign_id', $campId, PDO::PARAM_STR);

        return $result->execute();
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

    //
    public static function getId($b_name, $campId) {

        $db = new DB();
        $sql = 'SELECT id FROM brand WHERE name=:name AND campaign_id=:campaign_id';
        $result = $db->prepare($sql);
        $result->bindParam(':name', $b_name, PDO::PARAM_STR);
        $result->bindParam(':campaign_id', $campId, PDO::PARAM_STR);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_NUM);
        $id = $result->fetch();

        return $id[0];
    }
    //
    
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
            $grid = "<table class='table table-hover'>
                        <thead class='thead-light'>
                            <tr>
                                <th scope='col'>Бренд</th>
                                <th scope='col'>Индекс цены</th>
                                <th scope='col'>Отчет по цене</th>
                                <th scope='col' class='text-right'>Действия</th>
                            </tr>
                        </thead>
                    <tbody>";

            foreach ($brand as $brnd) {

                $grid .= '<tr>
                            <th scope="row">' . $brnd['name'] . '<br> </th>
                            <td></td>
                            <td></td>
                            <td class="text-right"><i class="far fa-trash-alt text-danger"></i> <i class="far fa-pencil text-success ml-2"></i></td>
                          </tr>';

            }

            $grid .= "</tbody></table>";
            return $grid;
        }
        return $grid;
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

        $i = 0;
        while ($row = $result->fetch()) {
            $brandList[$i]['id'] = $row['id'];
            $brandList[$i]['name'] = $row['name'];
            $i++;
        }
        if (isset($brandList)) {
            return $brandList;
        } else {
            return false;
        }
    }

    public static function getBrandById($id) {

        $db = new DB();
        $sql = 'SELECT * FROM brand WHERE id=:id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);
        return $result->fetch();
    }

}
