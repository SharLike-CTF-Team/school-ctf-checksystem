<?php

define('VIEWSPATH', 'views');//название папки с шаблонами
define('CONTRPATH', 'controllers');

require_once 'models/custom-classes.php';
require_once 'generated-conf/config.php';

$auth = new Auth();

if(isset($_COOKIE['session_id'])) {
    require_once $auth->checkAuth() ? CONTRPATH.'/tasks.php' : VIEWSPATH.'/login-view.php';
    exit();
}

if(isset($_POST['pass'])) {
    $pass = $_POST['pass'];
    if($auth->auth($pass))
        header('Location: _index.php');
    exit();
}

require_once VIEWSPATH.'/login-view.php';

?>
