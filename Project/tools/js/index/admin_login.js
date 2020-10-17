/*
 * PROJECT: PUBLIC LIBRARY.
 * LUIS J. BRAVO ZÚÑIGA.
 * ADMIN_LOGIN JS
 */

 /**** 
  * GLOBAL
 */
var user = null;

/****
 * FOR LOGIN
 */
function login() {
    user = {
            username: $("#username").val(),
            password: $("#password").val()
    };
    $.ajax({
        type: "POST",
        url: "controller/ControllerIndex.php",
        data: JSON.stringify(user),
        contentType: "application/json"
    })
            .done(function (data) {
                doneLogin(data);
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                failLogin();
            });
}

function doneLogin(data) {
    if(data.result === true) {
        location.href = "videogame.php";
    } else {
        failLogin();
    }
}

function failLogin() {
    var modal = $("#myModal"),
            close = $(".close").eq(0);
    modal.css("display", "block");

    close.click(function () {
        modal.css("display", "none");
    });

}