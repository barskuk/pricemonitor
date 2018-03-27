<?php
include ROOTDIR . '/app/resources/views/layouts/system/head.html';
include ROOTDIR . '/app/resources/views/layouts/system/topbar.html';
include ROOTDIR . '/app/resources/views/layouts/system/sidebar.html';
?>
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Рабочий стол</h4>
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="#">Minton</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-6 col-xl-3">
        <div class="widget-bg-color-icon card-box d-flex">
            <div class="bg-icon bg-icon-success mr-auto p-2">
                <i class="fal fa-users text-white fa-2x mt-2"></i>
            </div>
            <div class="p-2">
                    <h3 class="text-dark m-t-10"><b class="counter"><?php echo $countCustomers; ?></b></h3>
                    <p class="text-muted mb-0">Клиентов</p>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-xl-3">
        <div class="widget-bg-color-icon card-box fadeInDown animated d-flex">
            <div class="bg-icon bg-icon-primary mr-auto p-2">
                <i class="fal fa-database text-white fa-2x mt-2"></i>
            </div>
            <div class="p-2">
                <h3 class="text-dark m-t-10"><b class="counter"><?php echo $countCampaigns; ?></b></h3>
                <p class="text-muted mb-0">Кампаний</p>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-xl-3">
        <div class="widget-bg-color-icon card-box d-flex">
            <div class="bg-icon bg-icon-danger mr-auto p-2">
                <i class="fal fa-sitemap text-white fa-2x mt-2"></i>
            </div>
            <div class="p-2">
                <h3 class="text-dark m-t-10"><b class="counter"><?php echo $countProducts; ?></b></h3>
                <p class="text-muted mb-0">Товаров</p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="col-lg-6 col-xl-3">
        <div class="widget-bg-color-icon card-box d-flex">
            <div class="bg-icon bg-icon-purple  mr-auto p-2">
                <i class="fal fa-chart-line text-white fa-2x mt-2"></i>
            </div>
            <div class="p-2">
                <h3 class="text-dark m-t-10"><b class="counter"><?php echo $countPrices; ?></b></h3>
                <p class="text-muted mb-0">Цены</p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- end row -->


<div class="row">
    <div class="col-lg-7">
        <div class="card-box">
            <h4 class="text-dark  header-title m-t-0 m-b-30">Total Revenue</h4>

            <div class="widget-chart text-center">
                <div id="dashboard-chart-1" style="height: 300px;"></div>

            </div>
        </div>

    </div>

    <div class="col-lg-5">
        <div class="card-box">
            <h4 class="text-dark  header-title m-t-0 m-b-30">Yearly Sales Report</h4>

            <div class="widget-chart text-center">
                <div id="morris-donut-example" style="height: 300px;"></div>

            </div>
        </div>

    </div>

</div>
<!-- end row -->



<div class="row">
    <div class="col-lg-8">
        <div class="card-box">
            <h4 class="text-dark  header-title m-t-0">Latest Projects</h4>
            <p class="text-muted m-b-25 font-13">
                Your awesome text goes here.
            </p>

            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Project Name</th>
                        <th>Start Date</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Assign</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>Minton Admin v1</td>
                        <td>01/01/2017</td>
                        <td>26/04/2017</td>
                        <td><span class="badge badge-info">Released</span></td>
                        <td>Coderthemes</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Minton Frontend v1</td>
                        <td>01/01/2017</td>
                        <td>26/04/2017</td>
                        <td><span class="badge badge-success">Released</span></td>
                        <td>Minton admin</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Minton Admin v1.1</td>
                        <td>01/05/2017</td>
                        <td>10/05/2017</td>
                        <td><span class="badge badge-pink">Pending</span></td>
                        <td>Coderthemes</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Minton Frontend v1.1</td>
                        <td>01/01/2017</td>
                        <td>31/05/2017</td>
                        <td><span class="badge badge-purple">Work in Progress</span>
                        </td>
                        <td>Minton admin</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Minton Admin v1.3</td>
                        <td>01/01/2017</td>
                        <td>31/05/2017</td>
                        <td><span class="badge badge-warning">Coming soon</span></td>
                        <td>Coderthemes</td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- end col -8 -->

    <div class="col-lg-4">
        <div class="card-box widget-user">
            <div>
                <img src="assets/images/users/avatar-1.jpg" class="img-responsive rounded-circle" alt="user">
                <div class="wid-u-info">
                    <h5 class="mt-0 m-b-5 font-16">Chadengle</h5>
                    <p class="text-muted m-b-5 font-13">coderthemes@gmail.com</p>
                    <small class="text-warning"><b>Admin</b></small>
                </div>
            </div>
        </div>

        <div class="card-box widget-user">
            <div>
                <img src="assets/images/users/avatar-2.jpg" class="img-responsive rounded-circle" alt="user">
                <div class="wid-u-info">
                    <h5 class="mt-0 m-b-5 font-16">Tomaslau</h5>
                    <p class="text-muted m-b-5 font-13">coderthemes@gmail.com</p>
                    <small class="text-success"><b>User</b></small>
                </div>
            </div>
        </div>

        <div class="card-box widget-user">
            <div>
                <img src="assets/images/users/avatar-7.jpg" class="img-responsive rounded-circle" alt="user">
                <div class="wid-u-info">
                    <h5 class="mt-0 m-b-5 font-16">Ok</h5>
                    <p class="text-muted m-b-5 font-13">coderthemes@gmail.com</p>
                    <small class="text-pink"><b>Admin</b></small>
                </div>
            </div>
        </div>

    </div>

<?php
include ROOTDIR . '/app/resources/views/layouts/system/footer.html';
?>