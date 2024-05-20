<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include("../db/conection.php");

    // Validar y sanitizar entradas
    $service_id = isset($_POST['service_id']) ? (int) $_POST['service_id'] : 0;
    $user_id = isset($_POST['user_id']) ? (int) $_POST['user_id'] : 0;
    $fecha_compra = date('Y-m-d H:i:s');

    // Depuración: Verificar datos recibidos
    if (!$service_id || !$user_id) {
        echo "Datos incompletos: service_id={$service_id}, user_id={$user_id}";
        exit;
    }

    if ($service_id && $user_id) {
        // Preparar la consulta SQL
        $stmt = $conexion->prepare("INSERT INTO compra (IdServicio, idUsuario, Fecha) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $service_id, $user_id, $fecha_compra);

        // Ejecutar la consulta y verificar si fue exitosa
        if ($stmt->execute()) {
            echo "Compra realizada con éxito";
        } else {
            echo "Error al realizar la compra: " . $stmt->error;
        }

        // Cerrar la declaración y la conexión
        $stmt->close();
        $conexion->close();
    } else {
        echo "Datos incompletos";
    }
} else {
    echo "Método de solicitud no permitido";
}
