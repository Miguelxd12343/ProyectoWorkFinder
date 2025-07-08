<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Fundación</title>
    <link rel="stylesheet" href="/Pantry_Amigo/MVC/Vista/CSS/estiloDashboard.css">
    <style>
        /* Estilos para el botón de descarga */
        .download-report-button {
            background-color: #007bff; /* Un color azul */
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            margin-right: 10px;
            font-size: 16px;
        }

        .download-report-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="dashboard">
        <aside class="sidebar">
            <div class="logo">
                <img src="/Pantry_Amigo/MVC/Vista/IMG/Logo_Pantry-amigo.png" alt="Logo de la empresa"
                    class="logo-img">
            </div>
            <nav class="menu">
                <ul>
                    <li><a href="../../../MVC/Vista/HTML/perfilFundacion.php" id="perfil-link">Perfil</a></li>

                    <li class="has-submenu">
                        <a href="#" id="casos-link" class="active">Casos</a>
                        <ul class="submenu">
                            <li><a href="#" id="casos-activos-link">Activos</a></li>
                            <li><a href="#" id="casos-inactivos-link">Inactivos</a></li>
                            <li><a href="#" id="crear-caso-link">Crear casos</a></li>
                        </ul>
                    </li>

                    <li><a href="#" id="voluntarios-link">Voluntarios</a></li>
                    <li><a href="#" id="donaciones-link">Donaciones</a></li>
                    <li><a href="#" id="consultar-link">Consultar</a></li>
                    <li><a href="#" id="ayuda-link">Ayuda</a></li>
                    <li><a href="#" id="salir-link">Salir</a></li>
                </ul>
            </nav>
        </aside>

        <main class="content">
            <header class="header">
                <h2 id="titulo-seccion">Casos</h2>
            </header>

            <section id="casos" class="seccion-activa">

                <div class="search-bar">
                    <input type="text" id="filtro-id" placeholder="Ingrese el ID del caso">
                    <button id="btn-filtrar">Filtrar</button>
                </div>

                <button class="download-report-button" id="descargar-informe-button">Descargar Informe</button>

                <div class="cases" id="lista-casos">
                    </div>

                <div class="activos">

                </div>

                <section class="assigned-schedules">
                    </section>
            </section>
            <section id="voluntarios" class="seccion-oculta">
                <h3>Lista de Voluntarios</h3>
                <div class="search-bar">
                    <input type="text" id="filtro-voluntario-cedula" placeholder="Ingrese la Cédula del voluntario">
                    <button id="btn-filtrar-voluntario">Filtrar</button>
                </div>
                <div id="lista-voluntarios">
                    </div>
                <button id="agregar-voluntario-button"
                    onclick="window.location.href='RegistrarVoluntario.php'">Agregar Voluntario</button>
            </section>

            <section id="ayuda" class="seccion-oculta">
                <h3>Ayuda</h3>
                <div class="faq">
                    <h4>Preguntas Frecuentes</h4>
                    <div class="pregunta">
                        <p><strong>¿Cómo puedo agregar un nuevo caso?</strong></p>
                        <p>Para agregar un nuevo caso, haz clic en el botón "Nuevo caso de donación" en la sección de
                            Casos.</p>
                    </div>
                    <div class="pregunta">
                        <p><strong>¿Cómo gestiono a los voluntarios?</strong></p>
                        <p>En la sección de Voluntarios, puedes ver la lista de voluntarios y agregar nuevos.</p>
                    </div>
                    <div class="pregunta">
                        <p><strong>¿Qué hago si tengo un problema técnico?</strong></p>
                        <p>Contacta al soporte técnico a través del correo: soporte@fundacion.com.</p>
                    </div>
                </div>
                <div class="contacto-soporte">
                    <h4>Contactar al Soporte</h4>
                    <p>Si necesitas ayuda adicional, no dudes en contactarnos:</p>
                    <ul>
                        <li><strong>Email:</strong> soporte@fundacion.com</li>
                        <li><strong>Teléfono:</strong> +123 456 7890</li>
                    </ul>
                </div>
            </section>
        </main>
    </div>

    <div id="modal-actualizar-caso" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Actualizar Caso</h3>
            <form id="form-actualizar-caso">
                <input type="hidden" id="caso-id" name="caso_id">
                <div class="form-group">
                    <label for="caso-nombre">Nombre del Caso:</label>
                    <input type="text" id="caso-nombre" name="caso_nombre" required>
                </div>
                <div class="form-group">
                    <label for="caso-descripcion">Descripción:</label>
                    <textarea id="caso-descripcion" name="caso_descripcion" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="caso-estado">Estado:</label>
                    <select id="caso-estado" name="caso_estado" required>
                        <option value="Pendiente">Activo</option>
                        <option value="Cancelado">Inactivo</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="caso-fecha-inicio">Fecha de inicio:</label>
                    <input type="date" id="caso-fecha-inicio" name="caso_fecha_inicio" required>
                </div>
                <div class="form-group">
                    <label for="caso-fecha-fin">Fecha de fin:</label>
                    <input type="date" id="caso-fecha-fin" name="caso_fecha_fin" required>
                </div>
                <div class="form-buttons">
                    <button type="button" id="cancelar-actualizacion">Cancelar</button>
                    <button type="submit" class="actualizar-caso">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        // Seleccionar elementos del DOM
        const perfilLink = document.getElementById('perfil-link');
        const casosLink = document.getElementById('casos-link');
        const voluntariosLink = document.getElementById('voluntarios-link');
        const ayudaLink = document.getElementById('ayuda-link');
        const salirLink = document.getElementById('salir-link');

        const casosSection = document.getElementById('casos');
        const voluntariosSection = document.getElementById('voluntarios');
        const ayudaSection = document.getElementById('ayuda');
        const tituloSeccion = document.getElementById('titulo-seccion');
        const listaCasos = document.getElementById('lista-casos');
        const listaVoluntarios = document.getElementById('lista-voluntarios');
        const filtroInput = document.getElementById('filtro-id');
        const btnFiltrar = document.getElementById('btn-filtrar');
        const filtroVoluntarioInput = document.getElementById('filtro-voluntario-cedula');
        const btnFiltrarVoluntario = document.getElementById('btn-filtrar-voluntario');
        const descargarInformeBtn = document.getElementById('descargar-informe-button'); // Nuevo botón

        // Modal y formulario de actualización
        const modalActualizarCaso = document.getElementById('modal-actualizar-caso');
        const formActualizarCaso = document.getElementById('form-actualizar-caso');
        const closeModal = document.querySelector('.close');
        const btnCancelarActualizacion = document.getElementById('cancelar-actualizacion');

        let casosData = []; // Variable para almacenar los casos cargados
        let voluntariosData = []; // Variable para almacenar los voluntarios cargados

        // Función para cargar casos desde PHP
        function cargarCasos() {
            fetch('/Pantry_Amigo/MVC/Vista/HTML/obtener_casos.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Error en la solicitud: ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        listaCasos.innerHTML = `<p>Error: ${data.error}</p>`;
                        return;
                    }
                    casosData = data; // Almacenar la data original
                    mostrarCasos(casosData);
                })
                .catch(error => {
                    console.error('Error al cargar los casos:', error);
                    listaCasos.innerHTML = `<p>Error al cargar los casos: ${error.message}</p>`;
                });
        } 

        // Función para mostrar casos en la interfaz
        function mostrarCasos(casos) {
    listaCasos.innerHTML = ''; // Limpiar el contenedor

    casos.forEach(caso => {
        // Construimos correctamente el template literal con ${…}
        const casoHTML = `
            <div class="case" id="caso-${caso.Caso_Id}" data-id="${caso.Caso_Id}">
                <h3>${caso.Caso_Nombre_Caso}</h3>
                <p><strong>${caso.Caso_Descripcion}</strong></p>
                <p>ID: ${caso.Caso_Id}</p>
                <p>Estado: ${caso.Caso_Estado}</p>
                <p>Fecha de inicio: ${caso.Caso_Fecha_Inicio}</p>
                <p>Fecha de fin: ${caso.Caso_Fecha_Fin}</p>
                <div>
                    <button class="actualizar-caso-btn" data-caso-id="${caso.Caso_Id}">Actualizar caso</button>
                    <button class="eliminar-caso" data-caso-id="${caso.Caso_Id}">Eliminar caso</button>
                </div>
            </div>
        `;
        listaCasos.insertAdjacentHTML('beforeend', casoHTML);
    });

            // Añadir event listeners para los botones de eliminar
            document.querySelectorAll('.eliminar-caso').forEach(button => {
                button.addEventListener('click', function () {
                    const casoId = this.getAttribute('data-caso-id');
                    if (confirm("¿Estás seguro de eliminar este caso?")) {
                        eliminarCaso(casoId);
                    }
                });
            });

            // Añadir event listeners para los botones de actualizar
            document.querySelectorAll('.actualizar-caso-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const casoId = this.getAttribute('data-caso-id');
                    abrirModalActualizarCaso(casoId);
                });
            });
        }

        // Función para abrir el modal de actualización y cargar los datos del caso
        function abrirModalActualizarCaso(casoId) {
            // Buscar el caso por ID
            const caso = casosData.find(caso => caso.Caso_Id == casoId);
            if (caso) {
                // Completar el formulario con los datos del caso
                document.getElementById('caso-id').value = caso.Caso_Id;
                document.getElementById('caso-nombre').value = caso.Caso_Nombre_Caso;
                document.getElementById('caso-descripcion').value = caso.Caso_Descripcion;
                document.getElementById('caso-estado').value = caso.Caso_Estado;
                document.getElementById('caso-fecha-inicio').value = formatearFechaParaInput(caso.Caso_Fecha_Inicio);
                document.getElementById('caso-fecha-fin').value = formatearFechaParaInput(caso.Caso_Fecha_Fin);

                // Mostrar el modal
                modalActualizarCaso.style.display = 'block';
            } else {
                alert("No se encontró el caso especificado.");
            }
        }

        // Función para formatear la fecha al formato requerido por input[type="date"]
        function formatearFechaParaInput(fechaStr) {
            if (!fechaStr) return '';

            // Si la fecha ya está en formato<ctrl98>-MM-DD, no necesita conversión
            if (/^\d{4}-\d{2}-\d{2}$/.test(fechaStr)) {
                return fechaStr;
            }

            // Convertir de formato DD/MM/YYYY a<ctrl98>-MM-DD
            const partes = fechaStr.split('/');
            if (partes.length === 3) {
                return `<span class="math-inline">\{partes\[2\]\}\-</span>{partes[1].padStart(2, '0')}-${partes[0].padStart(2, '0')}`;
            }

            // Si el formato es diferente, intentar con Date
            try {
                const fecha = new Date(fechaStr);
                return fecha.toISOString().split('T')[0];
            } catch (e) {
                console.error("Error al formatear fecha:", e);
                return '';
            }
        }

        // Función para filtrar los casos por ID
        function filtrarCasosPorID() {
            const filtro = filtroInput.value.trim();
            if (filtro === '') {
                mostrarCasos(casosData);
                return;
            }
            const casosFiltrados = casosData.filter(caso => String(caso.Caso_Id) === filtro);
            mostrarCasos(casosFiltrados);
        }

        // Función para eliminar un caso
        function eliminarCaso(casoId) {
            fetch(`/Pantry_Amigo/MVC/Vista/HTML/eliminar_caso.php?caso_id=${encodeURIComponent(casoId)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remover el caso del DOM
                        const casoElemento = document.getElementById('caso-' + casoId);
                        if (casoElemento) {
                            casoElemento.remove();
                        }
                        // También eliminar de la matriz de datos
                        casosData = casosData.filter(caso => caso.Caso_Id != casoId);
                        alert(data.message);
                    } else {
                        alert("Error: " + data.message);
                    }
                })
                .catch(error => {
                    console.error("Error al eliminar el caso:", error);
                    alert("Ocurrió un error al eliminar el caso.");
                });
        }

        // Función para actualizar un caso
        function actualizarCaso(formData) {
            fetch('/Pantry_Amigo/MVC/Vista/HTML/actualizar_caso.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        // Actualizar la vista
                        cerrarModalActualizarCaso();
                        cargarCasos(); // Recargar todos los casos para reflejar los cambios
                    } else {
                        alert("Error: " + data.message);
                    }
                })
                .catch(error => {
                    console.error("Error al actualizar el caso:", error);
                    alert("Ocurrió un error al actualizar el caso.");
                });
        }

        // Event listener para el formulario de actualización
        formActualizarCaso.addEventListener('submit', function (event) {
            event.preventDefault();
            const formData = new FormData(formActualizarCaso);
            actualizarCaso(formData);
        });

        // Función para cerrar el modal
        function cerrarModalActualizarCaso() {
            modalActualizarCaso.style.display = 'none';
            formActualizarCaso.reset();
        }

        // Event listeners para cerrar el modal
        closeModal.addEventListener('click', cerrarModalActualizarCaso);
        btnCancelarActualizacion.addEventListener('click', cerrarModalActualizarCaso);
        window.addEventListener('click', function (event) {
            if (event.target === modalActualizarCaso) {
                cerrarModalActualizarCaso();
            }
        });

        // Función para mostrar la sección de casos
        function mostrarCasosSeccion() {
            casosSection.classList.remove('seccion-oculta');
            casosSection.classList.add('seccion-activa');
            voluntariosSection.classList.remove('seccion-activa');
            voluntariosSection.classList.add('seccion-oculta');
            ayudaSection.classList.remove('seccion-activa');
            ayudaSection.classList.add('seccion-oculta');
            tituloSeccion.textContent = 'Casos';
            cargarCasos();
            resaltarOpcion(casosLink);
        }

        // Función para mostrar la sección de voluntarios
        function mostrarVoluntarios() {
            voluntariosSection.classList.remove('seccion-oculta');
            voluntariosSection.classList.add('seccion-activa');
            casosSection.classList.remove('seccion-activa');
            casosSection.classList.add('seccion-oculta');
            ayudaSection.classList.remove('seccion-activa');
            ayudaSection.classList.add('seccion-oculta');
            tituloSeccion.textContent = 'Voluntarios';
            cargarVoluntarios();
            resaltarOpcion(voluntariosLink);
        }

        // Función para mostrar la sección de ayuda
        function mostrarAyuda() {
            ayudaSection.classList.remove('seccion-oculta');
            ayudaSection.classList.add('seccion-activa');
            casosSection.classList.remove('seccion-activa');
            casosSection.classList.add('seccion-oculta');
            voluntariosSection.classList.remove('seccion-activa');
            voluntariosSection.classList.add('seccion-oculta');
            tituloSeccion.textContent = 'Ayuda';
            resaltarOpcion(ayudaLink);
        }

        // Función para resaltar la opción seleccionada
        function resaltarOpcion(link) {
            const menuLinks = [perfilLink, casosLink, voluntariosLink, ayudaLink, salirLink];
            menuLinks.forEach(menuLink => menuLink.classList.remove('active'));
            link.classList.add('active');
        }

        // Event listener para el botón de filtrar casos
        btnFiltrar.addEventListener('click', filtrarCasosPorID);

        // Event listeners para navegación
        perfilLink.addEventListener('click', () => {
            mostrarCasosSeccion();
            resaltarOpcion(perfilLink);
        });
        casosLink.addEventListener('click', mostrarCasosSeccion);
        voluntariosLink.addEventListener('click', mostrarVoluntarios);
        ayudaLink.addEventListener('click', mostrarAyuda);
        salirLink.addEventListener('click', () => {
            alert('Cerrando sesión...');
            // Lógica para cerrar sesión
        });

        // Función para cargar voluntarios desde PHP
        function cargarVoluntarios() {
            fetch('/Pantry_Amigo/MVC/Vista/HTML/obtener_voluntarios.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Error en la solicitud: ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        listaVoluntarios.innerHTML = `<p>Error: ${data.error}</p>`;
                        return;
                    }
                    voluntariosData = data; // Almacenar la data original
                    mostrarVoluntariosLista(voluntariosData);
                })
                .catch(error => {
                    listaVoluntarios.innerHTML = `<p>Error al cargar los voluntarios: ${error.message}</p>`;
                });
        }

        // Función para mostrar la lista de voluntarios
        function mostrarVoluntariosLista(voluntarios) {
            listaVoluntarios.innerHTML = ''; // Limpiar el contenedor
            voluntarios.forEach(voluntario => {
                const voluntarioHTML = `
                    <div class="voluntario">
                        <p><strong>${voluntario.Vol_Nombre} ${voluntario.Vol_Apellido}</strong></p>
                        <p>Cédula: ${voluntario.Vol_Cedula}</p>
                        <p>Correo: ${voluntario.Vol_Correo}</p>
                        <p>Celular: ${voluntario.Vol_Celular}</p>
                        <p>Caso asignado: ${voluntario.Vol_Caso_Id}</p>
                        <button id="asignar-Horario-button" onclick="window.location.href='RegistrarHorario.php?cedula=${voluntario.Vol_Cedula}'">Asignar horario</button>
                    </div>
                `;
                listaVoluntarios.insertAdjacentHTML('beforeend', voluntarioHTML);
            });
        }

        // Función para filtrar voluntarios por cédula
        function filtrarVoluntariosPorCedula() {
            const filtro = filtroVoluntarioInput.value.trim();
            if (filtro === '') {
                mostrarVoluntariosLista(voluntariosData);
                return;
            }

            const voluntariosFiltrados = voluntariosData.filter(voluntario =>
                String(voluntario.Vol_Cedula).includes(filtro)
            );

            mostrarVoluntariosLista(voluntariosFiltrados);
        }

        // Event listener para el botón de filtrar voluntarios
        btnFiltrarVoluntario.addEventListener('click', filtrarVoluntariosPorCedula);

        function descargarInformeCasos() {
            if (casosData.length === 0) {
                alert("No hay casos para descargar.");
                return;
            }

            // Crear un nuevo documento jsPDF
            const pdf = new jspdf.jsPDF();

            // Definir márgenes y espaciado
            const margin = 10;
            let yPosition = margin + 10;
            const lineHeight = 7;
            const pageWidth = pdf.internal.pageSize.getWidth() - 2 * margin;
            const columnWidths = [15, 40, 60, 20, 25, 25]; // Ancho aproximado de las columnas

            // Encabezados de la tabla
            const headers = ["ID", "Nombre", "Descripción", "Estado", "Inicio", "Fin"];
            pdf.setFontSize(10);
            let xPosition = margin;
            headers.forEach((header, index) => {
                pdf.text(header, xPosition, yPosition);
                xPosition += columnWidths[index];
            });
            yPosition += lineHeight + 2;
            pdf.line(margin, yPosition - 3, pageWidth + margin, yPosition - 3); // Línea separadora

            // Datos de los casos
            pdf.setFontSize(9);
            casosData.forEach(caso => {
                xPosition = margin;
                const rowData = [
                    caso.Caso_Id,
                    caso.Caso_Nombre_Caso,
                    caso.Caso_Descripcion,
                    caso.Caso_Estado,
                    caso.Caso_Fecha_Inicio,
                    caso.Caso_Fecha_Fin
                ];

                // Ajustar para texto largo en la descripción
                const descriptionLines = pdf.splitTextToSize(caso.Caso_Descripcion, columnWidths[2] - 5);
                const rowHeight = Math.max(lineHeight * (descriptionLines.length || 1), lineHeight);

                // Verificar si la fila se desborda de la página
                if (yPosition + rowHeight + margin > pdf.internal.pageSize.getHeight()) {
                    pdf.addPage();
                    yPosition = margin + 10;
                    // Volver a imprimir los encabezados en la nueva página
                    pdf.setFontSize(10);
                    xPosition = margin;
                    headers.forEach((header, index) => {
                        pdf.text(header, xPosition, yPosition);
                        xPosition += columnWidths[index];
                    });
                    yPosition += lineHeight + 2;
                    pdf.line(margin, yPosition - 3, pageWidth + margin, yPosition - 3);
                    pdf.setFontSize(9);
                }

                pdf.text(String(rowData[0]), xPosition, yPosition);
                xPosition += columnWidths[0];
                pdf.text(rowData[1], xPosition, yPosition);
                xPosition += columnWidths[1];
                descriptionLines.forEach((line, index) => {
                    pdf.text(line, xPosition, yPosition + index * lineHeight);
                });
                xPosition += columnWidths[2];
                pdf.text(rowData[3], xPosition, yPosition);
                xPosition += columnWidths[3];
                pdf.text(rowData[4], xPosition, yPosition);
                xPosition += columnWidths[4];
                pdf.text(rowData[5], xPosition, yPosition);

                yPosition += rowHeight + 2;
                pdf.line(margin, yPosition - 2, pageWidth + margin, yPosition - 2); // Línea separadora de fila
            });

            // Guardar el PDF y forzar la descarga
            pdf.save('informe_casos.pdf');
        }

        // Event listener para el botón de descarga de informe
        if (descargarInformeBtn) {
            descargarInformeBtn.addEventListener('click', descargarInformeCasos);
        }

        // Mostrar la sección de casos por defecto
        mostrarCasosSeccion();
    </script>
</body>
</html>