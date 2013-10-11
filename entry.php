<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd">



<html>
    <head>
        <title>Passtool - Eintrag</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"></meta>
        <link href="css/general.css" rel="stylesheet" type="text/css"></link>
        <link href="css/header.css" rel="stylesheet" type="text/css"></link>
        <link href="css/footer.css" rel="stylesheet" type="text/css"></link>
        <link href="css/entry.css" rel="stylesheet" type="text/css"></link>
        <script src="js/jquery-1.10.2.min.js" type="text/javascript"></script>
        <script src="js/aes.js" type="text/javascript"></script>
        <script src="js/general.js" type="text/javascript"></script>
        <script src="js/header.js" type="text/javascript"></script>
        <script src="js/entry.js" type="text/javascript"></script>
        <script type="text/javascript">
<?php echo("var get = JSON.parse('" . json_encode($_GET) . "');"); ?>
            
                $(document).ready(function() {
                    if(!generalInit())
                        return;
                
                    headerInit();
                    entryInit(get);
                });
        </script>
    </head>
    <body>
        <?php require_once 'header.php'; ?>
        <div id="wrapper">
            <input type="hidden" id="id"></input>
            <input type="text" id="title" placeholder="Titel" autofocus></input>
            <input type="text" id="username" placeholder="Benutzername"></input>
            <input type="password" id="password" placeholder="Passwort"></input>
            <div id="passwordgenerator">
                <label>a:</label>
                <input checked="true" type="checkbox" id="normalcharslowercase"></input>
                <label>A:</label>
                <input checked="true" type="checkbox" id="normalcharsuppercase"></input>
                <label>1:</label>
                <input checked="true" type="checkbox" id="numbers"></input>
                <label>!:</label>
                <input type="checkbox" id="specialchars"></input>
                <input type="number" id="count" value="8"></input>
                <input type="submit" id="generate" value="Generiere"></input>
            </div>
            <input type="text" id="url" placeholder="Url"></input>
            <textarea id="description" placeholder="Beschreibung und oder Keywords"></textarea>
            <div id="actions">
                <input type="submit" id="abort" value="Abbrechen"></input>
                <input type="submit" id="save" value="Sichern"></input>
            </div>
            <?php require_once 'footer.php'; ?>
        </div>
    </body>
</html>