<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pantry Amigo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../CSS/Revisarfund.css">
</head>
<body>

    <!-- Encabezado -->
    <header>
        <div class="logito">
            <img src="../IMG/Logo.png" alt="Pantry Amigo Logo">
            <span>Pantry Amigo</span>
        </div>
        <div class="navbar"> 
            <nav>
                <a href="index.Php" class="home-button">INICIO</a>
                <input type="search" placeholder="Buscar" class="search-bar">
                <a href="" class="help-icon">
                    <img src="IMG/Ayuda.png" alt="Ayuda">
                </a>
            </nav>
        </div>
    </header>

    <main>
        <section class="profile">
            <img src="https://fundech.org/wp-content/uploads/2020/07/donaciones.jpg" alt="Logo de la Fundación">
            <h1>Fundacion_XXXXXX</h1>
        </section>

        <section class="info">
            <div class="text">
                <h2>Misión</h2>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Vero, labore sequi dignissimos quam adipisci fugit sed nostrum voluptatum ut nobis hic quidem totam veritatis aliquid? Aliquid alias magni delectus a cum quod est, sint libero soluta explicabo ea quia modi.</p>
                <h2>Visión</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repudiandae iure quia suscipit, temporibus, veritatis, quasi nulla ea minima ducimus quaerat officiis. Dolore, autem aliquid natus molestias sit impedit distinctio, corrupti hic pariatur fugit quas ducimus illum sequi ullam, ipsa sunt.</p>
              
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const textElements = document.querySelectorAll(".text p");
        
        function checkScroll() {
            textElements.forEach((el) => {
                const position = el.getBoundingClientRect().top;
                const windowHeight = window.innerHeight;
                if (position < windowHeight - 50) {
                    el.classList.add("appear");
                }
            });
        }
        
        window.addEventListener("scroll", checkScroll);
        checkScroll();
    });
</script>
            </div>
            <div class="details">
                <p>&#128100; Nombre del responsable</p>
                <p><i class="fas fa-map-marker-alt"></i>Ubicacion</p>  
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3976.6410862157472!2d-74.10969602552719!3d4.657928342027948!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3f9b05f1cc8207%3A0xef36715854c30fe5!2sFundaci%C3%B3n%20Bolivar%20Davivienda!5e0!3m2!1sen!2sco!4v1743380473255!5m2!1sen!2sco" 
                width="400" 
                height="300" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade"></iframe>
                <button class="follow-btn">Ver</button>
            </div>
        </section>

        <section class="max-content featured_posts">
            <h2>Casos Activos</h2>
                        <div class="swiper featured_posts__content">
                    <div class="swiper-wrapper">
                                        <div class="swiper-slide featured_posts__item">
                                                    <img width="300px" src="https://www.asesoriamadridgesys.com/wp-content/uploads/Las-donaciones.jpg" alt="">
                            <h3>CASOS/XXXX</h3>
                            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quidem dignissimos dolores fugit! Repellat rem in expedita asperiores voluptate sunt quas?</p>
                            <a class="btn btn_post_destacado" href=".../HTML/registroCaso.php">Revisar</a>
                        </div>
                                        <div class="swiper-slide featured_posts__item">
                                                    <img width="300px" src="https://www.asesoriamadridgesys.com/wp-content/uploads/Las-donaciones.jpg" alt="">
                            <h3>CASOS/XXXXX</h3>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam ab repellat molestiae illum rerum nihil praesentium voluptatibus mollitia placeat corrupti?</p>
                            <a class="btn btn_post_destacado" href=".../HTML/registroCaso.php">REVISAR</a>
                        </div>
                                        <div class="swiper-slide featured_posts__item">
                                                    <img width="300px" src="https://www.asesoriamadridgesys.com/wp-content/uploads/Las-donaciones.jpg" alt="">
                            <h3>CASOS/XXXXX</h3>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias, inventore tempore ipsam earum quo consequuntur provident impedit! Odio, accusantium quaerat?</p>
                            <a class="btn btn_post_destacado" href=".../HTML/registroCaso.php">Revisar</a>
                        </div>
                                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                </section>
                                  
    </main>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-logo">
                <h2>Pantry Amigo</h2>
                <p>Conectando ayuda con quienes más la necesitan.</p>
            </div>
            <div class="footer-links">
                <h3>Enlaces</h3>
                <ul>
                    <li><a href="#">Inicio</a></li>
                    <li><a href="ConsultarCasos.php">Casos de Donación</a></li>
                    <li><a href="ConsultarFundacion.php">Fundaciones</a></li>
                    <li><a href="ConsultarVoluntario.php">Voluntariados</a></li>
                    <li><a href="#">Contacto</a></li>
                </ul>
            </div>
            <div class="footer-social">
                <h3>Síguenos</h3>
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 Pantry Amigo - Todos los derechos reservados.</p>
        </div>
    </footer>
    
    </body>
    
    </html>
