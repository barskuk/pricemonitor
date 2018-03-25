<?php
include ROOTDIR . '/app/resources/views/layouts/backend/head.html';
include ROOTDIR . '/app/resources/views/layouts/backend/nav.html';
include ROOTDIR . '/app/resources/views/layouts/backend/sidebar.html';
?>

    <main role="main" class="ml-sm-auto col-9 pt-3 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2">
            <h1 class="h2">Фиды в "<?php echo $campaign['name']; ?>"</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <a id="buttonForHideForm" class="btn btn-primary btn-primary" href="#" role="button">Добавить</a>
            </div>
        </div>

        <?php include ROOTDIR . '/app/resources/views/layouts/backend/breadcrumb.html'; ?>

        <?php include ROOTDIR . '/app/resources/views/layouts/frontend/error.php'; ?>
        <?php
            if (isset($_POST['submit']) && $errors == FALSE) {
                echo "<div class='alert alert-success' role='alert'>Фид добавлен!</div>";
            }
        ?>

        <form action="" method="post">

            <div id="hideForm" style="display: none">

                <div class="form-group">
                    <div>
                        <label class="col-form-label">Активировать фид</label>
                    </div>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-success active">
                            <input type="radio" name="is_active" value="on" autocomplete="off" checked> Вкл
                        </label>
                        <label class="btn btn-danger">
                            <input type="radio" name="is_active" value="off" autocomplete="off"> Выкл
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <div>
                        <label class="col-form-label">Тип файла</label>
                    </div>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-primary active">
                            <input type="radio" name="type" value="yml" autocomplete="off" checked> YML
                        </label>
                        <label class="btn btn-secondary">
                            <input type="radio" name="type" value="excel2003" autocomplete="off"> Excel 2003
                        </label>
                        <label class="btn btn-secondary">
                            <input type="radio" name="type" value="custom" autocomplete="off"> Произвольный
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <div>
                        <label class="col-form-label">Режим обработки файла</label>
                    </div>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-primary active">
                            <input type="radio" name="mode" value="add" autocomplete="off" checked> Добавление
                        </label>
                        <label class="btn btn-secondary">
                            <input type="radio" name="mode" value="update" autocomplete="off"> Обновление
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-form-label">Адрес фида</label>
                    <input type="text" class="form-control mr-4" name="url" placeholder="http://">
                </div>
                <div class="form-group">
                    <div>
                        <label class="col-form-label">Авторежим</label>
                    </div>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-success active">
                            <input type="radio" name="auto" value="on" autocomplete="off" checked> Вкл
                        </label>
                        <label class="btn btn-danger">
                            <input type="radio" name="auto" value="off" autocomplete="off"> Выкл
                        </label>
                    </div>
                </div>

                <div class="btn-toolbar mb-2 mb-md-0"><button type="submit" name="submit" class="btn btn-primary">Добавить</button></div>
            </div>
        </form>

        <?php
        if ($countFeeds == 0) {
            echo "<div class='alert alert-warning mt-4' role='alert'>У Кампании нет фидов!</div>";
        } else {
            echo $grid;
        } ?>

        <?php
            if ($countFeeds > $countInPage) {
                echo $pagination->get();
            }
        ?>

    </main>

<?php
include ROOTDIR . '/app/resources/views/layouts/backend/footer.html';
?>