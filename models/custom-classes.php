<?php

require_once 'vendor/autoload.php';
require_once 'generated-conf/config.php';

//класс для методов, связанных с авторизацией
class Auth
{
    public function __construct()
    {

    }

    //метод - авторизация
    public function auth($pass)
    {
        //получаем двойной sha1-хеш от введенного пароля
        $hash_pass = sha1(sha1($pass));
        //ищем в базе юзера с таким хешем пароля
        $user = ParticipantsQuery::create()->findOneByPass($hash_pass);
        //если такой хеш имеется
        if ($user) {
            //получаем ip юзера из базы
            //$user_ip = $user->getIp();
            //если поле пустое (первая авторизация)
            /*if ($user_ip == "") {
                //то берем ip юзера и сохраняем в базу
                $user->setIp($_SERVER['REMOTE_ADDR']);
                $user->save();
                $user_ip = $_SERVER['REMOTE_ADDR'];
            }*/
            //если ip юзера из базы совпадает с ip клиента
            //if ($user_ip == $_SERVER['REMOTE_ADDR']) {
                //генерируем секретную последовательность и сохраняем в базу
                $secret_key = uniqid();
                $user->setSecretkey($secret_key);
                $user->save();
                //получаем порядковый номер юзера
                $id_user = $user->getId_pass();
                //ставим куку
                setcookie("session_id", sha1($secret_key) . "/" . $id_user);
                return true;
            //}
            //если ip не совпадают
            /*if ($user_ip != $_SERVER['REMOTE_ADDR']) {
                echo "Вы пытаетесь войти с другого IP-адреса";
                return false;
            }*/
        } else {
            echo "Вы ввели неправильный код доступа";
            return false;
        }
    }

    //метод - проверка авторизации
    public function checkAuth()
    {
        //разбиваем значение куки на составляющие
        $data_array = explode("/", $_COOKIE["session_id"]);
        //ищем юзера по его порядковому номеру
        $count_user = ParticipantsQuery::create()->findOneById_pass($data_array[1]);
        //если он есть
        if ($count_user) {
            //получаем его секретную последовательность из базы
            $secret_key = ParticipantsQuery::create()
                ->findOneById_pass($data_array[1])
                ->getSecretkey();
            //генерируем хеш из этой секретной последовательности и текущего ip адреса
            $evaluate_hash = sha1($secret_key);
            $cookies_hash = $data_array[0];
            //если совпадает, то успех
            return $evaluate_hash === $cookies_hash ? true : false;
        } else {
            return false;
        }
    }

    //метод - выход
    public function logout()
    {
        return setcookie("session_id", "", time() - 3600) ? true : false;
    }
}

//класс для методов, связанных с действиями по таскам
class TaskActions
{

    public function __construct()
    {

    }

    //метод - вывод информации по всем таскам
    public function getAllTasks() {
        $task_info = array();
        $tasks = TaskQuery::create()->find();
        $i = 0;
        foreach($tasks as $task) {
            $task_points = $task->getPoints();
            $task_cat_id = $task->getCategoryId();
            $task_id = $task->getId();
            //если таск не за 100
            $open_new = false;
            if($task_points > 100 && $task_points <= 500) {
                //берем таск из данной категории, но на 100 меньше
                $left_task_points = $task_points - 100;
                $left_task_id = TaskQuery::create()
                    ->filterByCategoryId($task_cat_id)
                    ->findOneByPoints($left_task_points)
                    ->getId();
                //ищем решения данного таска в статистике
                $statistic = StatisticQuery::create()
                    ->findByTaskId($left_task_id);
                foreach($statistic as $stat) {
                    $flag_done = $stat->getFlagDone();
                    //если этот таск уже был решен, то значит открываем следующий
                    if($flag_done) {
                        $open_new = true;
                        break;
                    }
                }
            }
            if($task_points == 100 || $open_new) {
                $task_title = $task->getTitle();
                $task_descr = $task->getDescription();
                //проверяем, решен таск или нет
                //получаем id команды
                $team = new TeamInfo();
                $team_id = $team->getTeam('id');
                $completed = $this->checkTask($task_id, $team_id);
                $task_info[$i] = array('title' => $task_title, 'description' => $task_descr, 'points' => $task_points, 'id' => $task_id, 'cat_id' => $task_cat_id, 'completed' => $completed);
                $i++;
            }
        }
        return $task_info;
    }

    //метод - вывод информации по таскам заданной категории
    public function getTasksInfo($category)
    {
        //получаем id категории по названию
        $category_id = CategoryQuery::create()
            ->findOneByTitle($category)
            ->getId();
        $task_info = array();
        //ищем все таски по заданной категории (!добавить лимит, чтобы видны были не все)
        $tasks = TaskQuery::create()
            ->findByCategoryId($category_id);
        //формируем массив тасков
        $i = 0;
        foreach ($tasks as $task) {
            $task_points = $task->getPoints();
            $task_title = $task->getTitle();
            $task_descr = $task->getDescription();
            $task_id = $task->getId();
            //если таск не за 100
            $open_new = false;
            if($task_points > 100 && $task_points <= 500) {
                //берем таск из данной категории, но на 100 меньше
                $left_task_points = $task_points - 100;
                $left_task_id = TaskQuery::create()
                    ->filterByCategoryId($category_id)
                    ->findOneByPoints($left_task_points)
                    ->getId();
                //ищем решения данного таска в статистике
                $statistic = StatisticQuery::create()
                    ->findByTaskId($left_task_id);
                foreach($statistic as $stat) {
                    $flag_done = $stat->getFlagDone();
                    //если этот таск уже был решен, то значит открываем следующий
                    if($flag_done) {
                        $open_new = true;
                        break;
                    }
                }
            }
            if($task_points == 100 || $open_new) {
                $task_title = $task->getTitle();
                $task_descr = $task->getDescription();
                //проверяем, решен таск или нет
                //получаем id команды
                $team = new TeamInfo();
                $team_id = $team->getTeam('id');
                $completed = $this->checkTask($task_id, $team_id);
                $task_info[$i] = array('title' => $task_title, 'description' => $task_descr, 'points' => $task_points, 'id' => $task_id, 'cat_id' => $category_id, 'completed' => $completed);
                $i++;
            }
        }
        return $task_info;
    }

    //метод - вывод информации по отдельному таску
    public function getTask($task_id) {
        $task_info = false;
        $tasks = TaskQuery::create()
            ->findOneById($task_id);
        if($tasks) {
            $task_id = $tasks->getId();
            $task_points = $tasks->getPoints();
            $task_title = $tasks->getTitle();
            $task_descr = $tasks->getDescription();
            //проверяем, решен таск или нет
            //получаем id команды
            $team = new TeamInfo();
            $team_id = $team->getTeam('id');
            $completed = $this->checkTask($task_id, $team_id);
            $task_info = array('title' => $task_title, 'description' => $task_descr, 'points' => $task_points, 'completed' => $completed);
            $task_info = json_encode($task_info);
        }
        return $task_info;
    }

    //метод - выводим количество команд, решивших таск
    public function countSolves($task)
    {
        $count = 0;
        $stat_tasks = StatisticQuery::create()
            ->findByTaskId($task);
        foreach ($stat_tasks as $stat_task) {
            if ($stat_task->getFlagDone()) {
                $count++;
            }
        }
        return $count;
    }

    //метод - решен таск командой или нет
    public function checkTask($task_id, $team_id)
    {
        //ищем, есть ли данная команда с данным таском в статистике
        $statistic = new Statistics();
        $statistic_entry = $statistic->findStatistic($team_id, $task_id);
        //если записей в статистике по данному таску нет
        if($statistic_entry == null) {
            //значит флаг отправили первый раз - создаем запись в статистике
            $new_statistic = new Statistic();
            $new_statistic->setTeamId($team_id);
            $new_statistic->setTaskId($task_id);
            $new_statistic->setFlagDone(false);
            $new_statistic->save();
            $flag_done = false;
        }
        else {
            //если статистика по данному таску фиксировалась для команды
            //то сразу берем значение решен/нерешен
            $flag_done = $statistic_entry->getFlagDone();
        }
        return $flag_done;
    }

    //метод - отправка флага на проверку
    public function submitFlag($flag, $task_title)
    {
        //берем id таска по его названию
        $task_id = TaskQuery::create()
            ->findOneByTitle($task_title)
            ->getId();
        //получаем id команды
        $team = new TeamInfo();
        $team_id = $team->getTeam('id');
        //если таск еще нерешен командой
        if(!$this->checkTask($task_id, $team_id)) {
            //сравниваем флаги и записываем результат (решен или нет)
            $task_flag = TaskQuery::create()
                ->findOneById($task_id)
                ->getFlag();
            $result = (strtolower($flag) === strtolower($task_flag));
            //заносим изменения в статистику
            $statistic = new Statistics();
            $statistic_entry = $statistic->findStatistic($team_id, $task_id);
            //заносим в базу текущий ответ
            $attempt = new Attempt();
            $attempt->setStatistic_id($statistic_entry->getId());
            $attempt->setAnswer($flag);
            $attempt->save();
            //если ответ правильный
            if ($result) {
                //устанавливаем, что таск решен
                $flag_done = true;
                //ставим время решения таска
                $time_done = date("H:i:s");
                $statistic_entry->setFlagDone($flag_done);
                $statistic_entry->setTimeDone($time_done);
                $statistic_entry->save();
                $message = 'success';
            }
            else {
                $message = 'error_flag';
            }
        }
        else {
            $message = 'task_completed';
        }
        return $message;
    }
}

//класс для получения информации о команде
class TeamInfo
{

    public function __construct()
    {

    }

    //метод - получение информации по команде
    public function getTeam($param)
    {
        $cookie_value = $_COOKIE['session_id'];
        $id_pass = explode("/", $cookie_value)[1];
        $id_team = ParticipantsQuery::create()
            ->findOneById_pass($id_pass)
            ->getTeam_id();
        $team = TeamQuery::create()->findOneById($id_team);
        switch ($param) {
            case 'id':
                return $team->getId();
                break;
            case 'name':
                return $team->getName();
                break;
            case 'email':
                return $team->getName();
                break;
            case 'logo':
                return $team->getLogoLink();
                break;
            case 'city':
                return $team->getCity();
                break;
            case 'institution':
                return $team->getInstitution();
                break;
            case 'info':
                return $team->getInfo();
                break;
            case 'reg_date':
                return $team->getRegistrDate();
                break;
        }
    }
}

//класс для работы со скорбордом
class Score
{

    public function __construct()
    {

    }

    //метод - получение скорборда по всем командам
    public function getScore()
    {
        $list_score = array();
        $teams = TeamQuery::create()->find();
        foreach($teams as $team) {
            $team_time = array();
            $team_time_obj = array();
            $team_result = 0;
            $team_id = $team->getId();
            if($team_id != 22) {
                $team_logo = $team->getLogoLink();
                $team_name = $team->getName();
                $team_location = $team->getInstitution() . " (" . $team->getCity() .")";
                $points = StatisticQuery::create()
                    ->findByTeamId($team_id);
                $i = 0;
                foreach($points as $score) {
                    if($score->getFlagDone()) {
                        $task_points = TaskQuery::create()
                            ->findOneById($score->getTaskId())
                            ->getPoints();
                        $team_result += (int)$task_points;
                        $team_time_obj[$i] = (array)$score->getTimeDone();
                        $team_time[$i] = explode(" ", $team_time_obj[$i]['date']);
                        $team_time[$i] = $team_time[$i][1];
                        $i++;
                    }
                }
                $max_team_time = count($team_time) > 0 ? max($team_time) : '00:00:00';
                $list_score[] = array('logo' => $team_logo, 'name' => $team_name, 'location' => $team_location, 'result' => $team_result, 'time_done' => strtotime($max_team_time));
            }
        }
        //сортируем по результату
        usort($list_score, function($v1, $v2) {
            if (($v1["result"] == $v2["result"]) && $v1["result"] != 0) {
                if ($v1["time_done"] > $v2["time_done"]) {
                    return 1;
                    }
                else {
                    return -1;
                }
            }
            return ($v1["result"] < $v2["result"]) ? 1: -1;
        });
        return $list_score;
    }
}

//класс для работы с категориями
class Categories
{

    public function __construct()
    {

    }

    //метод - получение списка категорий
    public function getCategories()
    {
        //получаем список всех категорий
        $categories = CategoryQuery::create()->find();
        $cat_list = array();
        foreach ($categories as $category) {
            //получаем название каждой категории и сохраняем в массив
            array_push($cat_list, $category->getTitle());
        }
        return $cat_list;
    }

    //метод - получение числа тасков в заданной категории
    public function countTasks()
    {
        //получаем список категорий
        $categories = CategoryQuery::create()->find();
        $countTasksList = array();
        //п каждой категории получаем число тасков в ней
        foreach ($categories as $category) {
            $id_cat = $category->getId();
            $countTask = TaskQuery::create()
                ->filterByCategoryId($id_cat)
                ->count();
            array_push($countTasksList, $countTask);
        }
        return $countTasksList;
    }
}

//класс для работы со статистикой
class Statistics
{

    public function __construct()
    {

    }

    //метод - при каждой попытке добавление информации в статистику
    public function addStatistic($team_id, $task_id, $flag_done, $time_done) {
        //фиксируем попытку в статистику

    }

    //метод - поиск статистики по заданной команде и таску
    public function findStatistic($team_id, $task_id) {
        $find_stats = StatisticQuery::create()
            ->filterByTeamId($team_id)
            ->filterByTaskId($task_id)
            ->findOne();
        return $find_stats;
    }

    //метод - добавление каждого ответа команды
    public function writeAnswer($stat_id) {

    }

}