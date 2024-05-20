<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="./styles/Form.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <title>Login</title>
</head>

<body>
  <!-- Aqui tenemos el contenedor principal de la pagina login -->
  <div class="main-container">
    <div class="inicial">
      <img src="./images/Logo.png" alt="" />
      <h1>Servicios Digitales</h1>
    </div>
    <!-- Aqui creamos el div que contendra el formulario de login -->
    <div class="formulario mb-3">
      <h1>Login</h1>
      <!-- Aqui creamos el formulario -->
      <form action="./controllers/Login.php" method="post">
        <!-- Aqui solicitamos el correo electronico -->
        <label for="exampleFormControlInput1" class="form-label">Correo electronico:</label>
        <input type="email" class="form-control" id="correo" name="correo" placeholder="name@example.com" />
        <!-- Aqui solicitamos la contraseña -->
        <label for="inputPassword5" class="form-label">Contraseña:</label>
        <input type="password" id="contraseña" name="contraseña" class="form-control" aria-describedby="passwordHelpBlock" placeholder="Ingrese una contraseña" />
        <label for=""><a href="./pages/Register.html">¿Aun no tienes cuenta?. Registrate.</a></label>
        <button type="submit" class="btn btn-primary mb-3">
          Iniciar sesion
        </button>
      </form>
    </div>
  </div>
</body>

</html>