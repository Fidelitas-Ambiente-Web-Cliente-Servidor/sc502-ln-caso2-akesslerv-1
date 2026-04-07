$(document).ready(function () {

    const url = "index.php";

    $("#formRegister").submit(function (e) {
        e.preventDefault();

        let username = $("#username").val();
        let password = $("#password").val();

        if (!username || !password) {
            alert("Completa todos los campos");
            return;
        }

        $.post(url, {
            option: "register",
            username: username,
            password: password
        }, function (response) {

            let data = response;

            if (data.response === "00") {
                alert(data.message);
                window.location = "index.php?page=login";
            } else {
                alert(data.message);
            }

        }, "json");
    });

});