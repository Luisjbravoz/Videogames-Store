<?php
/*
 * PROJECT: VIDEO GAME STORE.
 * LUIS JOSÉ BRAVO ZÚÑIGA.
 * CONTROLLER PLATFORM.
 */

include '../model/Model.php'; 

$result_data = Model::getInstance()->listPlatform();
header("Content-Type: application/json");
echo json_encode($result_data, JSON_FORCE_OBJECT);
?>