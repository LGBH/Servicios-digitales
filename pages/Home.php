<?php
session_start(); // Iniciar la sesión
if (!isset($_SESSION['user_id'])) {
  // Si no hay una sesión activa, redirigir al usuario a la página de inicio de sesión
  header("Location: ../pages/Login.html");
  exit;
}
include("../db/conection.php");

$sql = "SELECT * FROM servicios";
$query = mysqli_query($conexion, $sql);

if (!$query) {
  die('Error en la consulta: ' . mysqli_error($conexion));
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../styles/Index.css" />
  <title>ServiciosDigitales</title>
</head>

<body>
  <!-- Este el el div que contiene toda la pagina web -->
  <div class="main-container">
    <!-- Esta es la navbar de la pagina -->
    <nav>
      <div class="logo">
        <img src="../images/Logo.png" alt="" />
        <h1>Servicios Digitales</h1>
      </div>
      <ul class="opciones">
        <li><a href="">Inicio</a></li>
        <li><a href="#catalogo">Servicios</a></li>
        <li><a href="#contacto">Contacto</a></li>
      </ul>
      <ul class="opciones inicio">
        <?php
        if (isset($_SESSION['correo'])) {
          // Si hay una sesión activa, mostrar el correo del usuario
          echo '<li><span>' . htmlspecialchars($_SESSION['correo']) . '</span></li>';
          echo '<li><a href="../controllers/Logout.php">Cerrar sesión</a></li>'; // Enlace para cerrar sesión
        }
        ?>
      </ul>
    </nav>
    <!-- Aquí va la sección del catálogo de los servicios -->
    <div id="catalogo" class="catalogo">
      <?php
      while ($row = mysqli_fetch_array($query)) {
      ?>
        <!-- Div para un servicio en específico -->
        <div class="servicio">
          <div class="servicio-imagen">
            <img src="../images/Services/<?php echo htmlspecialchars($row['Imagen']); ?>" alt="" />
          </div>
          <div class="servicio-informacion <?php echo htmlspecialchars($row['Nombre']); ?>">
            <div class="nombre">
              <h2><?php echo htmlspecialchars($row['Nombre']); ?></h2>
            </div>

            <p class="servicio-texto">
              <?php echo htmlspecialchars($row['Descripcion']); ?>
            </p>

            <p class="precio">$<?php echo htmlspecialchars($row['precio']); ?></p>
            <div class="servicio-funciones">
              <button onclick="AbrirModal({
                id: <?php echo htmlspecialchars($row['ID']); ?>, 
                Nombre: '<?php echo htmlspecialchars($row['Nombre']); ?>', 
                Descripcion: '<?php echo htmlspecialchars($row['Descripcion']); ?>', 
                precio: <?php echo htmlspecialchars($row['precio']); ?>, 
                Imagen: '<?php echo htmlspecialchars($row['Imagen']); ?>'
            })">Comprar</button>
              <!--<button class="com">Comprar ahora</button>-->
              <button class="fav">Agregar a favoritos</button>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>

    <!-- Este es el footer de la pagina donde se pondra informacion de contacto -->
    <footer id="contacto">

      <div class="contactos">
        <div class="contacto">
          <a href="">
            <img src="../images/Contacts/facebook.png" alt="">
            <p>Servicios_Digitales</p>
          </a>
        </div>
        <div class="contacto">
          <a href="">
            <img src="../images/Contacts/whatsapp.png" alt="">
            <p>3001943982</p>
          </a>
        </div>
        <div class="contacto">
          <a href="">
            <img src="../images/Contacts/gmail.png" alt="">
            <p>ServiciosDigitales@gmail.com</p>
          </a>
        </div>
      </div>
    </footer>
  </div>

  <div id="myModal" class="modal">
    <div class="modal-content">
      <img id="modalImage" src="" alt="Imagen del servicio" />
      <div id="mo-con" class="modal-info">
        <p id="modalDescription"></p>
        <p id="modalPrice"></p>
        <button onclick="confirmarCompra()">Confirmar Compra</button>
        <button onclick="CerrarModal()">Cancelar</button>
      </div>
    </div>
  </div>

  <script>
    function AbrirModal(service) {
      document.getElementById("myModal").style.display = "block";
      document.getElementById("mo-con").classList.add(service.Nombre);
      document.getElementById("modalDescription").innerText = service.Descripcion;
      document.getElementById("modalPrice").innerText = "$" + service.precio;
      document.getElementById("modalImage").src = "../images/Services/" + service.Imagen;
      document.getElementById("myModal").setAttribute("data-service-id", service.id);
    }

    function CerrarModal() {
      var modal = document.getElementById("myModal");
      var modalContent = document.getElementById("mo-con");
      modalContent.className = 'modal-info';
      modal.style.display = "none";
    }

    function confirmarCompra() {
      var serviceId = document.getElementById("myModal").getAttribute("data-service-id");
      var userId = <?php echo json_encode($_SESSION['user_id']); ?>;

      var formData = new FormData();
      formData.append("service_id", serviceId);
      formData.append("user_id", userId);

      fetch('../controllers/Comprar.php', {
          method: 'POST',
          body: formData
        })
        .then(response => response.text())
        .then(data => {
          console.log(data);
          alert(data);
          CerrarModal();
        })
        .catch(error => {
          console.error("Error al realizar la compra:", error);
          alert("Error al realizar la compra");
        });
    }
  </script>
</body>

</html>