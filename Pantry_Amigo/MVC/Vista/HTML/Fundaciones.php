<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <title>Fundaciones registradas</title>

  <!-- primero las bases de tu sitio, luego los ajustes específicos -->
  <link rel="stylesheet" href="../CSS/estiloFundaciones.css" />
  <link rel="stylesheet" href="../CSS/estilosIndex.css">
</head>

<body>


  <main class="container">
    <!-- TÍTULO -->
    <h1>Fundaciones registradas</h1>

    <!-- GRID donde se insertan las tarjetas -->
    <div id="fundaciones-container">
      <p>Cargando fundaciones…</p>
    </div>



    <!-- JS: pinta cada tarjeta -->
    <script>
      document.addEventListener('DOMContentLoaded', () => {
        fetch('../../Modelo/ObtenerFundaciones.php')
          .then(r => r.json())
          .then(data => {
            const cont = document.getElementById('fundaciones-container');
            cont.innerHTML = '';

            if (!Array.isArray(data) || data.length === 0) {
              cont.innerHTML = '<p>No hay fundaciones registradas.</p>';
              return;
            }

            data.forEach(f => {
              const card = document.createElement('article');
              card.className = 'fundacion-card'; // coincide con el CSS
              card.innerHTML = `
              <div class="fundacion-info">
                <h4>${f.Usu_Username}</h4>
                <p><strong>Correo:</strong> ${f.Usu_Correo}</p>
                <p><strong>ID:</strong> ${f.Usu_Id}</p>
                <a class="ver-mas-btn" href="DetalleFundacion.php?id=${f.Usu_Id}">
                  Ver más
                </a>
              </div>`;
              cont.appendChild(card);
            });
          })
          .catch(err => {
            console.error('Error al cargar fundaciones:', err);
            document.getElementById('fundaciones-container').innerHTML =
              '<p>Error al cargar los datos.</p>';
          });
      });
    </script>
  </main>
</body>

</html>