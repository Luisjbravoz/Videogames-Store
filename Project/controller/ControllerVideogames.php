<?php
/*
 * PROJECT: VIDEO GAME STORE.
 * LUIS JOSÉ BRAVO ZÚÑIGA.
 * CONTROLLER VIDEOGAMES.
 */

include '../model/Model.php'; 

$form_data = json_decode(file_get_contents("php://input"), true);
$result_data = null;

if($form_data["operation"] === "LIST") {
    $result_data = Model::getInstance()->listVideogame();
}
elseif ($form_data["operation"] === "DEL") {
    $result_data = Model::getInstance()->deleteVideogame($form_data["id"]);
}
elseif($form_data["operation"] === "INS") {
    $object = $form_data["object"];
    $result_data = Model::getInstance()->insertVideogame(new Videogame(0, $object["title"], $object["idPlatform"],
                                                         $object["idGenre"], $object["price"], $object["quantity"]));
}
elseif($form_data["operation"] === "UPD") {
    $object = $form_data["object"];
    $result_data = Model::getInstance()->updateVideogame(new Videogame($object["id"], $object["title"], $object["idPlatform"],
                                                         $object["idGenre"], $object["price"], $object["quantity"]));
}
header("Content-Type: application/json");
echo json_encode($result_data, JSON_FORCE_OBJECT);
?>