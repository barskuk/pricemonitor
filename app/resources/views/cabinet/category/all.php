<?php
include ROOTDIR . '/app/resources/views/layouts/backend/head.html';
include ROOTDIR . '/app/resources/views/layouts/backend/nav.html';
include ROOTDIR . '/app/resources/views/layouts/backend/sidebar.html';
?>

    <main role="main" class="ml-sm-auto col-9 pt-3 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2">
            <h1 class="h2">Категории в "<?php echo $campaign['name']; ?>"</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <a id="buttonForHideForm" class="btn btn-primary btn-primary" href="#" role="button">Добавить</a>
            </div>
        </div>

        <?php include ROOTDIR . '/app/resources/views/layouts/backend/breadcrumb.html'; ?>

        <?php include ROOTDIR . '/app/resources/views/layouts/frontend/error.php'; ?>
        <?php
            if (isset($_POST['submit']) && $errors == FALSE) {
                echo "<div class='alert alert-success' role='alert'>Категория <b>". $_POST['cat_name'] . "</b> создана!</div>";
            }
        ?>

        <form action="" method="post">
            <div id="hideForm" class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2" style="display: none">
                <input type="text" class="form-control mr-4" name="cat_name" placeholder="Новая категория">
                <div class="btn-toolbar mb-2 mb-md-0"><button type="submit" name="submit" class="btn btn-primary">Добавить</button></div>
            </div>
        </form>


        <?php if ($countCategory == 0) {
            echo "<div class='alert alert-warning mt-4' role='alert'>У Кампании нет категорий!</div>";
        } else {
            echo $grid;
        } ?>

        <?php echo $pagination->get(); ?>


    </main>

<?php
include ROOTDIR . '/app/resources/views/layouts/backend/footer.html';
?>