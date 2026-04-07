<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/User.php';

class UserController
{

    private $model;

    public function __construct()
    {
        $database = new Database();
        $db = $database->connect();
        $this->model = new User($db);
    }

    public function showLogin()
    {
        require __DIR__ . '/../views/login.php';
    }

    public function showRegistro()
    {
        require __DIR__ . '/../views/register.php';
    }

    public function login()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = $this->model->login($username);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['user'] = $user['username'];
            $_SESSION['rol'] = $user['rol'];

            echo json_encode(['response' => "00", 'rol' => $user['rol'], 'message' => "Login exitoso"]);
        } else {
            echo json_encode(['response' => "01", 'message' => "Error de autentificacion"]);
        }
    }

    public function registro()
{
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!$username || !$password) {
        echo json_encode([
            'response' => "01",
            'message' => "Campos requeridos"
        ]);
        return;
    }

    //  validar usuario existente
    if ($this->model->exists($username)) {
        echo json_encode([
            'response' => "01",
            'message' => "El usuario ya existe"
        ]);
        return;
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $result = $this->model->create($username, $passwordHash);

    if ($result) {
        echo json_encode([
            'response' => "00",
            'message' => "Registro exitoso"
        ]);
    } else {
        echo json_encode([
            'response' => "01",
            'message' => "Error al registrar"
        ]);
    }
}

    public function logout()
    {
        session_destroy();
        echo json_encode(['response' => "00"]);
        exit;
    }
}
