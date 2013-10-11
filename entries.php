<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <title>Passtool - Einträge</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"></meta>
        <link href="css/general.css" rel="stylesheet" type="text/css"></link>
        <link href="css/header.css" rel="stylesheet" type="text/css"></link>
        <link href="css/footer.css" rel="stylesheet" type="text/css"></link>
        <link href="css/entries.css" rel="stylesheet" type="text/css"></link>
        <script src="js/jquery-1.10.2.min.js" type="text/javascript"></script>
        <script src="js/sha3.js" type="text/javascript"></script>
        <script src="js/general.js" type="text/javascript"></script>
        <script src="js/header.js" type="text/javascript"></script>
        <script src="js/entries.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                if(!generalInit())
                    return;
                
                headerInit();
                entriesInit();
            });
        </script>
    </head>
    <body>
        <?php require_once 'header.php'; ?>
        <div id="wrapper">
            <div id="listmask">
                <div id="tableoptions">
                    <input id="newentry" type="submit" value="Neuer Eintrag"></input>
                    <div id="filter">
                        <input id="searchtext" type="text" placeholder="Suchtext" autofocus></input>
                    </div>
                    <select id="entrycount">
                        <option value="10">10 Einträge</option>
                        <option value="20">20 Einträge</option>
                        <option value="30">30 Einträge</option>
                        <option value="40">40 Einträge</option>
                        <option value="50">50 Einträge</option>
                        <option value="60">60 Einträge</option>
                        <option value="70">70 Einträge</option>
                        <option value="80">80 Einträge</option>
                        <option value="90">90 Einträge</option>
                        <option value="100">100 Einträge</option>
                    </select>
                </div>
                <table id="entrytable">
                    <thead
                        <tr>
                            <td width="34%">Titel <img id="ordertitle" src="images/sortdowndark.png"></img></td>
                            <td width="40%">Nutzername <img id="orderusername" src="images/sortdownlight.png"></img></td>
                            <td width="18%">Aktualisiert <img id="orderupdated" src="images/sortdownlight.png"></img></td>
                            <td width="8%"></td>
                        </tr>
                    </thead>
                    <tr id="noentries">
                        <td colspan="4">Keine passenden Einträge zur Suche gefunden.</td>
                    </tr>
                </table>
                <div id="paginator">
                </div>
            </div>
            <?php require_once 'footer.php'; ?>
        </div>
    </body>
</html>