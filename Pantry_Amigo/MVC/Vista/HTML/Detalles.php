<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Detalles del Caso</title>
  <link rel="stylesheet" href="../CSS/estilosDetalles.css">
  <link rel="stylesheet" href="../CSS/estilosIndex.css">
  <script src="https://cdn.jsdelivr.net/npm/progressbar.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
          <a href="#" class="nav-link">HOME</a>
        </li>
        <li class="nav-item">
          <a href="#sobre-nosotros" class="nav-link">ABOUT US</a>
        </li>
        <li class="nav-item">
          <a href="" class="nav-link">ACOUNT</a>
          <ul class="submenu">
            <li><a href="../HTML/registro.php">SIGN UP</a></li>
            <li><a href="../HTML/login.php">LOGIN</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">PARTICIPATE</a>
          <ul class="submenu">
            <li><a href="#casos">DONATE</a></li>
            <li><a href="Voluntariados.php">VOLUNTEERING</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#opciones" class="nav-link">OPTIONS</a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">INFO</a>
        </li>
      </ul>
      <button id="menu-open-button" class="fas fa-bars"></button>
    </div>
  </header>

  <main class="content">
    <div class="titulo">
      <h2>Detalles del Caso</h2>
    </div>


      <div id="detalle-info">
        <!-- Aquí se mostrará la información del caso -->
      </div>

  </main>

  <!-- Modal Voluntariado -->
<div id="modal-voluntariado" class="modal-voluntariado" style="display:none;">
  <div class="modal-content-voluntariado">
    <span class="close-modal-vol" onclick="cerrarModalVoluntariado()">&times;</span>
    <iframe id="iframe-voluntariado" src="" frameborder="0" style="width:100%;height:600px;border:none;"></iframe>
  </div>
</div>

  <script>
    function abrirModalVoluntariado(casoId) {
  document.getElementById('iframe-voluntariado').src = 'RegistrarVoluntario.php?ID=' + casoId;
  document.getElementById('modal-voluntariado').style.display = 'flex';
}
function cerrarModalVoluntariado() {
  document.getElementById('modal-voluntariado').style.display = 'none';
  document.getElementById('iframe-voluntariado').src = '';
}

    document.addEventListener("DOMContentLoaded", function() {
      const urlParams = new URLSearchParams(window.location.search);
      const casoId = urlParams.get('ID');

      if (!casoId) {
        document.getElementById('detalle-info').innerHTML = "<p>Error: falta el parámetro del ID en la URL.</p>";
        return;
      }

      const endpoint = '/Pantry_Amigo/MVC/Vista/HTML/ObtenerDetallesDinero.php';

      fetch(`${endpoint}?ID=${casoId}`)
        .then(response => response.json())
        .then(data => {
  const detalleInfo = document.getElementById('detalle-info');
  if (data.error) {
    detalleInfo.innerHTML = `<p>${data.error}</p>`;
  } else {
    const botones = `
      <div class="botones-detalle">
        <button onclick="window.location.href='Donar.php?ID=${data.Caso_Id}&categoria=${encodeURIComponent(data.Caso_Cat_Nombre)}'">Donar</button>
        ${data.Caso_Voluntariado == 1 ? `<button onclick="abrirModalVoluntariado(${data.Caso_Id})">Voluntariado</button>` : ''}
      </div>`;

    // Contenido HTML del caso
    const contenido = `
      <div class="caso">
        <div class="info-caso">
          <h3>${data.Caso_Nombre}</h3>
          <p>${data.Caso_Descripcion}</p>
          <div class="monto-caso">
            <p><strong>Monto Meta:</strong> $${data.Caso_Monto_Meta}</p>
          </div>
          ${botones}
        </div>
        <div class="imagen-porcentaje-row">
          <div class="imagen-container">
            <img src="/Pantry_Amigo/${data.Caso_Imagen}" alt="Imagen del caso" />
          </div>
          <div class="porcentaje">
            <p><strong>Recaudado:</strong> $${data.Caso_Monto_Recaudado}</p>
            <div id="barra-progreso" style="height: 25px;"></div>
          </div>
        </div>
      </div>

      <div class="detalles-caso-wrapper">
        <div class="detalles-header">
          <h4 class="margin">Detalles del Caso</h4>
          <div class="num-id"><p><strong>id:</strong> ${data.Caso_Id}</p></div>
        </div>
        <div class="detalles">
          <div class="detalles-caso-fundacion">
            <p>Esta causa es administrada por la <strong>Fundación: ${data.Fundacion_Nombre}</strong></p>
            <p>¿Quieres comunicarte con la fundación? <br> <strong>Correo:</strong> ${data.Fundacion_Correo}</p>
            <p><strong>Teléfono:</strong> ${data.Fundacion_Telefono}</p>
            <p><strong>Dirección:</strong> ${data.Fundacion_Direccion}</p>
          </div>
          <div class="detalles-caso-table">
            <div class="celda"><p>Fecha de Inicio:</p></div>
            <div class="celda-info"><strong>${data.Caso_Fecha_Inicio}</strong></div>
            <div class="celda"><p>Fecha de Fin:</p></div>
            <div class="celda-info"><strong>${data.Caso_Fecha_Fin}</strong></div>
            <div class="celda"><p>Categoría:</p></div>
            <div class="celda-info"><strong>${data.Caso_Cat_Nombre}</strong></div>
            <div class="celda"><p>Voluntariado:</p></div>
            <div class="celda-info"><strong>${data.Caso_Voluntariado == 1 ? 'Sí' : 'No'}</strong></div>
          </div>
        </div>
      </div>
    `;

    detalleInfo.innerHTML = contenido;

    // === BARRA DE PROGRESO ANIMADA ===
    let color;
    if (data.porcentaje < 50) {
      color = '#f44336'; // rojo
    } else if (data.porcentaje < 75) {
      color = '#ffc107'; // amarillo
    } else {
      color = '#00c851'; // verde
    }

    const barra = new ProgressBar.Line('#barra-progreso', {
      strokeWidth: 6,
      easing: 'easeInOut',
      duration: 1200,
      color: color,
      trailColor: '#eee',
      trailWidth: 1,
      svgStyle: { width: '100%', height: '100%' },
      text: {
        style: {
          color: '#000',
          position: 'absolute',
          right: '0',
          top: '-25px',
          padding: 0,
          margin: 0,
          transform: null
        },
        autoStyleContainer: false
      },
      step: function(state, bar) {
        bar.setText(Math.round(bar.value() * 100) + '%');
      }
    });

    barra.animate(data.porcentaje / 100);
  }
});
    });

    // Escuchar mensajes del iframe para mostrar alertas y cerrar el modal
window.addEventListener('message', function(event) {
  // Puedes validar event.origin si quieres mayor seguridad
  if (event.data === 'voluntariado_exito') {
    Swal.fire({
      icon: 'success',
      title: '¡Registro exitoso!',
      text: 'Te has registrado como voluntario correctamente.',
      timer: 2500,
      showConfirmButton: false
    });
    cerrarModalVoluntariado();
  } else if (event.data === 'voluntariado_error') {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'No se pudo registrar tu voluntariado. Intenta de nuevo.',
      timer: 2500,
      showConfirmButton: false
    });
    cerrarModalVoluntariado();
  }
});
  </script>
</body>
</html>