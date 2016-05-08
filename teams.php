<?php
    header('Access-Control-Allow-Origin: *');
    require_once 'vendor/autoload.php';
    require_once 'generated-conf/config.php';

    $team_list = array();
    $teams = TeamQuery::create()->find();
    foreach($teams as $team) {
        if($team->getId() != 22) {
            $team_list[] = array('id' => $team->getId(), 'name' => $team->getName(), 'email' => $team->getEmail(), 'logo' => $team->getLogoLink(), 'city' => $team->getCity(), 'institution' => $team->getInstitution(), 'info' => $team->getInfo(), 'reg_date' => $team->getRegistrDate());
        }
    }
    echo json_encode($team_list);
?>
