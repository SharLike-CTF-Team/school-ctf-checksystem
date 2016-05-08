<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>SharLike Check System</title>
    <link href="<?php echo VIEWSPATH;?>/bootstrap/css/bootstrap.css" rel="stylesheet" />
    <link href="<?php echo VIEWSPATH;?>/styles/tasks.css" rel="stylesheet" />
    <link href="http://webfonts.ru/import/casper.css" rel="stylesheet" >
    <script src="<?php echo VIEWSPATH;?>/js/jquery.js"></script>
    <script src="<?php echo VIEWSPATH;?>/bootstrap/js/bootstrap.js"></script>
    <script src="<?php echo VIEWSPATH;?>/js/tasks.js"></script>
</head>
<body>
    <div class="container-fluid" id="menu-content">
        <div class="row">
            <div class="navbar navbar-default">
                <div class="container">
                    <div class="collapse navbar-collapse" id="menu">
                        <ul class="nav navbar-nav activemenu">
                            <li class="<?php if(!isset($_GET['score'])) echo 'active'?>"><a href="?tasks">Задания</a></li>
                            <li class="<?php if(isset($_GET['score'])) echo 'active'?>"><a href="?score" >Таблица соревнований</a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a><span class="glyphicon glyphicon-user"></span>&nbsp;<?php echo isset($team_name)?$team_name:"";?></a></li>
                            <li><a href="?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Выход</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if(isset($_GET['score'])): ?>
        <script>
            setInterval('$.ajax({ ' +
                'type: "POST",' +
                'data: {scoreboard: 1},' +
                'success: function(data) {' +
                    'console.log(data);' +
                    '$("#ajax-wrap").remove();' +
                    '$("#menu-content").after(data); ' +
                '}' +
            '})', 10000);
        </script>
    <?php endif;?>