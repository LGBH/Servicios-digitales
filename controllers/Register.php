<?php
$nombre1 = $_POST['nombre1'];
$nombre2 = $_POST['nombre2'];
$apellido1 = $_POST['apellido1'];
$apellido2 = $_POST['apellido2'];
$correo = $_POST['correo'];
$mensajeEncriptado = $_POST['mensaje'];

include("../db/conection.php");
$conn = connect();

// Encriptamos la contraseña
$password = $_POST['mensaje'];
$encrypted_password = openssl_encrypt($password, 'AES-128-ECB', '123456');

// Creamos las variables que enviaremos a la base de datos
$nombre1 = $_POST['nombre1'];
$nombre2 = $_POST['nombre2'];
$apellido1 = $_POST['apellido1'];
$apellido2 = $_POST['apellido2'];
$correo = $_POST['correo'];

// Registramos la informacion del usuario en la base de datos
$sql = "INSERT INTO usuarios (nombre1, nombre2, apellido1, apellido2, correo, contraseña)
VALUES ('$nombre1', '$nombre2', '$apellido1', '$apellido2', '$correo', '$encrypted_password')";

if ($conn->query($sql) === TRUE) {
    echo "Usuario registrado con exito";
    header('Location: ../');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cerramos la conexion 
$conn->close();
