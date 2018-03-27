<?php


class AdminController{

  public function actionIndex($param) {

    if (isset($_POST['submit'])) {
      if($_POST['submit'] == "UpdatePrices"){
        $result = Admin::updatePrices();
      }
    }

    require_once(ROOTDIR . '/app/resources/views/admin/index.php');
    return true;
  }
}

?>
