<?php
include ROOTDIR . '/app/resources/views/layouts/backend/head.html';
include ROOTDIR . '/app/resources/views/layouts/backend/nav.html';
include ROOTDIR . '/app/resources/views/layouts/backend/sidebar.html';
?>

    <main role="main" class="ml-sm-auto col-9 pt-3 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Новый товар</h1>
        </div>

        <?php include ROOTDIR . '/app/resources/views/layouts/frontend/error.php'; ?>
        <?php
        if ($result == TRUE && $errors == FALSE) {
            echo "<div class='alert alert-success' role='alert'>Товар <b>". $_POST['p_name'] . "</b> создан!</div>";
        }
        ?>
        <form class="mt-4" action="" method="post">
            <div class="form-group">
                <div class="row">
                    <div class="col-2">
                        <label>Название товара</label>
                    </div>
                    <div class="col-9">
                        <input type="text" class="form-control" name="p_name">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-2">
                        <label>Внутренний код</label>
                    </div>
                    <div class="col-9">
                        <input type="text" class="form-control" name="p_code">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-2">
                        <label>Артикул</label>
                    </div>
                    <div class="col-9">
                        <input type="text" class="form-control" name="p_vendor_code">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-2">
                        <label>Категория</label>
                    </div>
                    <div class="col-9">
                        <input type="text" class="form-control" name="p_category">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-2">
                        <label>Бренд</label>
                    </div>
                    <div class="col-9">
                        <input type="text" class="form-control" name="p_brand">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-2">
                        <label>Мониторинг</label>
                    </div>
                    <div class="col-9">
                        <input type="checkbox" class="form-control" name="p_is_active">
                    </div>
                </div>
            </div>


            <button type="submit" name="submit" class="btn btn-primary">Создать</button>
        </form>

    </main>

<?php
include ROOTDIR . '/app/resources/views/layouts/backend/footer.html';
?>