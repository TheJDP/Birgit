<?php

//*******************************************
//
// UpdateEntry
// 
// Expected POST values:
//  - id; required
//  - title; default=null
//  - username; default=null
//  - password; default=null
//  - url; default=null
//  - description; default=null
//  
// Json Response:
//  - success; boolean
//  - message; string
//  
//*******************************************

require_once 'general.php';
require_once '../libraries/Database.class.php';

function getValue($value) {
    if ($value === "") {
        return "NULL";
    } else {
        return "'" . $value . "'";
    }
}

$response = array();
if (isset($_POST["id"])) {
    if (!isset($_POST["title"])) {
        $_POST["title"] = null;
    }
    if (!isset($_POST["username"])) {
        $_POST["username"] = null;
    }
    if (!isset($_POST["password"])) {
        $_POST["password"] = null;
    }
    if (!isset($_POST["url"])) {
        $_POST["url"] = null;
    }
    if (!isset($_POST["description"])) {
        $_POST["description"] = null;
    }
    if (!isset($_POST["hash"])) {
        $_POST["hash"] = null;
    }
    if (!($_POST["hash"] === null && $_POST["title"] === null && $_POST["username"] === null && $_POST["password"] === null && $_POST["url"] === null && $_POST["description"] === null)) {
        $database = new Database();
        $database->connect();
        $escapedId = $database->escape($_POST["id"]);
        $escapedTitle = $database->escape($_POST["title"]);
        $escapedUsername = $database->escape($_POST["username"]);
        $escapedPassword = $database->escape($_POST["password"]);
        $escapedUrl = $database->escape($_POST["url"]);
        $escapedDescription = $database->escape($_POST["description"]);
        $escapedHash = $database->escape($_POST["hash"]);
        $result = $database->query("SELECT * FROM user WHERE hash='" . $escapedHash . "';");
        if ($result === null || $result === false || gettype($result) !== "object") {
            $response["success"] = false;
            $response["message"] = "Fehler beim abrufen des Benutzers. Bitte später erneut versuchen.";
        } else if ($result->num_rows === 1) {
            $result = $database->query("UPDATE entry SET title=" . getValue($escapedTitle) . ", username=" . getValue($escapedUsername) . ", password=" . getValue($escapedPassword) . ", url=" . getValue($escapedUrl) . ", description=" . getValue($escapedDescription) . ", updated=CURRENT_TIMESTAMP  WHERE id=" . $escapedId . ";");
            if ($result !== true) {
                $response["success"] = false;
                $response["message"] = "Fehler beim aktualisieren des Eintrags. Bitte später erneut versuchen.";
            } else {
                $response["success"] = true;
                $response["message"] = "";
            }
        } else {
            $response["success"] = false;
            $response["message"] = "Ungültige Benutzerinformationen. Bitte erneut einloggen.";
        }
        $database->disconnect();
    } else {
        $response["success"] = false;
        $response["message"] = "Es wurden keine Daten für einen Eintrag gesendet.";
    }
} else {
    $response["success"] = false;
    $response["message"] = "Es wurden kein Eintrag angegeben der aktualisiert werden soll.";
}
echo(json_encode($response));
?>
