<?php

$team = new TeamInfo();
$team_name = $team->getTeam('name');
$auth = new Auth();

//обработка ajax запросов
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
    if(isset($_POST['task_id'])) {
        $task_id = (int)$_POST['task_id'];
        $task_info = array();
        $task = new TaskActions();
        $task_info = $task->getTask($task_id);
        echo $task_info;
        exit();
    }
    if(isset($_POST['flag']) && isset($_POST['task'])) {
        $task = new TaskActions();
        $task_title = $_POST['task'];
        $flag = $_POST['flag'];
        echo $task->submitFlag($flag, $task_title);
        exit();
    }
    if(isset($_POST['scoreboard'])) {
        $scoreboard = new Score();
        $score = $scoreboard->getScore();
        require_once VIEWSPATH . '/tasks/tasks-view-score.php';
        exit();
    }
}

//обработка выхода из системы
if (isset($_GET['logout'])) {
    if ($auth->logout())
        header('Refresh: 0; url=./');
}

function getHints()
{
    //load hints
    $hints = HintQuery::create()->find();
    $hint_list["hint"] = array();
    $hint_list["task"] = array();
    foreach ($hints as $hint) {
        $task = TaskQuery::create()
            ->findOneById($hint->getTask_id())
            ->getTitle();
        array_push($hint_list["task"], $task);
        array_push($hint_list["hint"], $hint->getHint());
    }
    return $hint_list;
}

//загрузка шапки
require_once VIEWSPATH . '/tasks/tasks-menu.php';

//обработка переключения между вкладками
if (isset($_GET['tasks'])) {
    $hint_list = array();
    $cat_list = array();
    $category = new Categories();
    $cat_list = $category->getCategories();
    $count_list = $category->countTasks();
    $hint_list = getHints();
    require_once 'views/tasks/tasks-view.php';
} elseif (isset($_GET['score'])) {
    $scoreboard = new Score();
    $score = $scoreboard->getScore();
    require_once VIEWSPATH . '/tasks/tasks-view-score.php';
} else {
    $hint_list = array();
    $cat_list = array();
    $category = new Categories();
    $cat_list = $category->getCategories();
    $count_list = $category->countTasks();
    $hint_list = getHints();
    require_once VIEWSPATH . '/tasks/tasks-view.php';
}

//загрузка футера
require_once VIEWSPATH . '/tasks/tasks-footer.php';