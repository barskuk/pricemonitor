<?php

class SiteController
{
    public function actionIndex() {


        require_once(ROOTDIR . '/app/resources/views/site/index.php');

        return true;
    }

}