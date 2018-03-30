<?php
include ROOTDIR . '/app/resources/views/layouts/backend/head.html';
include ROOTDIR . '/app/resources/views/layouts/backend/nav.html';
include ROOTDIR . '/app/resources/views/layouts/backend/sidebar.html';
?>

    <main role="main" class="ml-sm-auto col-9 pt-3 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2">
            <h2>Товар "<?php echo $product['name']; ?>"</h2>
        </div>

        <?php include  ROOTDIR . '/app/resources/views/layouts/backend/breadcrumb.html'; ?>
        <!-- Временные крошки -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo ROOTSITE; ?>cabinet">Главная</a></li>
                <li class="breadcrumb-item"><a href="<?php echo ROOTSITE; ?>cabinet"><i class="far fa-home"></i> Кампании</a></li>
                <li class="breadcrumb-item"><a href="<?php echo ROOTSITE; ?>cabinet/campaign/<?php echo $campaign['id']; ?>/dashboard"><i class="far fa-database"></i> <?php echo $campaign['name']; ?></a></li>
                <li class="breadcrumb-item"><a href="<?php echo ROOTSITE; ?>cabinet/campaign/<?php echo $campaign['id']; ?>/products/all"><i class="far fa-list"></i> Товары</a></li>
                <li class="breadcrumb-item active" aria-current="page"><i class="far fa-list"></i> <?php echo $product['name']; ?></li>
            </ol>
        </nav>
        <!-- /Временные крошки -->

        <?php include ROOTDIR . '/app/resources/views/layouts/frontend/error.php'; ?>

        <div class="row">
            <div class="col-9">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2">
                            <h5>Ссылки</h5>
                            <div class="btn-toolbar mb-2 mb-0">
                                <a id="buttonForHideForm" class="btn btn-success btn-sm" href="" role="button"><i class="far fa-plus-circle text-white mr-1"></i> Добавить</a>
                            </div>
                        </div>
                        <div>
                        <form action="" method="post">
                            <div id="hideForm" class="input-group mb-3">
                                <input type="text" class="form-control" name="product_url" placeholder="Ссылка на товар">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit" name="submit_add_url">Добавить</button>
                                </div>
                            </div>
                        </form>
                        </div>
                        <?php
                            echo $grid;
                            if ($countCompetitorProducts == 0) {
                                echo "<div class='alert alert-warning mt-4' role='alert'>У Товара нет ссылок!</div>";
                            };
                        ?>

                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-body">
                        <h6><?php echo $product['name']; ?></h6>

                        <div class="clearfix">
                            <span class="text-muted">Активность</span>
                            <div class="fa-pull-right">
                                <?php
                                    if ($product['is_active'] == 1) {
                                        echo '<i class="far fa-circle text-success"></i>';
                                    } else {
                                        echo '<i class="far fa-circle text-secondary"></i>';
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="clearfix">
                            <span class="text-muted">Внутренний код</span>
                            <div class="fa-pull-right">
                                <?php echo $product['code']; ?>
                            </div>
                        </div>
                        <div class="clearfix">
                            <span class="text-muted">Артикул</span>
                            <div class="fa-pull-right">
                                <?php echo $product['vendor_code']; ?>
                            </div>
                        </div>
                        <?php if(intval($product['category_id']) != 1): ?>
                        <div class="clearfix">
                            <span class="text-muted">Категория</span>
                            <div class="fa-pull-right">
                                <?php
                                    echo $catName['name'];
                                ?>
                            </div>
                        </div>
                        <? endif;?>
                        <?php if(intval($product['brand_id']) != 1): ?>
                            <div class="clearfix">
                                <span class="text-muted">Категория</span>
                                <div class="fa-pull-right">
                                    <?php
                                    echo $brandName['name'];
                                    ?>
                                </div>
                            </div>
                        <? endif;?>

                    </div>
                </div>
            </div>
        </div>
    </main>
<?php
include ROOTDIR . '/app/resources/views/layouts/backend/footer.html';
?>