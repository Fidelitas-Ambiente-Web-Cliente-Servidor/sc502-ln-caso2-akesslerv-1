<!DOCTYPE html>
<html lang="es">
<head>
    <title>Admin - Solicitudes</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="public/js/jquery-4.0.0.min.js"></script>
</head>

<body class="container mt-5">

    <nav class="d-flex justify-content-between mb-4">
        <div>
            <a class="btn btn-outline-primary" href="index.php?page=talleres">Talleres</a>
            <a class="btn btn-outline-dark" href="index.php?page=admin">Admin</a>
        </div>
        <div>
            <span class="me-3 fw-bold">
                Admin: <?= htmlspecialchars($_SESSION['user'] ?? 'Admin') ?>
            </span>
            <button id="btnLogout" class="btn btn-danger">Cerrar sesión</button>
        </div>
    </nav>

    <h3>Solicitudes pendientes</h3>

    <table class="table table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Taller</th>
                <th>Usuario</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="solicitudes-body">
            <tr>
                <td colspan="5" class="text-center">No hay solicitudes</td>
            </tr>
        </tbody>
    </table>

    <div id="mensaje" class="mt-3" style="display:none;"></div>

    <script src="public/js/solicitud.js"></script>

</body>
</html>