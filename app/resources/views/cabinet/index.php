<?php
include ROOTDIR . '/app/resources/views/layouts/backend/head.html';
include ROOTDIR . '/app/resources/views/layouts/backend/nav.html';
include ROOTDIR . '/app/resources/views/layouts/backend/sidebar.html';
?>

    <main role="main" class="ml-sm-auto col-9 pt-3 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Рабочий стол</h1>
        </div>

        <?php if($countCampaign): ?>

            <?php include ROOTDIR . '/app/resources/views/layouts/frontend/error.php'; ?>


            <div class="row">

                <div class="col-12">
                    <div class="card text-center">
                        <div class="card-header">Кампании</div>
                        <div class="card-body">
                            <h5 class="card-title">Ваши кампании: <?php echo $countCamp; ?></h5>
                            <a href="http://price.loc/cabinet/campaign/add" class="btn btn-success"><i class="far fa-plus-square"></i> Создать Новую кампанию</a>
                        </div>
                    </div>
                </div>


        <?php else: ?>

            <div class="card text-center">
                <div class="card-header">

                </div>
                <div class="card-body">
                    <h5 class="card-title">У вас нет Кампаний!</h5>
                    <p class="card-text">Для начала работы с сервисом вам необходимо создать Кампанию</p>
                    <a href="http://price.loc/cabinet/campaign/add" class="btn btn-success"><i class="far fa-plus-square"></i> Создать Кампанию</a>
                </div>
                <div class="card-footer text-muted">
                </div>
            </div>

        <?php endif; ?>


    </main>

<?php
include ROOTDIR . '/app/resources/views/layouts/backend/footer.html';
?>