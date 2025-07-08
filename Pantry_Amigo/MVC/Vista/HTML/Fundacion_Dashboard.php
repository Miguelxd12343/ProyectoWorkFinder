<?php
// Inicio de sesión y configuración de errores
ini_set('display_errors', 1); error_reporting(E_ALL); session_start();
// Validar si el usuario está logueado
if (!isset($_SESSION['Usu_Id'])) { header('Location: /Pantry_Amigo/MVC/Vista/HTML/login.php'); exit; }
// Cargar modelos y conexión
include_once '../../Modelo/ConexionBD.php';
include_once '../../Modelo/fundacionModelo.php';
// Establecer conexión y obtener datos
$conn = new ConexionBD(); $conn->abrir(); $usuarioId = $_SESSION['Usu_Id'];
$modelo = new FundacionModelo($conn); $datos = $modelo->obtenerPorUsuario($usuarioId) ?? [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Fundación</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  
  <link rel="stylesheet" href="/Pantry_Amigo/MVC/Vista/CSS/dashboard_styles.css"/>
</head>
<body>
  <div class="dashboard-container">
    <aside class="sidebar">
      <div class="logo"><img src="/Pantry_Amigo/MVC/Vista/IMG/Logo_Pantry-amigo.png" alt="Logo" class="logo-img"></div>
      
      <nav class="nav menu flex-column">
        <div class="menu-links">
            <a href="#" id="perfil-link" class="nav-link active"><i class="fas fa-user"></i> <span>Perfil</span></a>
            <a href="#" id="casos-link" class="nav-link"><i class="fas fa-folder-open"></i> <span>Casos</span></a>
            <a href="#" id="crear-caso-link" class="nav-link"><i class="fas fa-plus-circle"></i> <span>Crear Caso</span></a>
            <a href="#" id="voluntarios-link" class="nav-link"><i class="fas fa-users"></i> <span>Voluntarios</span></a>
            <a href="#" id="ayuda-link" class="nav-link"><i class="fas fa-question-circle"></i> <span>Ayuda</span></a>
        </div>
        
        <div class="w-100">
            <a href="#" id="sidebar-toggle" class="nav-link sidebar-toggle-link">
                <i class="fas fa-chevron-left"></i> <span>Ocultar</span>
            </a>
            <a href="/Pantry_Amigo/MVC/Vista/HTML/logout.php" id="cerrar-sesion-link" class="nav-link"><i class="fas fa-sign-out-alt"></i> <span>Cerrar Sesión</span></a>
        </div>
      </nav>
    </aside>

    <main class="main-content">
      <header class="header"><h2 id="titulo-seccion">Perfil</h2></header>

      <section id="perfil" class="seccion-activa">
        <div class="container-perfil">
          <div class="image-box">
            <img src="../imagenes/<?= htmlspecialchars($datos['Fund_Imagen'] ?? 'default.png') ?>" alt="Foto Fundación" id="preview">
            <label for="foto" class="custom-file-upload"><i class="fas fa-camera"></i> Seleccionar imagen</label>
            <input type="file" name="foto" id="foto" accept="image/*" onchange="loadImage(event)" form="form-perfil" style="display:none;">
          </div>
          <div class="flex-grow-1">
            <form method="POST" enctype="multipart/form-data" id="form-perfil" action="../../Controlador/guardarPerfil.php">
              <div class="row">
                <div class="col-md-6 mb-3"><label class="form-label">Nombre de la Fundación:</label><input type="text" class="form-control" name="Fund_Username" value="<?= htmlspecialchars($datos['Fund_Username'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required></div>
                <div class="col-md-6 mb-3"><label class="form-label">Correo:</label><input type="email" class="form-control" name="Fund_Correo" value="<?= htmlspecialchars($datos['Fund_Correo'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required></div>
              </div>
              <div class="row">
                  <div class="col-md-6 mb-3"><label class="form-label">Dirección:</label><input type="text" class="form-control" name="Fund_Direccion" value="<?= htmlspecialchars($datos['Fund_Direccion'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required></div>
                  <div class="col-md-6 mb-3"><label class="form-label">Teléfono:</label><input type="text" class="form-control" name="Fund_Telefono" value="<?= htmlspecialchars($datos['Fund_Telefono'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required></div>
              </div>
              <div class="mb-3"><label class="form-label">Casos Activos:</label><input type="number" class="form-control" name="Fund_Casos_Activos" value="<?= htmlspecialchars($datos['Fund_Casos_Activos'] ?? '', ENT_QUOTES, 'UTF-8') ?>" min="0" required></div>
              <div class="text-center mt-4">
                <?php if (!empty($datos)): ?>
                  <button type="submit" name="actualizar" class="btn btn-success-custom"><i class="fas fa-save"></i> Actualizar Perfil</button>
                <?php else: ?>
                  <button type="submit" name="registrar" class="btn btn-primary-custom"><i class="fas fa-plus"></i> Registrar Perfil</button>
                <?php endif; ?>
              </div>
            </form>
          </div>
        </div>
      </section>
      
      <section id="casos" class="seccion-oculta">
        <div id="lista-casos-container" class="row"></div>
      </section>

      <section id="voluntarios" class="seccion-oculta">
        <div class="search-container input-group mb-4">
            <input type="text" class="form-control" id="filtro-voluntarios" placeholder="Buscar por cédula o nombre...">
            <button class="btn btn-outline-secondary" id="btn-filtrar-voluntarios"><i class="fas fa-search"></i></button>
        </div>
        <div id="form-asignar-horario" style="display:none;">
            <h4 class="form-title">Asignar Horario</h4>
            <form id="horario-form">
                <input type="hidden" name="Hora_Vol_Cedula" id="hor-vol-cedula">
                <div class="row">
                    <div class="col-md-6 mb-3"><label class="form-label">Hora Citación:</label><input type="datetime-local" class="form-control" id="hor-citacion" name="Hora_Citacion" required></div>
                    <div class="col-md-6 mb-3"><label class="form-label">Localización:</label><input type="text" class="form-control" id="hor-localizacion" name="Hora_Localizacion" required></div>
                </div>
                <div class="text-center mt-3">
                    <button type="button" class="btn btn-secondary me-2" id="btn-cancelar-hor">Cancelar</button>
                    <button type="submit" class="btn btn-primary-custom">Guardar</button>
                </div>
            </form>
        </div>
        <div id="lista-voluntarios" class="row"></div>
      </section>
      
      <section id="ayuda" class="seccion-oculta">
          <h3><i class="fas fa-life-ring"></i> Ayuda y Soporte</h3>
          <hr>
          <div class="row mt-4">
              <div class="col-md-8">
                  <h4><i class="fas fa-question-circle"></i> Preguntas Frecuentes</h4>
                  <ul class="list-unstyled">
                      <li class="mb-3"><strong>¿Cómo creo un nuevo caso?</strong><br>Haz clic en "Crear Caso" en el menú de la izquierda. Se abrirá una ventana donde podrás llenar todos los campos del formulario.</li>
                      <li class="mb-3"><strong>¿Cómo actualizo un caso existente?</strong><br>En la sección "Casos", busca el caso que deseas modificar y haz clic en "Actualizar". Se abrirá la misma ventana, pero con los datos del caso listos para editar.</li>
                      <li class="mb-3"><strong>¿Cómo asigno horarios a voluntarios?</strong><br>En "Voluntarios", busca al voluntario y haz clic en "Asignar horario". Se desplegará un formulario para que completes la fecha, hora y ubicación.</li>
                  </ul>
              </div>
              <div class="col-md-4">
                  <h4><i class="fas fa-phone"></i> Contacto</h4>
                  <p><i class="fas fa-envelope me-2"></i>soporte@pantryamigo.org</p>
                  <p><i class="fas fa-phone me-2"></i>+57 123 456 7890</p>
              </div>
          </div>
      </section>
    </main>
  </div>

  <div class="modal fade" id="modal-caso" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal-caso-titulo"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <form id="caso-form" enctype="multipart/form-data">
            <div class="modal-body">
                <input type="hidden" name="action" id="caso-action">
                <input type="hidden" name="id" id="caso-id">
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">Nombre del Caso</label><input type="text" class="form-control" name="Caso_Nombre" required></div>
                    <div class="col-md-6"><label class="form-label">Categoría</label>
                        <select name="Caso_Cat_Id" class="form-select" required><option value="" disabled>Seleccione...</option><option value="1">Salud</option><option value="2">Educación</option><option value="3">Emergencias</option><option value="4">Alimentación</option><option value="5">Tecnología</option><option value="6">Medio Ambiente</option></select>
                    </div>
                    <div class="col-12"><label class="form-label">Descripción</label><textarea class="form-control" name="Caso_Descripcion" rows="3" required></textarea></div>
                    <div class="col-md-6"><label class="form-label">Monto Meta ($)</label><input type="number" class="form-control" name="Caso_Monto_Meta" min="0" step="0.01" required></div>
                    <div class="col-md-6"><label class="form-label" id="caso-imagen-label">Imagen del Caso</label><input type="file" class="form-control" name="Caso_Imagen" accept="image/*"></div>
                    <div class="col-md-6"><label class="form-label">Fecha de Inicio</label><input type="date" class="form-control" name="Caso_Fecha_Inicio" required></div>
                    <div class="col-md-6"><label class="form-label">Fecha de Fin</label><input type="date" class="form-control" name="Caso_Fecha_Fin" required></div>
                    <div class="col-12"><div class="form-check form-switch pt-2"><input class="form-check-input" type="checkbox" role="switch" name="Caso_Voluntariado" value="1"><label class="form-check-label">¿Requiere voluntariado?</label></div></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-custom-primary" id="btn-submit-caso"></button>
            </div>
        </form>
      </div>
    </div>
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modalCaso = new bootstrap.Modal(document.getElementById('modal-caso'));
    const casoForm = document.getElementById('caso-form');
    const secciones = { 'perfil-link': 'perfil', 'casos-link': 'casos', 'crear-caso-link': 'crear-caso-link', 'voluntarios-link': 'voluntarios', 'ayuda-link': 'ayuda' };
    let casosData = [], voluntariosData = [], horariosData = [];

    // --- NAVEGACIÓN ---
    document.querySelectorAll('.nav-link').forEach(link => {
        if (link.id === 'sidebar-toggle') return;

        link.addEventListener('click', e => {
            if (e.currentTarget.id === 'cerrar-sesion-link') {
                e.preventDefault();
                if (confirm('¿Estás seguro de que deseas cerrar la sesión?')) window.location.href = e.currentTarget.href;
                return;
            }
            e.preventDefault();
            const id = e.currentTarget.id;

            if (id === 'crear-caso-link') {
                abrirModalCaso('crear');
                return;
            }

            document.getElementById('titulo-seccion').innerText = e.currentTarget.querySelector('span').textContent.trim();
            document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
            e.currentTarget.classList.add('active');

            Object.values(secciones).forEach(secId => {
                const el = document.getElementById(secId.replace('-link', ''));
                if (el) el.classList.replace('seccion-activa', 'seccion-oculta') || el.classList.add('seccion-oculta');
            });
            const seccionActiva = document.getElementById(secciones[id]);
            if (seccionActiva) seccionActiva.classList.replace('seccion-oculta', 'seccion-activa');

            if (id === 'casos-link') cargarCasos();
            if (id === 'voluntarios-link') cargarVoluntarios();
        });
    });
    
    // --- LÓGICA DE CASOS (UNIFICADA CON MODAL) ---
    async function apiCall(url, options = {}) {
        try {
            const response = await fetch(url, options);
            if (!response.ok) throw new Error(`Error HTTP: ${response.status}`);
            return await response.json();
        } catch (error) {
            console.error('Error en API Call:', error);
            mostrarNotificacion('Error de conexión con el servidor.', 'danger');
            return null;
        }
    }

    async function cargarCasos() {
        const data = await apiCall('/Pantry_Amigo/MVC/Vista/HTML/obtener_casos_dinero.php');
        casosData = data && !data.error ? data : [];
        renderCasos(casosData);
    }
    function renderCasos(lista) {
        const container = document.getElementById('lista-casos-container');
        container.innerHTML = '';
        if (lista.length === 0) { container.innerHTML = '<div class="col-12"><div class="alert alert-info">No se encontraron casos. ¡Crea uno nuevo!</div></div>'; return; }
        
        lista.forEach(caso => {
            const progreso = caso.Caso_Monto_Meta > 0 ? (caso.Caso_Monto_Recaudado / caso.Caso_Monto_Meta * 100).toFixed(1) : 0;
            const casoElement = document.createElement('div');
            casoElement.className = 'col-lg-6 col-md-12 mb-4';
            casoElement.innerHTML = `
                <div class="caso-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <h5 class="card-title">${caso.Caso_Nombre}</h5>
                            <span class="badge bg-success">${caso.Caso_Estado}</span>
                        </div>
                        <h6 class="card-subtitle mb-2 text-muted">ID: ${caso.Caso_Id} | Categoría: ${caso.Caso_Cat_Nombre}</h6>
                        <p class="card-text mt-3">${caso.Caso_Descripcion}</p>
                        <div class="progress mb-2" style="height: 10px;">
                            <div class="progress-bar bg-success" style="width: ${progreso}%"></div>
                        </div>
                        <small class="text-muted">Recaudado: $${parseFloat(caso.Caso_Monto_Recaudado).toLocaleString()} de $${parseFloat(caso.Caso_Monto_Meta).toLocaleString()}</small>
                    </div>
                    <div class="acciones">
                        <button class="btn btn-sm btn-outline-primary btn-actualizar-caso"><i class="fas fa-edit"></i> Actualizar</button>
                        <button class="btn btn-sm btn-outline-danger btn-eliminar-caso"><i class="fas fa-trash-alt"></i> Eliminar</button>
                    </div>
                </div>`;
            casoElement.querySelector('.btn-actualizar-caso').addEventListener('click', () => abrirModalCaso('actualizar', caso.Caso_Id));
            casoElement.querySelector('.btn-eliminar-caso').addEventListener('click', () => eliminarCaso(caso.Caso_Id));
            container.appendChild(casoElement);
        });
    }
    window.abrirModalCaso = function(action, id = null) {
        casoForm.reset();
        const titulo = document.getElementById('modal-caso-titulo');
        const boton = document.getElementById('btn-submit-caso');
        const actionInput = document.getElementById('caso-action');
        const idInput = document.getElementById('caso-id');
        const imagenLabel = document.getElementById('caso-imagen-label');

        if (action === 'crear') {
            titulo.innerText = 'Crear Nuevo Caso';
            boton.innerHTML = '<i class="fas fa-plus-circle"></i> Crear Caso';
            actionInput.value = 'crear';
            idInput.value = '';
            imagenLabel.innerText = 'Imagen del Caso';
            casoForm.querySelector('input[name="Caso_Imagen"]').required = false;
        } else if (action === 'actualizar') {
            const caso = casosData.find(c => c.Caso_Id == id);
            if (!caso) { mostrarNotificacion('Caso no encontrado', 'danger'); return; }
            titulo.innerText = 'Actualizar Caso';
            boton.innerHTML = '<i class="fas fa-save"></i> Guardar Cambios';
            actionInput.value = 'actualizar';
            idInput.value = caso.Caso_Id;
            imagenLabel.innerText = 'Cambiar Imagen (Opcional)';
            casoForm.querySelector('input[name="Caso_Imagen"]').required = false;
            
            for (const key in caso) {
                const input = casoForm.querySelector(`[name="${key}"]`);
                if(input) {
                    if(input.type === 'checkbox') input.checked = (caso[key] == 1);
                    else input.value = caso[key];
                }
            }
        }
        modalCaso.show();
    };
    casoForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        const data = await apiCall('/Pantry_Amigo/MVC/Vista/HTML/manejador_casos.php', new FormData(this));
        if (data && data.success) {
            mostrarNotificacion(data.message, 'success');
            modalCaso.hide();
            cargarCasos();
        } else {
            mostrarNotificacion(data ? data.message : 'Error desconocido', 'danger');
        }
    });
    window.eliminarCaso = async function(id) {
        if (!confirm('¿Seguro que deseas eliminar este caso?')) return;
        const data = await apiCall(`/Pantry_Amigo/MVC/Vista/HTML/manejador_casos.php?action=eliminar&id=${id}`, { method: 'GET' });
        if (data && data.success) {
            mostrarNotificacion(data.message, 'success');
            cargarCasos();
        } else {
            mostrarNotificacion(data ? data.message : 'Error al eliminar.', 'danger');
        }
    };
    
    // --- LÓGICA DE VOLUNTARIOS (RESTAURADA) ---
    async function cargarVoluntarios() {
        const [vols, horas] = await Promise.all([
            apiCall('/Pantry_Amigo/MVC/Vista/HTML/obtener_voluntarios.php'),
            apiCall('/Pantry_Amigo/MVC/Vista/HTML/obtener_horarios_voluntarios.php')
        ]);
        voluntariosData = vols && !vols.error ? vols : [];
        horariosData = horas && !horas.error ? horas : [];
        renderVoluntarios(voluntariosData);
    }
    function renderVoluntarios(lista) {
        const cont = document.getElementById('lista-voluntarios');
        cont.innerHTML = '';
        if (lista.length === 0) { cont.innerHTML = '<div class="alert alert-info">No hay voluntarios registrados.</div>'; return; }
        lista.forEach(v => {
            const d = document.createElement('div');
            d.className = 'col-md-6 mb-4';
            let horariosHtml = '';
            const hs = horariosData.filter(h => h.Hora_Vol_Cedula === v.Vol_Cedula);
            if (hs.length) {
                horariosHtml = '<div class="horarios mt-3"><strong>Horarios Asignados:</strong><ul class="list-unstyled mt-2">';
                hs.forEach(h => horariosHtml += `<li><small>${h.Hora_Citacion} en ${h.Hora_Localizacion}</small></li>`);
                horariosHtml += '</ul></div>';
            }
            d.innerHTML = `<div class="voluntario h-100"><h4>${v.Vol_Nombre} ${v.Vol_Apellido}</h4><p class="text-muted">Cédula: ${v.Vol_Cedula}</p><p>Correo: ${v.Vol_Correo}</p>${horariosHtml}<div class="acciones mt-3"><button class="btn btn-sm btn-outline-danger btn-eliminar-vol">Eliminar</button><button class="btn btn-sm btn-primary-custom btn-asignar-horario">Asignar Horario</button></div></div>`;
            d.querySelector('.btn-eliminar-vol').addEventListener('click', () => eliminarVol(v.Vol_Cedula));
            d.querySelector('.btn-asignar-horario').addEventListener('click', () => openAsignar(v.Vol_Cedula));
            cont.appendChild(d);
        });
    }
    async function eliminarVol(ced) {
        if (!confirm('¿Seguro que deseas eliminar a este voluntario?')) return;
        const data = await apiCall(`/Pantry_Amigo/MVC/Vista/HTML/eliminar_voluntario.php?cedula=${ced}`);
        if(data && data.success) { mostrarNotificacion('Voluntario eliminado.', 'success'); cargarVoluntarios(); }
        else { mostrarNotificacion(data.message, 'error'); }
    }
    const formHorarioContainer = document.getElementById('form-asignar-horario');
    const formHorario = document.getElementById('horario-form');
    function openAsignar(ced) { formHorarioContainer.style.display = 'block'; document.getElementById('hor-vol-cedula').value = ced; }
    document.getElementById('btn-cancelar-hor').addEventListener('click', () => formHorarioContainer.style.display = 'none');
    formHorario.addEventListener('submit', async function(e) {
        e.preventDefault();
        const data = await apiCall('/Pantry_Amigo/MVC/Vista/HTML/add_horario_voluntario.php', { method: 'POST', body: new FormData(this) });
        if (data && data.success) { mostrarNotificacion('Horario asignado.', 'success'); formHorarioContainer.style.display = 'none'; this.reset(); cargarVoluntarios(); }
        else { mostrarNotificacion(data.message, 'error'); }
    });

    // --- LÓGICA PARA EL SIDEBAR COLAPSABLE ---
    const sidebar = document.querySelector('.sidebar');
    const sidebarToggle = document.getElementById('sidebar-toggle');
    sidebarToggle.addEventListener('click', (e) => {
        e.preventDefault();
        sidebar.classList.toggle('collapsed');
        
        const icon = sidebarToggle.querySelector('i');
        const text = sidebarToggle.querySelector('span');

        if (sidebar.classList.contains('collapsed')) {
            icon.classList.remove('fa-chevron-left');
            icon.classList.add('fa-chevron-right');
            text.textContent = '';
        } else {
            icon.classList.remove('fa-chevron-right');
            icon.classList.add('fa-chevron-left');
            text.textContent = 'Ocultar';
        }
    });

    // --- UTILIDADES ---
    function mostrarNotificacion(mensaje, type = 'success') {
        const alertContainer = document.createElement('div');
        alertContainer.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
        alertContainer.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 1055;';
        alertContainer.innerHTML = `<strong>${type === 'success' ? 'Éxito' : 'Error'}:</strong> ${mensaje}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
        document.body.appendChild(alertContainer);
        setTimeout(() => bootstrap.Alert.getOrCreateInstance(alertContainer).close(), 5000);
    }
    function loadImage(event) { document.getElementById('preview').src = URL.createObjectURL(event.target.files[0]); }
    
    // --- CARGA INICIAL ---
    document.getElementById('perfil-link').click();
});
</script>
</body>
</html>