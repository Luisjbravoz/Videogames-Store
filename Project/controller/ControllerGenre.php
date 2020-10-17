<?php
/*
 * PROJECT: VIDEO GAME STORE.
 * LUIS JOSÉ BRAVO ZÚÑIGA.
 * CONTROLLER GENRE.
 */

include '../model/Model.php'; 

$result_data = Model::getInstance()->listGenre();
header("Content-Type: application/json");
echo json_encode($result_data, JSON_FORCE_OBJECT);
?>