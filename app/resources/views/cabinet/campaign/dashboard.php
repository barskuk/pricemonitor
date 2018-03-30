<?php
include ROOTDIR . '/app/resources/views/layouts/backend/head.html';
include ROOTDIR . '/app/resources/views/layouts/backend/nav.html';
include ROOTDIR . '/app/resources/views/layouts/backend/sidebar.html';
?>

    <main role="main" class="ml-sm-auto col-9 pt-3 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Рабочий стол "<?php echo $campaign['name']; ?>"</h1>
        </div>

        <?php if($campaign['id'] == 13): ?>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <canvas id="myChart" width="400" height="100%"></canvas>
                    </div>
                </div>

            </div>
        </div>
        <?php endif; ?>

        <?php include ROOTDIR . '/app/resources/views/layouts/frontend/error.php'; ?>


        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Товаров: <?php echo $productCount; ?></h5>
                        <a href="http://price.loc/cabinet/campaign/<?php echo $campaign['id']; ?>/products/all" class="btn btn-primary">К товарам</a>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Категорий: <?php echo $categoryCount; ?></h5>
                        <p class="card-text"></p>
                        <a href="http://price.loc/cabinet/campaign/<?php echo $campaign['id']; ?>/category/all" class="btn btn-primary">К категориям</a>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Брендов: <?php echo $brandCount; ?></h5>
                        <p class="card-text"></p>
                        <a href="http://price.loc/cabinet/campaign/<?php echo $campaign['id']; ?>/brands/all" class="btn btn-primary">К брендам</a>
                    </div>
                </div>
            </div>

        </div>
        <div class="row mt-3">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Конкурентов: <?php echo $competitorCount; ?></h5>
                        <p class="card-text"></p>
                        <a href="http://price.loc/cabinet/campaign/<?php echo $campaign['id']; ?>/competitors/all" class="btn btn-primary">К конкурентам</a>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Фидов: <?php echo $feedCount; ?></h5>
                        <a href="http://price.loc/cabinet/campaign/<?php echo $campaign['id']; ?>/products/import" class="btn btn-primary">К фидам</a>
                    </div>
                </div>
            </div>

        </div>


    </main>

<?php
include ROOTDIR . '/app/resources/views/layouts/backend/footer.html';
?>