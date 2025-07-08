<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Casos de Donación</title>
  <link rel="stylesheet" href="../CSS/estilosCasosActivos.css">
</head>

<body>
  <header>
    <div class="navbar section-content">
      <a href="#" class="nav-logo">
        <img src="../IMG/logosinfondo.png" alt="img">
        <h2 class="logo-text">PANTRY</h2>
      </a>
      <ul class="nav-menu">
        <button id="menu-close-button" class="fas fa-times"></button>
        <li class="nav-item">
          <a href="../HTML/index.Php" class="nav-link">HOME</a>
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
          <a href="../HTML/ConsultarFundacion.php" class="nav-link">COLABORATORS</a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">INFO</a>
        </li>
      </ul>
      <button id="menu-open-button" class="fas fa-bars"></button>
    </div>
  </header>

  <main class="content-flex">
    <!-- Menú lateral de filtros -->
    <aside class="filtros-lateral">
      <h3>Filtrar casos</h3>
      <div class="filtro-group">
        <label for="filtro-categoria">Categoría:</label>
        <select id="filtro-categoria" onchange="filtrarCasos()">
          <option value="">Todas</option>
          <option value="Salud">Salud</option>
          <option value="Educación">Educación</option>
          <option value="Alimentación">Alimentación</option>
          <option value="Emergencias">Emergencias</option>
          <option value="Tecnología">Tecnología</option>
          <option value="Medio Ambiente">Medio Ambiente</option>
        </select>
      </div>
      <div class="filtro-group">
        <label for="filtro-voluntariado">Voluntariado:</label>
        <select id="filtro-voluntariado" onchange="filtrarCasos()">
          <option value="">Todos</option>
          <option value="1">Sí</option>
          <option value="0">No</option>
        </select>
      </div>
      <div class="filtro-group">
        <label for="filtro-estado">Estado:</label>
        <select id="filtro-estado" onchange="filtrarCasos()">
          <option value="">Todos</option>
          <option value="Activo">Activo</option>
          <option value="Inactivo">Inactivo</option>
        </select>
      </div>
      <div class="filtro-group">
        <label for="filtro-monto">Monto meta:</label>
        <select id="filtro-monto" onchange="filtrarCasos()">
          <option value="">Todos</option>
          <option value="1">Menos de $1.000.000</option>
          <option value="2">Entre $1.000.000 y $5.000.000</option>
          <option value="3">Más de $5.000.000</option>
        </select>
      </div>
      <div class="filtro-group">
        <label for="filtro-fecha">Ordenar por:</label>
        <select id="filtro-fecha" onchange="filtrarCasos()">
          <option value="">Ninguno</option>
          <option value="recientes">Casos recientes</option>
          <option value="finalizar">Próximos a finalizar</option>
        </select>
      </div>
    </aside>

    <!-- Sección de Casos -->
    <section id="casos" class="seccion-activa">
      <div class="cases" id="lista-casos">
        <!-- Aquí se cargarán los casos dinámicamente -->
      </div>
    </section>
  </main>

  <script>
  let todosLosCasos = []; // Variable global para guardar todos los casos

  function cargarCasos() {
    fetch('/Pantry_Amigo/MVC/Vista/HTML/ObtenerCasosDinero.php')
      .then(response => {
        if (!response.ok) throw new Error(`Error HTTP: ${response.status}`);
        return response.json();
      })
      .then(data => {
        if (!Array.isArray(data)) throw new Error('La respuesta no es un array');

        todosLosCasos = data; // Guardamos todos los casos para filtrar localmente
        mostrarCasos(data);
      })
      .catch(error => {
        console.error('Error al cargar los casos:', error);
        document.getElementById('lista-casos').innerHTML = '<p>Error al cargar los casos.</p>';
      });
  }

  function mostrarCasos(casos) {
    const listaCasos = document.getElementById('lista-casos');
    listaCasos.innerHTML = '';

    if (casos.length === 0) {
      listaCasos.innerHTML = '<p>No hay casos en esta categoría.</p>';
      return;
    }

    casos.forEach(caso => {
      const casoHTML = `
        <div class="case">
          <h3>${caso.Caso_Nombre}</h3>
          <img src="/Pantry_Amigo/${caso.Caso_Imagen}" alt="Imagen del caso">
          <p>ID: ${caso.Caso_Id}</p>
          <p>Descripción: ${caso.Caso_Descripcion}</p>
          <p>Categoría: ${caso.Caso_Cat_Nombre}</p>
          <p>Voluntariado: ${caso.Caso_Voluntariado == 1 ? 'Sí' : 'No'}</p>
          <p>Estado: ${caso.Caso_Estado ? caso.Caso_Estado : 'Activo'}</p>
          <p>Monto meta: $${Number(caso.Caso_Monto_Meta).toLocaleString()}</p>
          <p>Fecha de inicio: ${caso.Caso_Fecha_Inicio ? caso.Caso_Fecha_Inicio : ''}</p>
          <p>Fecha de fin: ${caso.Caso_Fecha_Fin ? caso.Caso_Fecha_Fin : ''}</p>
          <button onclick="window.location.href='Detalles.php?ID=${caso.Caso_Id}&tipo=dinero'">Ver detalles</button>
        </div>
      `;
      listaCasos.insertAdjacentHTML('beforeend', casoHTML);
    });
  }

  function filtrarCasos() {
    const categoria = document.getElementById('filtro-categoria').value;
    const voluntariado = document.getElementById('filtro-voluntariado').value;
    const estado = document.getElementById('filtro-estado').value;
    const monto = document.getElementById('filtro-monto').value;
    const fecha = document.getElementById('filtro-fecha').value;

    let filtrados = todosLosCasos;

    if (categoria) {
      filtrados = filtrados.filter(caso => caso.Caso_Cat_Nombre === categoria);
    }
    if (voluntariado !== "") {
      filtrados = filtrados.filter(caso => String(caso.Caso_Voluntariado) === voluntariado);
    }
    if (estado) {
      filtrados = filtrados.filter(caso => (caso.Caso_Estado || 'Activo') === estado);
    }
    if (monto) {
      filtrados = filtrados.filter(caso => {
        const meta = parseFloat(caso.Caso_Monto_Meta);
        if (monto === "1") return meta < 1000000;
        if (monto === "2") return meta >= 1000000 && meta <= 5000000;
        if (monto === "3") return meta > 5000000;
        return true;
      });
    }
    // Ordenar por fecha
    if (fecha === "recientes") {
      filtrados = filtrados.slice().sort((a, b) => new Date(b.Caso_Fecha_Inicio) - new Date(a.Caso_Fecha_Inicio));
    } else if (fecha === "finalizar") {
      filtrados = filtrados.slice().sort((a, b) => new Date(a.Caso_Fecha_Fin) - new Date(b.Caso_Fecha_Fin));
    }

    mostrarCasos(filtrados);
  }

  // Carga inicial
  document.addEventListener("DOMContentLoaded", cargarCasos);
  </script>
</body>
</html>