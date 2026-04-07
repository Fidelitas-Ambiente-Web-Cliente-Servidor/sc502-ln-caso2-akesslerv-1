<?php
class Solicitud
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function existeSolicitud($usuarioId, $tallerId)
    {
        $query = "SELECT id FROM solicitudes 
              WHERE usuario_id = ? 
              AND taller_id = ? 
              AND estado IN ('pendiente', 'aprobada')";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $usuarioId, $tallerId);
        $stmt->execute();

        return $stmt->get_result()->num_rows > 0;
    }

    public function crearSolicitud($usuarioId, $tallerId)
    {
        $query = "INSERT INTO solicitudes (usuario_id, taller_id, estado) 
              VALUES (?, ?, 'pendiente')";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $usuarioId, $tallerId);

        return $stmt->execute();
    }

    public function getPendientes()
    {
        $query = "SELECT s.id, s.taller_id, s.usuario_id, s.estado,
                     s.fecha_solicitud AS fecha,
                     t.nombre AS taller,
                     u.username
              FROM solicitudes s
              INNER JOIN talleres t ON s.taller_id = t.id
              INNER JOIN usuarios u ON s.usuario_id = u.id
              WHERE s.estado = 'pendiente'
              ORDER BY s.fecha_solicitud DESC";

        $result = $this->conn->query($query);

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    public function getById($id)
    {
        $query = "SELECT * FROM solicitudes WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function aprobar($solicitudId)
    {
        $query = "UPDATE solicitudes SET estado = 'aprobada' WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $solicitudId);

        return $stmt->execute();
    }

    public function rechazar($solicitudId)
    {
        $query = "UPDATE solicitudes SET estado = 'rechazada' WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $solicitudId);

        return $stmt->execute();
    }

}