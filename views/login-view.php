<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Авторизация</title>
    <link href="<?php echo VIEWSPATH;?>/bootstrap/css/bootstrap.css" rel="stylesheet" />
    <link href="<?php echo VIEWSPATH;?>/styles/signin.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="<?php echo VIEWSPATH;?>/bootstrap/js/bootstrap.js"></script>
</head>
<body class="body-signin">
<div class="container">
    <form class="form-signin" method="post">
        <div class="form-group" style="position:relative; bottom: -100px">
            <div class="input-group input-group-lg">
                <span class="input-group-addon">
                    <h3 class="icon-signin"><span class="glyphicon glyphicon-fire" aria-hidden="true" style="color: #D9534F"></span></h3>
                </span>
                <input type="password" name="pass" class="form-control" placeholder="Код доступа" required="">
                <span class="input-group-btn">
                    <button class="btn btn-danger" type="submit">Go!</button>
                </span>
            </div>
        </div>
    </form>
</div>
</body>
</html>
