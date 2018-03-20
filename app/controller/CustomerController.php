<?php

class CustomerController
{
    public function actionRegister() {

        $name = '';
        $email = '';
        $password = '';
        $result = FALSE;

        if(isset($_POST['submit'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $errors = FALSE;

            if (!Customer::checkName($name)) {
                $errors['name'] = "Имя должно быть длиннее 5 символов";
            }

            if (!Customer::checkEmail($email)) {
                $errors['email'] = "Неправильный формат электронной почты";
            }

            if (!Customer::checkPassword($password)) {
                $errors['password'] = "Пароль должен быть длиннее 8 символов";
            }

            if (!Customer::checkEmailExist($email)) {
                $errors['email'] = "Аккаут с таким email существует!";
            }

            //Если нет ошибок при заполнении формы
            if ($errors == FALSE) {
                $result = Customer::register($name, $email, $password);
            }
        }
        require_once(ROOTDIR . '/app/resources/views/customer/register.php');
        return true;
    }

    public function actionLogin() {
        $email = '';
        $password = '';
        $error = FALSE;

        if(isset($_POST['submit'])) {
            echo "я здесь";
            $email = $_POST['email'];
            $password = $_POST['password'];

            if (!Customer::checkEmail($email)) {
                $errors['email'] = "Неправильный формат электронной почты";
            }

            $customerId = Customer::checkCustomerExist($email,$password);
            var_dump($customerId);

            if ($customerId == FALSE) {
                echo "я тут";
                $errors['auth'] = 'Неправильно введен логин или пароль!';
            } else {
                echo "здеся";
                Customer::auth($customerId);
                header("Location: " . ROOTSITE . "cabinet");
            }
        }
        require_once(ROOTDIR . '/app/resources/views/customer/login.php');
        return true;
    }

    public function actionLogout() {
        unset($_SESSION['customer']);
        header('Location: ' . ROOTSITE . 'login');
    }

}