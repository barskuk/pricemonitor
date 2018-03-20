<?php
include ROOTDIR . '/app/resources/views/layouts/frontend/head.html';
include ROOTDIR . '/app/resources/views/layouts/frontend/nav.html';
?>

<div class="container">

    <h1>Регистрация</h1>

    <?php include ROOTDIR . '/app/resources/views/layouts/frontend/error.php'; ?>
    <?php
        if ($result == TRUE && $errors == FALSE) {
            echo "<div class='alert alert-success' role='alert'>Вы зарегистрированы!</div>";
        }
    ?>
    <form class="mt-4" action="" method="post">
        <div class="form-group">
            <div class="row">
                <div class="col-2">
                    <label>Имя</label>
                </div>
                <div class="col-10">
                    <input type="text" class="form-control" name="name" placeholder="Введите имя" value="<?php echo $name; ?>">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-2">
                    <label for="exampleInputEmail1">Email</label>
                </div>
                <div class="col-10">
                    <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Введите email" value="<?php echo $email; ?>">
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
                    <input type="password" class="form-control" name="password" placeholder="Пароль"  value="<?php echo $password; ?>">
                </div>
            </div>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Регистрация</button>
    </form>
</div>


<?php
include ROOTDIR . '/app/resources/views/layouts/frontend/footer.html';
?>