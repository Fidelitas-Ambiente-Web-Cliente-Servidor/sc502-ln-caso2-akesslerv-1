$(document).ready(function () {

    const url = "index.php";

    function cargarTalleres() {
        $.get(url, { option: "getTalleres" }, function (data) {

            let html = "";

            if (data.length === 0) {
                html = `<tr><td colspan="5">No hay talleres</td></tr>`;
            } else {
                data.forEach(t => {
                    html += `
                        <tr>
                            <td>${t.id}</td>
                            <td>${t.nombre}</td>
                            <td>${t.descripcion}</td>
                            <td>${t.cupo_disponible}</td>
                            <td>
                                <button class="btn btn-success solicitar" data-id="${t.id}">
                                    Solicitar
                                </button>
                            </td>
                        </tr>
                    `;
                });
            }

            $("#talleres-body").html(html);

        }, "json");
    }

    cargarTalleres();

    // SOLICITAR
    $(document).on("click", ".solicitar", function () {
        console.log("CLICK SOLICITAR");

        let id = $(this).data("id");

        $.post("index.php", {
            option: "solicitar",
            taller_id: id
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

    // LOGOUT
    $("#btnLogout").click(function () {
        $.post(url, { option: "logout" }, function () {
            window.location = "index.php?page=login";
        });
    });

});