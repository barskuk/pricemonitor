<?php
include ROOTDIR . '/app/resources/views/layouts/backend/head.html';
include ROOTDIR . '/app/resources/views/layouts/backend/nav.html';
include ROOTDIR . '/app/resources/views/layouts/backend/sidebar.html';
?>

    <main role="main" class="ml-sm-auto col-9 pt-3 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Новая кампания</h1>
        </div>

        <?php include ROOTDIR . '/app/resources/views/layouts/frontend/error.php'; ?>
        <?php
        if ($result == TRUE && $errors == FALSE) {
            echo "<div class='alert alert-success' role='alert'>Кампания <b>". $_POST['c_name'] . "</b> создана!</div>";
        }
        ?>
        <form class="mt-4" action="" method="post">
            <div class="form-group">
                <div class="row">
                    <div class="col-2">
                        <label>Название</label>
                    </div>
                    <div class="col-9">
                        <input type="text" class="form-control" name="c_name" placeholder="Новая кампания">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-2">
                        <label>Сайт</label>
                    </div>
                    <div class="col-9">
                        <input type="text" class="form-control" name="c_url" placeholder="https://">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-2">
                        <label>Регион</label>
                    </div>
                    <div class="col-9">
                        <input type="text" class="form-control" name="c_region">
                    </div>
                </div>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Создать</button>
        </form>

    </main>

<?php
include ROOTDIR . '/app/resources/views/layouts/backend/footer.html';
?>