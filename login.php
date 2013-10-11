<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <title>Passtool - Anmelden</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"></meta>
        <link href="css/general.css" rel="stylesheet" type="text/css"></link>
        <link href="css/header.css" rel="stylesheet" type="text/css"></link>
        <link href="css/footer.css" rel="stylesheet" type="text/css"></link>
        <link href="css/login.css" rel="stylesheet" type="text/css"></link>
        <script src="js/jquery-1.10.2.min.js" type="text/javascript"></script>
        <script src="js/sha3.js" type="text/javascript"></script>
        <script src="js/general.js" type="text/javascript"></script>
        <script src="js/header.js" type="text/javascript"></script>
        <script src="js/login.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                if(!generalInit())
                    return;
                
                headerInit();
                loginInit();
            });
        </script>
    </head>
    <body>
        <?php require_once 'header.php'; ?>
        <div id="wrapper">
            <div id="loginmask">
                <div id="formwrapper">
                    <input id="username" type="text" placeholder="Benutzername" autofocus></input>
                    <input id="password" type="password" placeholder="Passwort"></input>
                    <input id="submitform" type="submit" value="Anmelden"></input>
                </div>
                <img id="activityindicator" src="images/activityindicator-1.gif"></img>
            </div>
            <?php require_once 'footer.php'; ?>
        </div>
    </body>
</html>