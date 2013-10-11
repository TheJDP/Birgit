/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function headerInit()
{
    if(localStorage.loggedin != undefined && JSON.parse(localStorage.loggedin))
    {
        var logoutButton = $('<input type="submit" id="logout" value="Abmelden"></submit>');
        var username = $('<p class="username">' + localStorage.username + '</p>');
        var expiration = $('<p id="expirationtime"></p>');
        $('#contentheaderright').append(logoutButton);
        $('#contentheaderright').append(username);
        $('#contentheaderright').append(expiration);
        setInterval(refreshExpiration,1000);
        refreshExpiration();
    }
    
    $('#logout').click(function()
    {
        localStorage.clear();
        window.location = 'login.php';
    });
}

function refreshExpiration(){
    if(JSON.parse(localStorage.expiration) < new Date().getTime())
    {
        location.reload();
        return;
    }
    var sekges = ((JSON.parse(localStorage.expiration) - (new Date().getTime())) / 1000).toFixed(0);
    var min = Math.floor(sekges / 60);
    var sek = sekges - (min * 60);
    $('#expirationtime').html(lpad(min, 1)  + ' Min. ' + lpad(sek, 2) + ' Sek.');
}

var lpad = function(value, padding) {
    var zeroes = "0";

    for (var i = 0; i < padding; i++) {
        zeroes += "0";
    }

    return (zeroes + value).slice(padding * -1);
}