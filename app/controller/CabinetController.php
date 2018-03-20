<?php

class CabinetController
{
    public function actionIndex() {

        $customerId = Customer::checkAuth();

        require_once(ROOTDIR . '/app/resources/views/cabinet/index.php');

        return true;
    }

}