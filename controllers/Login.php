<?php
session_start(); // Inicias la sesión

include("../db/conection.php");
$conn = connect();

$correo = $_POST['correo'];
$password = $_POST['contraseña'];

// Traemos el ID y la contraseña encriptada del usuario
$sql = "SELECT id, contraseña FROM usuarios WHERE correo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $encrypted_password = $row['contraseña'];
    $user_id = $row['id']; // Obtenemos el ID del usuario

    // Desencriptamos la contraseña
    $key = '123456';
    $decrypted_password = openssl_decrypt($encrypted_password, 'AES-128-ECB', $key);

    // Comparamos la contraseña decifrada con la que el usuario está ingresando
    if ($decrypted_password === $password) {
        // Almacenamos el ID del usuario y su correo en variables de sesión
        $_SESSION['user_id'] = $user_id;
        $_SESSION['correo'] = $correo;

        // Redirigimos a la página Home
        header('Location: ../pages/Home.php');
        exit;
    } else {
        echo "Contraseña incorrecta.";
    }
} else {
    echo "Usuario no encontrado.";
}

$conn->close();
