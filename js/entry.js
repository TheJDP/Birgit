var insertentry;

function entryInit(get)
{
    insertentry = true;
    if(get['id'] !== undefined)
    {
        insertentry = false;
        selectEntry(get['id']);
    }
    
    registerEvents();
}

function registerEvents()
{
    $("#generate").click(generatePassword);
    $("#abort").click(function(){
        //window.location = "entries.php";
        history.back();
    });
    if(insertentry)
    {
        $("#save").click(insertEntry);
        $("#password").prop("type", "text");
    }
    else
    {
        $("#save").click(updateEntry);
        $("#password").focus(focusPassword);
    }
}

function focusPassword(){
    $("#password").unbind("focus", focusPassword);
    $("#password").prop("type", "text");
}

function selectEntry(id)
{
    $.ajax(
    {
        type: "POST",
        url: "api/selectentry.php",
        data: {
            hash: localStorage.hash,
            id: id
        },
        dataType:"json",
        success: function(response)
        {
            processSelectResponse(response);
        },
        error: function()
        {
            processSelectResponse({
                success: false,
                message: "Der Eintrag konnte nicht geladen werden. Die API ist nicht erreichbar!"
            });
        }
    });
}

function insertEntry(callback)
{
    $.ajax(
    {
        type: "POST",
        url: "api/insertentry.php",
        data: {
            hash: localStorage.hash,
            title: $("#title").val(),
            username: $("#username").val(),
            password: encryptPassword($("#password").val()),
            url: $("#url").val(),
            description: $("#description").val()
        },
        dataType:"json",
        success: function(response)
        {
            processInsertUpdateResponse(response);
        },
        error: function()
        {
            processInsertUpdateResponse({
                success: false,
                message: unescape("Der Eintrag konnte nicht erstellt werden. Die API ist nicht erreichbar!")
            });
        }
    });
}

function updateEntry()
{
    $.ajax(
    {
        type: "POST",
        url: "api/updateentry.php",
        data: {
            id: $("#id").val(),
            hash: localStorage.hash,
            title: $("#title").val(),
            username: $("#username").val(),
            password: encryptPassword($("#password").val()),
            url: $("#url").val(),
            description: $("#description").val()
        },
        dataType:"json",
        success: function(response)
        {
            processInsertUpdateResponse(response);
        },
        error: function()
        {
            processInsertUpdateResponse({
                success: false,
                message: unescape("Der Eintrag konnte nicht aktualisiert werden. Die API ist nicht erreichbar!")
            });
        }
    });
}

function processInsertUpdateResponse(response)
{
    if(response["success"] === true)
    {
        //window.location = "entries.php";
        history.back();
    }
    else
    {
        alert(response["message"]);
    }
}

function processSelectResponse(response)
{
    if(response["success"] === true)
    {
        $("#id").val(response["payload"]["entry"]["id"]);
        $("#title").val(response["payload"]["entry"]["title"]);
        $("#username").val(response["payload"]["entry"]["username"]);
        $("#password").val(decryptPassword(response["payload"]["entry"]["password"]));
        $("#url").val(response["payload"]["entry"]["url"]);
        $("#description").val(response["payload"]["entry"]["description"]);
    }
    else
    {
        alert(response["message"]);
    }
}

function generatePassword()
{
    var normalcharsuppercase = $("#normalcharsuppercase").prop('checked');
    var normalcharslowercase = $("#normalcharslowercase").prop('checked');
    var numbers = $("#numbers").prop('checked');
    var specialchars = $("#specialchars").prop('checked');
    var count = $("#count").val();
    
    var normalcharsuppercaseSet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    var normalcharlowercaseSet = "abcdefghijklmnopqrstuvwxyz";
    var numbersSet = "0123456789";
    var specialcharsSet = '!"§$%&/()=?.,-_';
    
    var setPackage = {};
    var setPackageCount = 0;
    if(normalcharsuppercase)
    {
        setPackage[setPackageCount] = normalcharsuppercaseSet;
        setPackageCount++;
    }
    if(normalcharslowercase)
    {
        setPackage[setPackageCount] = normalcharlowercaseSet;
        setPackageCount++;
    }
    if(numbers)
    {
        setPackage[setPackageCount] = numbersSet;
        setPackageCount++;
    }
    if(specialchars)
    {
        setPackage[setPackageCount] = specialcharsSet;
        setPackageCount++;
    }
    
    if(setPackageCount === 0)
    {
        return;
    }
    
    var password = "";
    
    for(var i=0; i<count; i++)
    {
        var selectedSet = parseInt(Math.random() * setPackageCount);
        var position = parseInt((Math.random() * (setPackage[selectedSet].length - 1)));
        
        password += setPackage[selectedSet][position];
    }
    
    $("#password").prop("type", "text");
    $("#password").val(password);
}

function encryptPassword(data)
{
    var encrypted = Aes.Ctr.encrypt(data, localStorage.password, 256);
    return encrypted;
}

function decryptPassword(data)
{
    var decrypted = Aes.Ctr.decrypt(data, localStorage.password, 256);
    return decrypted;
}
