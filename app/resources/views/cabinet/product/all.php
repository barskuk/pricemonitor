<?php
include ROOTDIR . '/app/resources/views/layouts/backend/head.html';
include ROOTDIR . '/app/resources/views/layouts/backend/nav.html';
include ROOTDIR . '/app/resources/views/layouts/backend/sidebar.html';
?>

    <main role="main" class="ml-sm-auto col-9 pt-3 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2">
            <h1 class="h2">Товары в "<?php echo $campaign['name']; ?>"</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <a class="btn btn-primary btn-success" href="<?php echo ROOTSITE . 'cabinet/campaign/' . $campaign['id'] . '/products/add'; ?>" role="button">Добавить</a>
            </div>
        </div>

        <?php include  ROOTDIR . '/app/resources/views/layouts/backend/breadcrumb.html'; ?>

        <?php include ROOTDIR . '/app/resources/views/layouts/frontend/error.php'; ?>

        <?php
        if ($totalProducts == 0) {
            echo "<div class='alert alert-warning mt-4' role='alert'>У Кампании нет товаров!</div>";
        } else {
            echo $grid;
        } ?>

        <?php echo $pagination->get(); ?>

    </main>

<?php
include ROOTDIR . '/app/resources/views/layouts/backend/footer.html';
?>