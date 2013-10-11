<?php

//*******************************************
//
// DeleteEntry
// 
// Expected POST values:
//  - id; default=""
//  - hash; default=""
//  
// Json Response:
//  - success; boolean
//  - message; string
//  
//*******************************************

require_once 'general.php';
require_once '../libraries/Database.class.php';
$response = array();
if (isset($_POST["hash"]) && isset($_POST["id"])) {
    $database = new Database();
    $database->connect();
    $escapedHash = $database->escape($_POST["hash"]);
    $escapedId = $database->escape($_POST["id"]);
    $result = $database->query("DELETE entry FROM entry, user WHERE user.hash='" . $escapedHash . "' AND entry.user_id = user.id AND entry.id = " . $escapedId . ";");
    if ($result !== true) {
        $response["success"] = false;
        $response["message"] = "Fehler beim löschen des Eintrages. Bitte später erneut versuchen.";
    } else {
        $response["success"] = true;
        $response["message"] = "";
    }
    $database->disconnect();
} else {
    $response["success"] = false;
    $response["message"] = "Es wurde kein Eintrag zum löschen angegeben.";
}
echo(json_encode($response));
?>
