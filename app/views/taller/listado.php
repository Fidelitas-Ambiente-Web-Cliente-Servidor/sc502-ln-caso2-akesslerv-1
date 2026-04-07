<!DOCTYPE html>
<html>

<head>
    <title>Listado Talleres</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="public/js/jquery-4.0.0.min.js"></script>
</head>

<body class="container mt-5">

    <nav class="d-flex justify-content-between mb-4">
        <div>
            <a class="btn btn-outline-primary" href="index.php?page=talleres">Talleres</a>
            <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                <a class="btn btn-outline-dark" href="index.php?page=admin">Admin</a>
            <?php endif; ?>
        </div>
        <div>
            <span class="me-3 fw-bold">
                <?= htmlspecialchars($_SESSION['user'] ?? 'Usuario') ?>
            </span>
            <button id="btnLogout" class="btn btn-danger">Cerrar sesión</button>
        </div>
    </nav>

    <h3 class="mb-3">Talleres Disponibles</h3>

    <table class="table table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Cupo</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody id="talleres-body">
            <tr>
                <td colspan="5" class="text-center">No hay talleres disponibles</td>
            </tr>
        </tbody>
    </table>

    <div id="mensaje" class="mt-3" style="display:none;"></div>

    <script src="public/js/taller.js"></script>

</body>
</html>