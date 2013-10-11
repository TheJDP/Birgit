/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var currentEntries;
var currentPage;
var orderColumn;
var orderDirection;

function entriesInit()
{
    currentPage = 0;
    orderColumn = "title";
    orderDirection = "ASC";
      
    $("#newentry").click(function(){
        openEntry(null);
    });
    $("#searchtext").on("input", function(){
        currentPage = 0;
        onInput();
    });
    $("#entrycount").on("change", function(){
        currentPage = 0;
        onInput();
    });
    $("#ordertitle").click(function(){
        setDefaultSortIcons();
        if(orderColumn === "title" && orderDirection === "ASC")
        {
            $("#ordertitle").prop("src", "images/sortupdark.png");
            orderBy("title", "DESC");
        }
        else
        {
            $("#ordertitle").prop("src", "images/sortdowndark.png");
            orderBy("title", "ASC");
        }
    });
    $("#orderusername").click(function(){
        setDefaultSortIcons();
        if(orderColumn === "username" && orderDirection === "ASC")
        {
            $("#orderusername").prop("src", "images/sortupdark.png");
            orderBy("username", "DESC");
        }
        else
        {
            $("#orderusername").prop("src", "images/sortdowndark.png");
            orderBy("username", "ASC");
        }
    });
    $("#orderupdated").click(function(){
        setDefaultSortIcons();
        if(orderColumn === "updated" && orderDirection === "ASC")
        {
            $("#orderupdated").prop("src", "images/sortupdark.png");
            orderBy("updated", "DESC");
        }
        else
        {
            $("#orderupdated").prop("src", "images/sortdowndark.png");
            orderBy("updated", "ASC");
        }
    });
    onInput();
}

function orderBy(column, direction)
{
    orderColumn = column;
    orderDirection = direction;
    onInput();
}

function setDefaultSortIcons()
{
    $("#ordertitle").prop("src", "images/sortdownlight.png");
    $("#orderusername").prop("src", "images/sortdownlight.png");
    $("#orderupdated").prop("src", "images/sortdownlight.png");
}

function openEntry (entry)
{
    if(entry === null)
    {
        window.location = "entry.php";
    }
    else
    {
        window.location = "entry.php?id=" + entry.id;
    }
}

function editEntry (id)
{
    openEntry(currentEntries[id]);
}

function deleteEntry (id)
{
    $.ajax({
        type: "POST",
        url: "api/deleteentry.php",
        data: {
            hash: localStorage.hash, 
            id: currentEntries[id]["id"]
        },
        dataType:"json",
        success: function(response)
        {
            if(response["success"] === true)
            {
                onInput();
            }
            else
            {
                alert(response["message"]);
            }
        },
        error: function()
        {
            alert("Der Eintrag wurde nicht entfernt. Die API konnte nicht erreicht werden.");
        }
    });
}

function copyPassword (id)
{
}

function openUrl (id)
{
    var win=window.open(currentEntries[id]["url"], '_blank');
}

function onInput (){
    fetchData($("#searchtext").val(), $("#entrycount").val(), currentPage, function(result){
        if(result["success"] === true)
        {
            processPayload(result["payload"]);
        }
        else
        {
            alert(result["message"]);
        }
    });
}

function fetchData(searchText, count, page, callback)
{
    $.ajax({
        type: "POST",
        url: "api/selectentries.php",
        data: {
            hash: localStorage.hash, 
            searchtext: searchText, 
            count: count, 
            page: page, 
            ordercolumn: orderColumn, 
            orderdirection: orderDirection
        },
        dataType:"json",
        success: function(response)
        {
            callback({
                success: response["success"],
                message: response["message"],
                payload: response["payload"]
            });
        },
        error: function()
        {
            callback({
                success: false,
                message: unescape("Es konnten keine Einträge abgerufen werden. Die API ist nicht erreichbar!")
            });
        }
    });
}

function processPayload(payload)
{
    processEntryPayload(payload["entries"]);
    processCountPayload(payload["count"]);
}

function processEntryPayload(entries)
{
    $(".entry").remove();
    currentEntries = entries;
    
    if(entries.length === 0)
    {
        $("#noentries").css("display", "table-row");
    }
    else
    {
        $("#noentries").css("display", "none");
        for(var i=0; i<entries.length; i++)
        {
            var row = $('<tr id="entry_' + i + '" class="entry"></tr>');
            row.append('<td class="title" onclick="editEntry(' + i + ');">' + (entries[i]["title"] === null ? "" : entries[i]["title"]) + '</td>');
            row.append('<td class="username" onclick="editEntry(' + i + ');">' + (entries[i]["username"] === null ? "" : entries[i]["username"]) + '</td>');
            row.append('<td class="updated" onclick="editEntry(' + i + ');">' + (entries[i]["updated"] === null ? "" : entries[i]["updated"]) + '</td>');
            row.append('<td class="actions"><a href="javascript:deleteEntry(' + i + ')"><img src="images/delete.png"></img></a><!--<a href="javascript:copyPassword(' + i + ')"><img src="images/key.png"></img></a>-->' + ( currentEntries[i]["url"] != null ? '<a href="javascript:openUrl(' + i + ')"><img class="last" src="images/link.png"></img></a>' : '') + '</td>');
            $("#entrytable").append(row);
        }
    }
}

function processCountPayload(count)
{
    var paginatorcontent = $('<p>' + (currentPage == 0 ? "" : '<a href="javascript:setPage(currentPage - 1);">Zurück</a> | ') + (count == 0 ? 0 : ($("#entrycount").val() * currentPage + 1)) + ' bis ' + ($("#entrycount").val() * currentPage + currentEntries.length) + ' von ' + count + (($("#entrycount").val() * currentPage + currentEntries.length) >= count  ? "" : ' | <a href="javascript:setPage(currentPage + 1);">Weiter</a>') + '</p>');
    $("#paginator").html(paginatorcontent);
}

function setPage (page)
{
    currentPage = page;
    onInput();
}
