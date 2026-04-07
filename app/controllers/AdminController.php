<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Solicitud.php';
require_once __DIR__ . '/../models/Taller.php';

class AdminController
{
    private $solicitudModel;
    private $tallerModel;

    public function __construct()
    {
        $database = new Database();
        $db = $database->connect();
        $this->solicitudModel = new Solicitud($db);
        $this->tallerModel = new Taller($db);
    }

    public function solicitudes()
    {
        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
            header('Location: index.php?page=login');
            return;
        }
        require __DIR__ . '/../views/admin/solicitudes.php';
    }

    public function getSolicitudesJson()
    {
        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
            echo json_encode([]);
            exit;
        }

        $data = $this->solicitudModel->getPendientes();
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    // Aprobar solicitud
    public function aprobar()
    {
        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
            echo json_encode(['success' => false, 'error' => 'No autorizado']);
            exit;
        }

        $solicitudId = $_POST['id_solicitud'] ?? 0;

        if (!$solicitudId) {
            echo json_encode(['success' => false, 'error' => 'ID inválido']);
            exit;
        }

        try {
            $solicitud = $this->solicitudModel->getById($solicitudId);

            if (!$solicitud)
                throw new Exception("Solicitud no encontrada");
            if ($solicitud['estado'] !== 'pendiente')
                throw new Exception("Ya procesada");

            $tallerId = $solicitud['taller_id'];

            if (!$this->tallerModel->descontarCupo($tallerId)) {
                throw new Exception("No hay cupo disponible");
            }

            if (!$this->solicitudModel->aprobar($solicitudId)) {
                throw new Exception("Error al aprobar");
            }

            echo json_encode(['success' => true, 'message' => 'Aprobada']);
            exit;

        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            exit;
        }
    }
    public function rechazar()
    {
        if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
            echo json_encode(['success' => false, 'error' => 'No autorizado']);
            return;
        }

        $solicitudId = $_POST['id_solicitud'] ?? 0;

        if ($this->solicitudModel->rechazar($solicitudId)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error al rechazar']);
        }
    }
}