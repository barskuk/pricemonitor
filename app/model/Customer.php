<?php

class Customer
{
    public static function register($name, $email, $password) {
        $db = new DB();
        $sql = "INSERT INTO customer (name, email, password) VALUES (:name, :email, :password)";
        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);

        return $result->execute();
    }

    public static function checkName($name) {
        if (strlen($name) >= 5) {
            return TRUE;
        }
        return FALSE;
    }

    public static function checkEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return TRUE;
        }
        return FALSE;
    }

    public static function checkPassword($password) {
        if (strlen($password) >= 8) {
            return TRUE;
        }
        return FALSE;
    }

    public static function checkEmailExist($email) {
        $db = new DB();
        $sql = 'SELECT COUNT(*) FROM customer WHERE email=:email';
        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_NUM);
        $count = $result->fetch();

        if ($count[0] == 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function checkUserExist($email, $password) {

        $db = new DB();
        $sql = 'SELECT * FROM customer WHERE email = :email AND password = :password';
        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_INT);
        $result->bindParam(':password', $password, PDO::PARAM_INT);
        $result->execute();
        $user = $result->fetch();

        if ($user) {
            return $user['id'];
        } else {
            return FALSE;
        }
    }

    public static function checkAuth() {
        if (isset($_SESSION['customer'])) {
            return $_SESSION['customer'];
        }
        header('Location: ' . ROOTSITE . 'login');
    }

    public static function isAuth() {
        if (isset($_SESSION['customer'])) {
            return TRUE;
        }
        return FALSE;
    }

    public static function checkCustomerExist($email, $password) {

        $db = new DB();
        $sql = 'SELECT * FROM customer WHERE email = :email AND password = :password';
        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_INT);
        $result->bindParam(':password', $password, PDO::PARAM_INT);
        $result->execute();
        $customer = $result->fetch();

        if ($customer) {
            return $customer['id'];
        } else {
            return FALSE;
        }
    }

    public static function auth($customerId) {
        $_SESSION['customer'] = $customerId;
        header('Location: ' . ROOTSITE . 'cabinet');
    }

    public static function getName() {
        $customerId = Customer::checkAuth();

        if (isset($customerId)) {
            $db = new DB();
            $sql = 'SELECT * FROM customer WHERE id =:customerId ';
            $result = $db->prepare($sql);
            $result->bindParam(':customerId', $customerId, PDO::PARAM_STR);
            $result->execute();
            $customer = $result->fetch();

            if ($customer) {
                return $customer['name'];
            }
            return FALSE;
        }
    }
    public static function getCountCustomers() {

        $db = new DB();
        $sql = 'SELECT COUNT(*) from customer';
        $result = $db->prepare($sql);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_NUM);
        $count = $result->fetch();

        return $count[0];

    }

}