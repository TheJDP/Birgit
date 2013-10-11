function loginInit()
{
    $('#submitform').click(login);
}

function login()
{
    var username = $('#username').val();
    var password = $('#password').val();

    var validateCredentialsResponse = validateCredentials(username, password);

    if(validateCredentialsResponse["success"])
    {
        $('#activityindicator').css("display", "block");
        disableInput();
        
        var hash = CryptoJS.SHA3(username + password, {
            outputLength: 512
        }).toString()
        
        loginRequest(hash, function(loginRequestResponse){
            if(loginRequestResponse["success"])
            {
                localStorage.hash = hash;
                localStorage.username = username;
                localStorage.password = password;
                localStorage.loggedin = true;
                localStorage.expiration = new Date().getTime() + 300000;

                window.location.replace("entries.php");
            }
            else
            {
                alert(loginRequestResponse["message"]);
            }
            $('#activityindicator').css("display", "none");
            enableInput();
        });
    }
    else
    {
        alert(validateCredentialsResponse["message"]);
    }
}

function validateCredentials(username, password)
{
    if(username.length === 0 && password.length === 0)
    {
        return {
            success: false,
            message: unescape("Der Benutzername und das Passwort sind ung%FCltig%21")
        };
    }
    else if(username.length === 0)
    {
        return {
            success: false,
            message: unescape("Der Benutzername ist ung%FCltig%21")
        };
    }
    else if(password.length === 0)
    {
        return {
            success: false,
            message: unescape("Das Passwort ist ung%FCltig%21")
        };
    }
    else
    {
        return {
            success: true,
            message: ""
        };
    }
}

function loginRequest(hash, callback)
{
    $.ajax(
    {
        type: "POST",
        url: "api/login.php",
        data: {
            hash: hash
        },
        dataType:"json",
        success: function(response)
        {
            callback({
                success: response["success"],
                message: response["message"]
            });
        },
        error: function()
        {
            callback({
                success: false,
                message: unescape("Die Anmeldung konnte nicht durchgef%FChrt werden. Die API ist nicht erreichbar!")
            });
        }
    });
}

function disableInput()
{
    $('#submitform').prop('disabled', true);
    $('#username').prop('disabled', true);
    $('#password').prop('disabled', true);
}

function enableInput()
{
    $('#submitform').prop('disabled', false);
    $('#username').prop('disabled', false);
    $('#password').prop('disabled', false);
}
