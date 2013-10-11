<?php

//*******************************************
//
// SelectEntries
// 
// Expected POST values:
//  - count; default=10
//  - page; default=0
//  - searchtext; default=""
//  - hash; default=""
//  - ordercolumn; default="title"
//  - orderdirection; default="ASC"
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
if (!isset($_POST["count"])) {
    $_POST["count"] = 10;
}
if (!isset($_POST["page"])) {
    $_POST["page"] = 0;
}
if (!isset($_POST["searchtext"])) {
    $_POST["searchtext"] = "";
}
if (!isset($_POST["ordercolumn"])) {
    $_POST["ordercolumn"] = "title";
} else {
    $_POST["ordercolumn"] = strtolower($_POST["ordercolumn"]);
}
if (!isset($_POST["orderdirection"]) || (strtolower($_POST["orderdirection"]) != "asc" && strtolower($_POST["orderdirection"]) != "desc")) {
    $_POST["orderdirection"] = "ASC";
} else {
    $_POST["orderdirection"] = strtoupper($_POST["orderdirection"]);
}
if (isset($_POST["hash"])) {
    $database = new Database();
    $database->connect();
    $escapedHash = $database->escape($_POST["hash"]);
    $escapedSearchText = $database->escape($_POST["searchtext"]);
    $escapedCount = $database->escape($_POST["count"]);
    $escapedPage = $database->escape($_POST["page"]);
    $escapedOrdercolumn = $database->escape($_POST["ordercolumn"]);
    $escapedOrderdirection = $database->escape($_POST["orderdirection"]);
    $result = $database->query("SELECT entry.id, entry.title, entry.username, entry.url, entry.password, entry.description, entry.updated FROM entry JOIN user ON hash='" . $escapedHash . "' AND entry.user_id = user.id WHERE (entry.title LIKE '%" . $escapedSearchText . "%' OR entry.username LIKE '%" . $escapedSearchText . "%' OR entry.url LIKE '%" . $escapedSearchText . "%' OR entry.description LIKE '%" . $escapedSearchText . "%') ORDER BY " . $escapedOrdercolumn . " " . $escapedOrderdirection . " LIMIT " . $escapedPage * $escapedCount . " , " . $escapedCount . ";");
    if ($result === null || $result === false || gettype($result) !== "object") {
        $response["success"] = false;
        $response["message"] = "Fehler beim abrufen der Einträge. Bitte später erneut versuchen.";
    } else {
        $entries = array();
        while ($resultObject = $result->fetch_object()) {
            array_push($entries, $resultObject);
        }
        $resultOfCount = $database->query("SELECT COUNT(*) as count FROM entry JOIN user ON hash='" . $escapedHash . "' AND entry.user_id = user.id WHERE (entry.title LIKE '%" . $escapedSearchText . "%' OR entry.username LIKE '%" . $escapedSearchText . "%' OR entry.url LIKE '%" . $escapedSearchText . "%' OR entry.description LIKE '%" . $escapedSearchText . "%');");
        $count = 0;
        if (!($result === null || $result === false || gettype($result) !== "object")) {
            $count = $resultOfCount->fetch_object()->count;
        }
        $response["success"] = true;
        $response["message"] = "";
        $response["payload"] = array();
        $response["payload"]["count"] = $count;
        $response["payload"]["entries"] = $entries;
    }
    $database->disconnect();
} else {
    $response["success"] = false;
    $response["message"] = "Es wurde keine Liste eines Benutzers angefragt.";
}
echo(json_encode($response));
?>
