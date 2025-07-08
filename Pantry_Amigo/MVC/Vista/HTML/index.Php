<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined&family=Material+Symbols+Rounded&display=swap">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="../CSS/estilosIndex.css">

  <title>Pantry Amigo</title>
</head>

<body>
  <!--HEADER and navbar-->
  <header>
    <div class="navbar section-content">
      <a href="#" class="nav-logo">
        <img src="../IMG/logosinfondo.png" alt="img">
        <h2 class="logo-text">PANTRY</h2>
      </a>
      <ul class="nav-menu">
        <button id="menu-close-button" class="fas fa-times"></button>
        <li class="nav-item">
          <a href="#" class="nav-link">INICIO</a>
        </li>
        <li class="nav-item">
          <a href="#sobre-nosotros" class="nav-link">SOBRE NOSOTROS</a>
        </li>
        <li class="nav-item">
          <a href="" class="nav-link">CUENTA</a>
          <ul class="submenu">
            <li><a href="../HTML/registro.php">REGISTRARSE</a></li>
            <li><a href="../HTML/login.php">INICIAR SESION</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">PARTICIPAR</a>
          <ul class="submenu">
            <li><a href="#casos">DONAR</a></li>
            <li><a href="Voluntariados.php">VOLUNTARIADO</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#opciones" class="nav-link">OPCIONES</a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">INFO</a>
        </li>
      </ul>
      <button id="menu-open-button" class="fas fa-bars"></button>

    </div>
  </header>

  <main>
    <!-- herr-->
    <section class="hero-section">
      <div class="section-content">
        <div class="hero-details">
          <h2 class="title">Pantry Amigo</h2>
          <h3 class="subtitle">Brinda una mano amiga</h3>
          <p class="description">En Pantry Amigo conectamos a quienes necesitan ayuda con personas y fundaciones dispuestas a brindar apoyo. Juntos podemos hacer la diferencia, una donación, un voluntario o un recurso a la vez.</p>
          <div class="buttons">
            <a href="#casos" class="button donar">Donar</a>
            <a href="#opciones" class="button participar">Participar</a>
          </div>
        </div>
        <div class="hero-image-wrapper">
          <img src="../IMG/hero.png" alt="Hero" class="hero-image">
        </div>
      </div>
    </section>
  </main>

  <!--About us-->
  <section class="about-section" id="sobre-nosotros">
    <div class="section-content">
      <div class="about-image-wrapper">
        <img src="../IMG/aboutus.jpg" alt="about us" class="about-image">
      </div>
      <div class="about-details">
        <h2 class="section-title">Sobre Nosotros</h2>
        <p class="text">Pantry Amigo es una plataforma que conecta donantes con comunidades vulnerables, facilitando la entrega de recursos esenciales. Junto a fundaciones y voluntarios, promovemos la solidaridad y generamos un impacto social positivo y sostenible.</p>

        <div class="social-link-list">
          <a href="#" class="social-link"><i class="fa-brands fa-facebook"></i></a>
          <a href="#" class="social-link"><i class="fa-brands fa-instagram"></i></a>
          <a href="#" class="social-link"><i class="fa-brands fa-x-twitter"></i></a>
        </div>
      </div>
    </div>
  </section>


  <!--Options-->
  <section class="options-section" id="opciones">
    <h1 class="options-section-title"> Juntos <span>Ayudamos</span></h1>
    <p class="options-section-description">Descubre cómo puedes unirte a causas, apoyar fundaciones y ayuda donde más se necesita. Cada acción cuenta.</p>
    <div class="options-section-cards">
      <div class="options-section-card" onclick="window.location.href='CasosActivos.php'">
        <div class="options-section-card-icon">
          <i class='bx bx-donate-heart'></i>
        </div>
        <h1 class="options-section-card-title">Casos activos</h1>
        <p>Elige un caso y dona.</p>
      </div>

      <div class="options-section-card" onclick="window.location.href='Fundaciones.php'">
        <div class="options-section-card-icon">
          <i class='bx bx-home-heart'></i>
        </div>
        <h1 class="options-section-card-title">Fundaciones aliadas</h1>
        <p>Conoce nuestras fundaciones.</p>
      </div>



      <div class="options-section-card" onclick="window.location.href='ConsultarParticipacion.php'">
        <div class="options-section-card-icon">
          <i class='bx bx-file-find'></i>
        </div>
        <h1 class="options-section-card-title">Consultar Participación</h1>
        <p>Revisa tu historial por cédula.</p>
      </div>

    </div>
  </section>


  <!-- Carrusel dinámico de casos activos -->
  <section class="container-slider swiper" id="casos">
    <h1 class="swiper-title">Historias increíbles</h1>
    <p class="swiper-description">Descubre cómo cada donación cambia vidas y genera un impacto real en las comunidades.</p>

    <div class="card-wrapper">
      <ul class="card-list swiper-wrapper">
        <?php
        include_once '../../Modelo/ConexionBD.php';
        $conexion = new ConexionBD();

        if ($conexion->abrir()) {
          $sql = "SELECT Caso_Id, Caso_Nombre, Caso_Descripcion, Caso_Imagen, Caso_Fund_Id 
          FROM tbl_casos_Dinero 
          WHERE Caso_Estado = 'Activo' 
          LIMIT 6";

          if ($conexion->consulta($sql)) {
            $result = $conexion->obtenerResult();

            if ($result && $result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                // Ruta relativa completa igual a Detalles.php
                $imgRuta = !empty($row['Caso_Imagen']) ? '/Pantry_Amigo/' . $row['Caso_Imagen'] : '/Pantry_Amigo/IMG/default.jpg';

                echo '<li class="card-item swiper-slide">';
                echo '<a href="Detalles.php?ID=' . urlencode($row['Caso_Id']) . '&tipo=dinero">';
                echo '<img src="' . htmlspecialchars($imgRuta) . '" alt="Imagen del caso" class="card-img">';
                echo '<p class="badge">Fundación ID: ' . htmlspecialchars($row['Caso_Fund_Id']) . '</p>';
                echo '<h2 class="card-title">' . htmlspecialchars($row['Caso_Nombre']) . '</h2>';
                echo '<p class="description">' . htmlspecialchars($row['Caso_Descripcion']) . '</p>';
                echo '<span class="card-button material-symbols-rounded">arrow_forward</span>';
                echo '</a>';
                echo '</li>';
              }
            } else {
              echo '<li class="card-item swiper-slide"><p>No hay casos activos.</p></li>';
            }
          } else {
            echo '<li class="card-item swiper-slide"><p>Error al ejecutar la consulta.</p></li>';
          }

          $conexion->cerrar();
        } else {
          echo '<li class="card-item swiper-slide"><p>Error al conectar con la base de datos.</p></li>';
        }
        ?>



      </ul>

      <div class="swiper-pagination"></div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
    </div>
  </section>


  <!-- Team members-->
  <section class="members-section">
    <h2 class="section-title">Team Members</h2>
    <div class="section-content">
      <ul class="members-list">
        <li class="member">
          <img src="../IMG/aboutus.jpg" alt="user" class="user-image">
          <h3 class="name">Laura Bolívar</h3>
          <i class="feedback">"Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis, qui?"</i>
        </li>

        <li class="member">
          <img src="../IMG/aboutus.jpg" alt="user" class="user-image">
          <h3 class="name">Daniel Martinez</h3>
          <i class="feedback">"Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis, qui?"</i>
        </li>

        <li class="member">
          <img src="../IMG/aboutus.jpg" alt="user" class="user-image">
          <h3 class="name">Alejandro Gómez</h3>
          <i class="feedback">"Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis, qui?"</i>
        </li>
      </ul>
    </div>



    <div id="chatbot" style="position:fixed;bottom:20px;right:20px;width:300px;background:#fff;border-radius:10px;box-shadow:0 0 10px #aaa;z-index:9999;">
      <div style="background:#4CAF50;color:#fff;padding:10px;border-radius:10px 10px 0 0;">
        Chatbot Pantry Amigo
        <span id="close-chatbot" style="float:right;cursor:pointer;">&times;</span>
      </div>
      <div id="chatbot-messages" style="height:200px;overflow-y:auto;padding:10px;font-size:14px;"></div>
      <div style="display:flex;">
        <input id="chatbot-input" type="text" placeholder="Escribe tu pregunta..." style="flex:1;padding:8px;border:none;border-top:1px solid #eee;">
        <button onclick="sendChatbotMessage()" style="background:#4CAF50;color:#fff;border:none;padding:8px 12px;">Enviar</button>
      </div>
    </div>

    <button id="open-chatbot" style="position:fixed;bottom:20px;right:20px;z-index:9998;display:none;background:#2b577d;color:#fff;border:none;border-radius:50%;width:50px;height:50px;font-size:24px;box-shadow:0 0 10px #aaa;cursor:pointer;">
      💬
    </button>

    <script>
      // Respuestas predeterminadas usando if anidados
      function getChatbotResponse(msg) {
        // ...existing code...
        const saludos = [
          "¡Hola! ¿En qué puedo ayudarte?",
          "¡Buenas! ¿Cómo puedo asistirte?",
          "¡Holi! ¿Necesitas información sobre Pantry Amigo?"
        ];
        const donar = [
          "Puedes donar haciendo clic en el botón 'Donar' o visitando la sección de casos activos.",
          "Para donar, dirígete a la sección de casos activos y elige un caso.",
          "Haz clic en 'Donar' para comenzar tu aporte."
        ];
        const ayudaDonar = [
          "¿Te gustaría saber cómo donar o necesitas ayuda con el proceso?",
          "¿Quieres que te explique el proceso de donación?",
          "¿Tienes dudas sobre cómo donar? Estoy aquí para ayudarte."
        ];
        const voluntario = [
          "¿Quieres información sobre cómo ser voluntario?",
          "¿Te gustaría unirte como voluntario? Puedo indicarte cómo.",
          "¿Buscas ser voluntario? Te explico cómo hacerlo."
        ];
        const inscribirVoluntario = [
          "Para inscribirte como voluntario, ve a la sección 'Voluntariado' en el menú.",
          "Puedes inscribirte como voluntario desde la sección correspondiente en el menú principal.",
          "Haz clic en 'Voluntariado' para inscribirte y ayudar."
        ];
        const fundacion = [
          "Puedes conocer nuestras fundaciones aliadas en la sección correspondiente del menú.",
          "Visita la sección de fundaciones aliadas para más información.",
          "En el menú encontrarás la sección de fundaciones aliadas."
        ];
        const noEntiendo = [
          "Lo siento, no entendí tu pregunta. ¿Puedes reformularla?",
          "No comprendí tu mensaje, ¿puedes escribirlo de otra forma?",
          "Disculpa, ¿puedes aclarar tu pregunta?"
        ];

        function random(arr) {
          return arr[Math.floor(Math.random() * arr.length)];
        }

        if (msg.includes("hola") || msg.includes("buenas") || msg.includes("holi")) {
          return random(saludos);
        } else if (msg.includes("donar") || msg.includes("donacion") || msg.includes("donaciones")) {
          if (msg.includes("cómo") || msg.includes("dónde")) {
            return random(donar);
          } else {
            return random(ayudaDonar);
          }
        } else if (msg.includes("voluntario")) {
          if (msg.includes("inscrib")) {
            return random(inscribirVoluntario);
          } else {
            return random(voluntario);
          }
        } else if (msg.includes("fundacion")) {
          return random(fundacion);
        } else {
          return random(noEntiendo);
        }
      }

      function sendChatbotMessage() {
        var input = document.getElementById('chatbot-input');
        var messages = document.getElementById('chatbot-messages');
        var userMsg = input.value.trim();
        if (!userMsg) return;
        messages.innerHTML += "<div><b>Tú:</b> " + userMsg + "</div>";
        var botResponse = getChatbotResponse(userMsg);
        setTimeout(function() {
          messages.innerHTML += "<div style='color:#2b577d'><b>Amigo:</b> " + botResponse + "</div>";
          messages.scrollTop = messages.scrollHeight;
        }, 500);
        input.value = "";
      }

      // Mostrar y ocultar el chatbot
      document.getElementById('close-chatbot').onclick = function() {
        document.getElementById('chatbot').style.display = 'none';
        document.getElementById('open-chatbot').style.display = 'block';
      };
      document.getElementById('open-chatbot').onclick = function() {
        document.getElementById('chatbot').style.display = 'block';
        document.getElementById('open-chatbot').style.display = 'none';
      };
    </script>
</body>
</section>



<!-- Footer -->
<footer class="footer-section">
  <div class="section-content">
    <p class="copyright-text">© 2025 Pantry Amigo</p>

    <div class="social-link-list">
      <a href="#" class="social-link"><i class="fa-brands fa-facebook"></i></a>
      <a href="#" class="social-link"><i class="fa-brands fa-instagram"></i></a>
      <a href="#" class="social-link"><i class="fa-brands fa-x-twitter"></i></a>
    </div>
    <p class="policy-text">
      <a href="#" class="policy-link"> Privacy Policy</a>
    </p>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="../JS/swiper.js"></script>
<script src="../JS/indexscript.js"></script>

</body>

</html>