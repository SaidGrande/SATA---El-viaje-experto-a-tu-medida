<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - SATA</title>
    <link rel="stylesheet" href="../assets/css/pages/contactus.css">
</head>
<body>
    <!-- Modal de confirmación -->
    <div class="modal-overlay" id="successModal">
        <div class="modal-content">
            <div class="loading-spinner" id="loadingSpinner"></div>
            <div class="checkmark" id="checkmark"></div>
            <h3 id="modalTitle">Enviando mensaje...</h3>
            <p id="modalText">Por favor espera un momento</p>
            <button class="close-modal" id="closeModal" style="display: none;">Cerrar</button>
        </div>
    </div>

        <header>
        <div class="container">
            <nav>
                <ul>
                    <li><a href="../index.php">INICIO</a></li>
                    <li><a href="../pages/aboutus.php">NOSOTROS</a></li>
                    <li><a href="../pages/contactus.php">CONTACTO</a></li>
                    <li><a href="../pages/viajero.php">VIAJERO</a></li>
                </ul>
            </nav>
            </div>
    </header>

    <div class="contactUs">
        <div class="title">
            <h2>CONTACTANOS</h2>
        </div>
        <div class="box">
            <!-- Form -->
            <div class="contact form">
                <h3>Envia un mensaje</h3>
                <form id="contactForm">
                    <div class="formBox">
                        <div class="row50">
                            <div class="inputBox">
                                <span>Nombre</span>
                                <input type="text" name="firstname" placeholder="Marco" required>
                            </div>
                            <div class="inputBox">
                                <span>Apellido</span>
                                <input type="text" name="lastname" placeholder="Solis" required>
                            </div>
                        </div>
                        <div class="row50">
                            <div class="inputBox">
                                <span>Email</span>
                                <input type="email" name="email" placeholder="example@gmail.com" required>
                            </div>
                            <div class="inputBox">
                                <span>Celular</span>
                                <input type="tel" name="mobile" placeholder="+52 ####-####-##">
                            </div>
                        </div>
                        <div class="row100">
                            <div class="inputBox">
                                <span>Mensaje</span>
                                <textarea name="message" placeholder="Escribe tu mensaje para nosotros...." required></textarea>
                            </div>
                        </div>
                        <div class="row100">
                            <div class="inputBox">
                                <input type="submit" value="Enviar 🚀">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Info Box -->
            <div class="contact info">
                <h3>📍 Informacion de Contacto</h3>
                <div class="infoBox">
                    <div>
                        <span><ion-icon name="location"></ion-icon></span>
                        <p>SATA - Personalizador de viajes<br>Guadalajara, México 🇲🇽</p>
                    </div>
                    <div>
                        <span><ion-icon name="mail"></ion-icon></span>
                        <a href="mailto:safari@travel.com">SATA@travel.com</a>
                    </div>
                    <div>
                        <span><ion-icon name="call-outline"></ion-icon></span>
                        <a href="tel:+523331163609">+52 333 116 3609</a>
                    </div>
                </div>
                <!-- Social Media Links -->
                <ul class="sci">
                    <li><a href="https://www.instagram.com/_said_grande?igsh=MWg2Z2RjazFnZ3B5Zg==" target="_blank" title="Instagram - Said Grande">
                        <ion-icon name="logo-instagram"></ion-icon>
                    </a></li>
                    <li><a href="https://github.com/SaidGrande" target="_blank" title="GitHub - Said Grande">
                        <ion-icon name="logo-github"></ion-icon>
                    </a></li>
                    <li><a href="https://www.instagram.com/taniadiazre?igsh=MTZlMGllejZmanhzOA%3D%3D&utm_source=qr" target="_blank" title="Instagram Tania Díaz">
                        <ion-icon name="logo-instagram"></ion-icon>
                    </a></li>
                    <li><a href="https://github.com/Taniadiaz1" target="_blank" title="GitHub - Tania Díaz">
                        <ion-icon name="logo-github"></ion-icon>
                    </a></li>
                </ul>
            </div>
            
            <!-- Map -->
            <div class="map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3548.6380169939157!2d-103.3254497!3d20.654861099999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8428b23a9bbba80d%3A0xdacdb7fd592feb90!2sCentro%20Universitario%20de%20Ciencias%20Exactas%20e%20Ingenier%C3%ADas%20(CUCEI)!5e1!3m2!1ses!2smx!4v1763058078866!5m2!1ses!2smx" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    
    <script>
        // Manejo del formulario y modal
        const form = document.getElementById('contactForm');
        const modal = document.getElementById('successModal');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const checkmark = document.getElementById('checkmark');
        const modalTitle = document.getElementById('modalTitle');
        const modalText = document.getElementById('modalText');
        const closeModalBtn = document.getElementById('closeModal');

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Mostrar modal con spinner
            modal.classList.add('active');
            loadingSpinner.style.display = 'block';
            checkmark.style.display = 'none';
            modalTitle.textContent = 'Enviando mensaje...';
            modalText.textContent = 'Por favor espera un momento';
            closeModalBtn.style.display = 'none';
            
            // Simular envío (2 segundos)
            setTimeout(() => {
                // Ocultar spinner y mostrar checkmark
                loadingSpinner.style.display = 'none';
                checkmark.style.display = 'block';
                modalTitle.textContent = '¡Mensaje Enviado! ✓';
                modalText.textContent = 'Gracias por contactarnos. Te responderemos pronto 🌟';
                closeModalBtn.style.display = 'inline-block';
                
                // Resetear formulario
                form.reset();
            }, 2000);
        });

        closeModalBtn.addEventListener('click', function() {
            modal.classList.remove('active');
        });

        // Cerrar modal al hacer clic fuera
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.remove('active');
            }
        });
    </script>
    <footer>
        <div class="container1">
            <p>&copy; 2025 SATA Viajes. Todos los derechos reservados.</p>
            <ul class="footer-links">
                <li><a href="../index.php">Inicio</a></li>
                <li><a href="../pages/aboutus.php">Nosotros</a></li>
                <li><a href="../pages/contactus.php">Contacto</a></li>
                <li><a href="../pages/viajero.php">Viajero</a></li>
            </ul>
        </div>
    </footer>
</body>
</html>