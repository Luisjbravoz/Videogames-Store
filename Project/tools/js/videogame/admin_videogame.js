/*
 * PROJECT: PUBLIC LIBRARY.
 * LUIS J. BRAVO ZÚÑIGA.
 * ADMIN_VIDEOGAME JS
 */

/****
 * GLOBAL
 */
var listData = undefined, table = undefined, listGenreTitle = undefined, listPlatformTitle = undefined, videogame = undefined, cont = undefined,
        rowFormat = "<td>{0}</td><td>{1}</td><td>{2}</td><td>{3}</td><td>${4}</td><td>{5}</td><td>{6}</td><td>{7}</td>",
        optFormat = "<option value=\"{0}\">{1}</option>",
        deleteIcon = "<img class='image' src='tools/css/videogame/images/delete.png' onclick='deleteVideogame(\"{0}\");'>",
        updateIcon = "<img class='image' src='tools/css/videogame/images/update.png' onclick='showUpdateModal(\"{0}\");'>";

/****
 * Format a String
 * var username = "admin", password = "abC1";
 * e.g. : "api/login/{0}/{1}".format(username, password);
 * output: api/login/admin/abC1
 */
String.prototype.format = String.prototype.f = function () {
    var data = this, i = arguments.length;
    while (i--) {
        data = data.replace(new RegExp('\\{' + i + '\\}', 'gm'), arguments[i]);
    }
    return data;
};

/****
 * FOR BODY ONLOAD
 */
function init() {
    listPlatform();
    listGenre();
}

/****
 * FOR LIST PLATFORM.
 */
function listPlatform() {
    $.ajax({
        type: "GET",
        url: "controller/ControllerPlatform.php"
    })
            .done(function (data) {
                doneListPlatform(data);
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                failListPlatform();
            });
}

function doneListPlatform(data) {
    if (data === undefined) {
        failListPlatform();
    } else {
        listPlatformTitle = Object.values(data);
        initPlatform();
    }
}

function initPlatform() {
    var select1 = $("#platformFilter"),
    select2 = $("#platform"),
    option = null;
    for (var item in listPlatformTitle) {
        option = optFormat.format((parseInt(item) + 1).toString(), listPlatformTitle[item]);
        select1.append(option);
        select2.append(option);
    }
}

function failListPlatform() {
    modalMessage("Error was ocurred. Please try again!");
}

/****
 * FOR LIST GENRE.
 */
function listGenre() {
    $.ajax({
        type: "GET",
        url: "controller/ControllerGenre.php"
    })
            .done(function (data) {
                doneListGenre(data);
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                failListGenre();
            });
}

function doneListGenre(data) {
    if (data === undefined) {
        failListGenre();
    } else {
        listGenreTitle = Object.values(data);
        initGenre();
        listVideogames();
    }
}

function failListGenre() {
    modalMessage("Error was ocurred. Please try again!");
}

/****
 * FOR LIST VIDEOGAMES.
 */
function listVideogames() {
    videogame = {
        operation : "LIST"
    };
    $.ajax({
        type: "POST",
        url: "controller/ControllerVideogames.php",
        data: JSON.stringify(videogame),
        contentType: "application/json"
    })
            .done(function (data) {
                listData = Object.values(data);
                cont = listData[listData.length-1].id;
                table = $("#tableBody");
                doneListVideogames();
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                failListVideogames();
            });
}

function doneListVideogames() {
    table.html("");
    for (var item in listData) {
        row(table, listData[item]);
    }
}

function row(table, item) {
    var tr = $("<tr/>");
    tr.html(
            rowFormat.format(item.id, item.title, getPlatformText(item.idPlatform), getGenreText(item.idGenre), item.price,
            item.quantity, deleteIcon.format(item.id), updateIcon.format(item.id))
            );
    table.append(tr);
}

function failListVideogames() {
    modalMessage("Error was ocurred. Please try again!");
}

function getPlatformText(id) {
    return listPlatformTitle[id - 1];
}

function getGenreText(id) {
    return listGenreTitle[id - 1];
}

/****
 * FOR MODAL MESSAGE.
 */
function modalMessage(message) {
    var modal = $("#myModal"),
            close = $(".close").eq(0),
            writeHere = $("#text");
    writeHere.html(message);
    modal.css("display", "block");

    close.click(function () {
        modal.css("display", "none");
    });
}

/****
 * FOR FILTER.
 */
function filter() {
    var     id = parseInt($("#idFilter").val()),
            title = $("#titleFilter").val().trim().toLowerCase(),
            platform = parseInt($("#platformFilter").val()),
            listFilter = new Array(),
            current = undefined;
    if (id === "" && title === "" && platform === "null") {
        doneListVideogames();
        return;
    }
    for (var item in listData) {
        current = listData[item];
        if (current.id === id) {
            listFilter.push(listData[item]);
            continue;
        }
        if (current.title.toLowerCase().includes(title)) {
            listFilter.push(listData[item]);
            continue;
        }
        if (current.idPlatform === platform) {
            listFilter.push(listData[item]);
            continue;
        }
    }
    if (listFilter.length === 0) {
        noMatches();
    } else {
        setTable(listFilter);
    }
}

function noMatches() {
    table.html("");
    var tr = $("<tr/>");
    tr.html("<td colspan=\"8\" class=\"subtitle\"> Sorry, no matches!</td>");
    table.append(tr);
}

function setTable(listFilter) {
    table.html("");
    for (var item in listFilter) {
        row(table, listFilter[item]);
    }
}

/****
 * FOR RESET.
 */
function reset() {
    $("#idFilter").val("");
    $("#titleFilter").val("");
    $("#platformFilter").val("null");
    doneListVideogames();
}

/****
 * FOR DELETE.
 */
function deleteVideogame(code) {
    videogame = {
        operation : "DEL",
        id : code
    };
    $.ajax({
        type: "POST",
        url: "controller/ControllerVideogames.php",
        data: JSON.stringify(videogame),
        contentType: "application/json"
    })
            .done(function (data) {
                doneDeleteVideogames(data, code);
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                failDeleteVideogames();
            });
}

function doneDeleteVideogames(data, code) {
    if (data === false) {
        modalMessage("The operation could not be completed, please try again!");
    } else {
        deleteListData(parseInt(code));
        doneListVideogames();
        modalMessage("The videogame ({0}) was successfully deleted!".format(code));
    }
}

function failDeleteVideogames() {
    modalMessage("The operation could not be completed, please try again!");
}


/****
 * FOR KEEP LIST DATA UPDATED.
 */

function deleteListData(id) {
    for (var item in listData) {
        if (listData[item].id === id) {
            listData.splice(item, 1);
        }
    }
}

function insertListData(data) {
    listData.unshift(data);
}

function updateListData(data) {
    for (var item in listData) {
        if (listData[item].id === data.id) {
            listData.splice(item, 1, data);
        }
    }
}

/*****
 * FOR ADD
 */

function addVideogame() {
    videogame = {
        operation: "INS",
        object: {
            id: ++cont,
            title: $("#title").val(),
            idPlatform: parseInt($("#platform").val()),
            idGenre: parseInt($("#genre").val()),
            price: parseFloat($("#price").val()),
            quantity: parseInt($("#quantity").val()) 
        }
    };
    $.ajax({
        type: "POST",
        url: "controller/ControllerVideogames.php",
        data: JSON.stringify(videogame),
        contentType: "application/json"
    })
            .done(function (data) {
                doneAddVideogame(data);
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                failAddVideogame();
            });
}

function doneAddVideogame(data) {
    console.log(data);
    closeModal();
    if (data === false) {
        failAddVideogame();
    } else {
        insertListData(videogame.object);
        doneListVideogames();
        modalMessage("The videogame was successfully added!");
    }
}

function failAddVideogame() {
    closeModal();
    modalMessage("The operation could not be completed, please try again!");
}

function showModalAdd() {
    $("#formAdd").attr("action", "javascript:addVideogame()");
    $("#id").prop("disabled", true);
    $("#modalTitle").html("Add new videogame");
    $("#formAdd").trigger("reset");
    $("#modalAdd").css("display", "block");

}

function initGenre() {
    var select = $("#genre");
    for (var item in listGenreTitle) {
        select.append(optFormat.format((parseInt(item) + 1).toString(), listGenreTitle[item]));
    }
}

function closeModal() {
    $("#modalAdd").css("display", "none");
}

/*****
 * FOR UPDATE
 */

function updateVideogame() {
    videogame = {
        operation: "UPD",
        object: {
            id: parseInt($("#id").val()),
            title: $("#title").val(),
            idPlatform: parseInt($("#platform").val()),
            idGenre: parseInt($("#genre").val()),
            price: parseFloat($("#price").val()),
            quantity: parseInt($("#quantity").val()) 
        }
    };
    $.ajax({
        type: "POST",
        url: "controller/ControllerVideogames.php",
        data: JSON.stringify(videogame),
        contentType: "application/json"
    })
            .done(function (data) {
                doneUpdateVideogame(data);
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                failUpdateVideogame();
            });
}

function doneUpdateVideogame(data) {
    closeModal();
    if (data === false) {
        failUpdateVideogame();
    } else {
        updateListData(videogame.object);
        doneListVideogames();
        modalMessage("The videogame was successfully updated!");
    }
}

function failUpdateVideogame() {
    closeModal();
    modalMessage("The operation could not be completed, please try again!");
}

function showUpdateModal(id) {
    var item = getElement(parseInt(id));
    $("#formAdd").attr("action", "javascript:updateVideogame()");
    $("#modalTitle").html("Update videogame");
    $("#formAdd").trigger("reset");
    $("#id").val(item.id);
    $("#id").prop("disabled", true);
    $("#title").val(item.title);
    $("#platform").val(item.idPlatform);
    $("#genre").val(item.idGenre);
    $("#price").val(item.price);
    $("#quantity").val(item.quantity);
    $("#modalAdd").css("display", "block");
}

function getElement(id) {
    for (var item in listData) {
        if (listData[item].id === id) {
            return listData[item];
        }
    }
}