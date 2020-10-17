<?php
/*
 * PROJECT: VIDEO GAME STORE.
 * LUIS JOSÉ BRAVO ZÚÑIGA.
 * CONTROLLER INDEX (LOGIN).
 */

include '../model/Model.php'; 

$form_data = json_decode(file_get_contents("php://input"), true);
$result_data = null;
if(Check::VALIDATE_EMAIL_ADDRESS($form_data["username"]) && Check::VALIDATE_PASSWORD($form_data["password"])) {
    if(Model::getInstance()->check($form_data["username"], $form_data["password"])) {
        session_start();
        Model::getInstance()->setUsername($form_data["username"]);
        $_SESSION["username"] = $form_data["username"];
        $result_data = array("result" => true);
    } else {
        $result_data = array("result" => false);
    }
} else {
    $result_data = array("result" => false);
}
header("Content-Type: application/json");
echo json_encode($result_data, JSON_FORCE_OBJECT);
?>