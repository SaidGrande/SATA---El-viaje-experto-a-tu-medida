<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SATA - Tipos de Viajero</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Montserrat:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/pages/viajero.css">
</head>
<body>

    <!-- FONDO ROTANTE -->
    <div id="fondo-rotante">
        <div class="fondo capa-a"></div>
        <div class="fondo capa-b"></div>
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

    <main>
        
        <section class="viajero-section">
            <div class="container">
                <h2>Descubre tu Perfil de Viajero</h2>
                <p class="subtitle">Cada aventura es única. Encuentra la que resuena contigo.</p>

                <div class="viajero-grid">
                    
                    <div class="viajero-card">
                        <img src="../assets/images/index/QP/cultural.jpeg" alt="El Viajero Cultural">
                    </div>

                    <div class="viajero-card">
                        <img src="../assets/images/index/QP/extremo.jpeg" alt="El Aventurero Extremo">
                    </div>

                    <div class="viajero-card">
                        <img src="../assets/images/index/QP/naturista.jpeg" alt="El Viajero Naturista">
                    </div>

                    <div class="viajero-card">
                        <img src="../assets/images/index/QP/tranquilo.jpeg" alt="El Viajero Tranquilo">
                    </div>

                </div>
            </div>
        </section>

    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 SATA Viajes. Todos los derechos reservados.</p>
            <ul class="footer-links">
                <li><a href="../index.php">Inicio</a></li>
                <li><a href="../pages/aboutus.php">Nosotros</a></li>
                <li><a href="../pages/contactus.php">Contacto</a></li>
                <li><a href="../pages/viajero.php">Viajero</a></li>
            </ul>
        </div>
    </footer>

    <script>
const imagenes = [
    "../assets/images/index/fondo/hermoso-paisaje-de-un-rio-rodeado-de-vegetacion-en-un-bosque.jpg",
    "../assets/images/index/fondo/hermosa-isla-paradisiaca-con-playa-y-mar.jpg",
    "../assets/images/index/fondo/turista-tomando-en-el-glaciar-skaftafell-parque-nacional-vatnajokull-en-islandia.jpg",
    "../assets/images/index/fondo/hermoso-tiro-horizontal-del-sol-naciente-y-altas-montanas-rocosas-bajo-el-cielo-nublado.jpg"
];

let indice = 0;

const capaA = document.querySelector(".capa-a");
const capaB = document.querySelector(".capa-b");

capaA.style.backgroundImage = `url('${imagenes[0]}')`;

function cambiarFondo() {
    indice = (indice + 1) % imagenes.length;

    // Imagen siguiente en capa B
    capaB.style.backgroundImage = `url('${imagenes[indice]}')`;

    // Fade-in de B
    capaB.style.opacity = 1;
    capaB.style.transform = "scale(1.08)";

    // Después del fade, actualizamos A
    setTimeout(() => {
        capaA.style.backgroundImage = capaB.style.backgroundImage;
        capaB.style.opacity = 0;
        capaB.style.transform = "scale(1)";
    }, 2000); // tiempo del fade
}

setInterval(cambiarFondo, 7000);
</script>
</body>
</html>
