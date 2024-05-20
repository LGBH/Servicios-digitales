<?php
session_start(); // Inicias la sesión si no está iniciada aún

// Destruyes todas las variables de sesión
session_unset();

// Destruyes la sesión
session_destroy();

header("Location: ../Index.php");
exit;
