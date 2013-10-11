<?php

//*******************************************
//
// Login
// 
// Expected POST values:
//  - hash;
//  
// Json Response:
//  - success; boolean
//  - message; string
//  
//*******************************************

require_once 'general.php';
require_once '../libraries/Database.class.php';
$response = array();
if (isset($_POST["hash"])) {
    $database = new Database();
    $database->connect();
    $escapedHash = $database->escape($_POST["hash"]);
    $result = $database->query("SELECT * FROM user WHERE hash='" . $escapedHash . "';");
    if ($result === null || $result === false || gettype($result) !== "object") {
        $response["success"] = false;
        $response["message"] = "Fehler beim abrufen des Benutzers. Bitte später erneut versuchen.";
    } else if ($result->num_rows === 1) {
        $response["success"] = true;
        $response["message"] = "";
    } else {
        $response["success"] = false;
        $response["message"] = "Ungültige Logindaten.";
    }
    $database->disconnect();
} else {
    $response["success"] = false;
    $response["message"] = "Es wurde kein Benutzer angefragt.";
}
echo(json_encode($response));
?>
