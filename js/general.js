function generalInit()
{
    if(localStorage.expiration < new Date().getTime())
    {
        localStorage.hash = "";
        localStorage.username = "";
        localStorage.password = "";
        localStorage.loggedin = false;
    }
    else
    {
        localStorage.expiration = new Date().getTime() + 300000;
    }
    
    if(needCredentials() === true && hasCredentials() === false)
    {
        window.location = 'login.php';
        return false;
    }
    if(needCredentials() === false && hasCredentials() === true)
    {
        window.location = 'entries.php';
        return false;
    }
    
    return true;
}

function needCredentials ()
{
    if(window.location.toString().indexOf('login.php') === -1)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function hasCredentials ()
{
    if(localStorage.loggedin != undefined && JSON.parse(localStorage.loggedin) === true)
    {
        return true;
    }
    else
    {
        return false;
    }
}