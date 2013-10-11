<?php

//*******************************************
//
// SelectEntry
// 
// Expected POST values:
//  - id; default=""
//  - hash; default=""
//  
// Json Response:
//  - success; boolean
//  - message; string
//  - payload; object
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
    $result = $database->query("SELECT entry.id, entry.title, entry.username, entry.url, entry.password, entry.description, entry.updated FROM entry JOIN user ON hash='" . $escapedHash . "' AND entry.user_id = user.id WHERE entry.id = " . $escapedId . ";");
    if ($result === null || $result === false || gettype($result) !== "object") {
        $response["success"] = false;
        $response["message"] = "Fehler beim abrufen des Eintrages. Bitte später erneut versuchen.";
    } else {
        $entries = array();
        while ($resultObject = $result->fetch_object()) {
            array_push($entries, $resultObject);
        }
        if (!empty($entries[0])) {
            $response["success"] = true;
            $response["message"] = "";
            $response["payload"] = array();
            $response["payload"]["entry"] = $entries[0];
        } else {
            $response["success"] = false;
            $response["message"] = "Es wurde kein Eintrag gefunden.";
        }
    }
    $database->disconnect();
} else {
    $response["success"] = false;
    $response["message"] = "Es wurde kein Eintrag abgefragt.";
}
echo(json_encode($response));
?>
