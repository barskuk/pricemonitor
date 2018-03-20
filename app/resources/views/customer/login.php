<?php
include ROOTDIR . '/app/resources/views/layouts/frontend/head.html';
include ROOTDIR . '/app/resources/views/layouts/frontend/nav.html';
?>

    <div class="container">

        <h1>Авторизация</h1>

        <?php include ROOTDIR . '/app/resources/views/layouts/frontend/error.php'; ?>
        <form class="mt-4" action="" method="post">
            <div class="form-group">
                <div class="row">
                    <div class="col-2">
                        <label for="exampleInputEmail1">Email</label>
                    </div>
                    <div class="col-10">
                        <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Введите email">
                        <small class="form-text text-muted">Введите ваш email, который будет использоваться для авторизации</small>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-2">
                        <label for="exampleInputPassword1">Пароль</label>
                    </div>
                    <div class="col-10">
                        <input type="password" class="form-control" name="password" placeholder="Пароль">
                    </div>
                </div>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Вход</button>
        </form>
    </div>

<?php
include ROOTDIR . '/app/resources/views/layouts/frontend/footer.html';
?>