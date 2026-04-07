$(document).ready(function () {

    const url = "index.php";

    function cargarSolicitudes() {
        $.get(url, { option: "getSolicitudes" }, function (data) {

            let html = "";

            if (data.length === 0) {
                html = `<tr><td colspan="5">No hay solicitudes</td></tr>`;
            } else {
                data.forEach(s => {
                    html += `
                        <tr>
                            <td>${s.id}</td>
                            <td>${s.taller}</td>
                            <td>${s.username}</td>
                            <td>${s.fecha_solicitud}</td>
                            <td>
                                <button class="btn btn-success aprobar" data-id="${s.id}">Aprobar</button>
                                <button class="btn btn-danger rechazar" data-id="${s.id}">Rechazar</button>
                            </td>
                        </tr>
                    `;
                });
            }

            $("#solicitudes-body").html(html);

        }, "json");
    }

    cargarSolicitudes();

    // APROBAR
    $(document).on("click", ".aprobar", function () {
        console.log("CLICK APROBAR");

        let id = $(this).data("id");

        $.post("index.php", {
            option: "aprobar",
            id_solicitud: id
        }, function (res) {
            console.log(res);

            if (res.success) {
                alert(res.message);
                location.reload();
            } else {
                alert(res.error);
            }
        }, "json");
    });

    // rechjazar
    $(document).on("click", ".rechazar", function () {
        console.log("CLICK RECHAZAR");

        let id = $(this).data("id");

        $.post("index.php", {
            option: "rechazar",
            id_solicitud: id
        }, function (res) {
            console.log(res);

            if (res.success) {
                alert("Rechazada");
                location.reload();
            } else {
                alert(res.error);
            }
        }, "json");
    });

    // LOGOUT
    $("#btnLogout").click(function () {
        $.post(url, { option: "logout" }, function () {
            window.location = "index.php?page=login";
        });
    });

});