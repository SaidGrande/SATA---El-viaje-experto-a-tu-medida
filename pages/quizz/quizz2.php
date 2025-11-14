<?php
session_start();

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['datos_viaje'] = $_POST;
    
    // Crear archivo de hechos para Prolog con los datos prácticos
    $hechos = "% Datos prácticos del viaje\n";
    $hechos .= "presupuesto('" . $_POST['presupuesto'] . "').\n";
    $hechos .= "duracion('" . $_POST['duracion'] . "').\n";
    $hechos .= "temporada('" . $_POST['temporada'] . "').\n";
    $hechos .= "experiencia('" . $_POST['experiencia'] . "').\n";
    $hechos .= "prioridad('" . $_POST['prioridad'] . "').\n";
    
    // RUTA CORREGIDA - Desde pages/quizz/ hacia src/php/
    $dir_php = __DIR__ . '/../../src/php';
    if (!is_dir($dir_php)) {
        mkdir($dir_php, 0777, true);
    }
    
    file_put_contents($dir_php . '/datos_practicos.pl', $hechos);
    
    // Redirigir a quizz3
    header('Location: quizz3.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SATA - Planifica tu Viaje Ideal</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../assets/css/quizz/quizz2.css">
</head>
<body>
    <div class="particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>
    
    <header id="header">
        <div class="container">
            <nav>
                <ul>
                    <li><a href="../../index.php">Inicio</a></li>
                    <li><a href="../aboutus.php">Nosotros</a></li>
                    <li><a href="../contactus.php">Contacto</a></li>
                    <li><a href="../viajero.php">Viajero</a></li>
                </ul>
            </nav>
        </div>
    </header>
    
    <main class="main-content">
        <div class="container">
            <div class="quiz-header">
                <div class="step-indicator"><i class="fa-solid fa-plane"></i> Paso 2 de 3</div>
                <h1>Planifica tu Viaje Ideal</h1>
                <div class="divider"></div>
                <p>Cuéntanos los detalles prácticos de tu próxima aventura</p>
            </div>
            
            <div class="progress-container">
                <div class="progress-steps">
                    <div class="step completed">1</div>
                    <div class="step active">2</div>
                    <div class="step">3</div>
                </div>
                <div class="step-labels">
                    <div class="step-label">Perfil de Viajero</div>
                    <div class="step-label active">Datos del Viaje</div>
                    <div class="step-label">Recomendaciones</div>
                </div>
            </div>
            
            <form method="POST" class="quiz-form" id="quizForm">
                <div class="question-group">
                    <h3><span class="icon"><i class="fa-solid fa-wallet"></i></span> ¿Cuál es tu presupuesto aproximado?</h3>
                    <p class="description">Esto nos ayudará a recomendarte destinos y experiencias acordes a tus posibilidades</p>
                    <div class="options-grid">
                        <div class="option-card">
                            <input type="radio" id="presupuesto_bajo" name="presupuesto" value="economico" required>
                            <label for="presupuesto_bajo">
                                <div class="icon">
                                    <img src="../../assets/images/QuizzIcons/ninero.png" alt="Económico" class="icon-img">
                                </div>
                                <div class="title">Económico</div>
                                <div class="subtitle">Menos de $1,000 USD</div>
                            </label>
                        </div>
                        <div class="option-card">
                            <input type="radio" id="presupuesto_medio" name="presupuesto" value="moderado">
                            <label for="presupuesto_medio">
                                <div class="icon"><i class="fa-solid fa-hotel"></i></div>
                                <div class="title">Moderado</div>
                                <div class="subtitle">$1,000 - $3,000 USD</div>
                            </label>
                        </div>
                        <div class="option-card">
                            <input type="radio" id="presupuesto_alto" name="presupuesto" value="confortable">
                            <label for="presupuesto_alto">
                                <div class="icon"><i class="fa-solid fa-star"></i></div>
                                <div class="title">Confortable</div>
                                <div class="subtitle">$3,000 - $5,000 USD</div>
                            </label>
                        </div>
                        <div class="option-card">
                            <input type="radio" id="presupuesto_lujo" name="presupuesto" value="lujo">
                            <label for="presupuesto_lujo">
                                <div class="icon"><i class="fa-solid fa-gem"></i></div>
                                <div class="title">Lujo</div>
                                <div class="subtitle">Más de $5,000 USD</div>
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="question-group">
                    <h3><span class="icon"><i class="fa-solid fa-clock"></i></span> ¿Cuánto tiempo durará tu viaje?</h3>
                    <p class="description">La duración influye en el tipo de destinos y actividades que podemos recomendarte</p>
                    <div class="options-grid">
                        <div class="option-card">
                            <input type="radio" id="duracion_corta" name="duracion" value="fin_semana" required>
                            <label for="duracion_corta">
                                <div class="icon"><i class="fa-solid fa-sun"></i></div>
                                <div class="title">Fin de Semana</div>
                                <div class="subtitle">2-3 días</div>
                            </label>
                        </div>
                        <div class="option-card">
                            <input type="radio" id="duracion_semana" name="duracion" value="semana">
                            <label for="duracion_semana">
                                <div class="icon"><i class="fa-solid fa-calendar-week"></i></div>
                                <div class="title">Una Semana</div>
                                <div class="subtitle">4-7 días</div>
                            </label>
                        </div>
                        <div class="option-card">
                            <input type="radio" id="duracion_media" name="duracion" value="dos_semanas">
                            <label for="duracion_media">
                                <div class="icon"><i class="fa-solid fa-calendar-days"></i></div>
                                <div class="title">Dos Semanas</div>
                                <div class="subtitle">8-15 días</div>
                            </label>
                        </div>
                        <div class="option-card">
                            <input type="radio" id="duracion_larga" name="duracion" value="mes_mas">
                            <label for="duracion_larga">
                                <div class="icon"><i class="fa-solid fa-earth-americas"></i></div>
                                <div class="title">Un Mes o Más</div>
                                <div class="subtitle">15+ días</div>
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="question-group">
                    <h3><span class="icon"><i class="fa-solid fa-cloud-sun"></i></span> ¿En qué época prefieres viajar?</h3>
                    <p class="description">La temporada afecta el clima, los precios y la cantidad de turistas</p>
                    <div class="options-grid">
                        <div class="option-card">
                            <input type="radio" id="temp_verano" name="temporada" value="verano" required>
                            <label for="temp_verano">
                                <div class="icon"><i class="fa-solid fa-sun"></i></div>
                                <div class="title">Verano</div>
                                <div class="subtitle">Playa, calor y diversión</div>
                            </label>
                        </div>
                        <div class="option-card">
                            <input type="radio" id="temp_invierno" name="temporada" value="invierno">
                            <label for="temp_invierno">
                                <div class="icon"><i class="fa-solid fa-snowflake"></i></div>
                                <div class="title">Invierno</div>
                                <div class="subtitle">Nieve, esquí y montaña</div>
                            </label>
                        </div>
                        <div class="option-card">
                            <input type="radio" id="temp_primavera" name="temporada" value="primavera">
                            <label for="temp_primavera">
                                <div class="icon"><i class="fa-solid fa-leaf"></i></div>
                                <div class="title">Primavera</div>
                                <div class="subtitle">Clima templado, flores</div>
                            </label>
                        </div>
                        <div class="option-card">
                            <input type="radio" id="temp_otono" name="temporada" value="otono">
                            <label for="temp_otono">
                                <div class="icon"><i class="fa-solid fa-canadian-maple-leaf"></i></div>
                                <div class="title">Otoño</div>
                                <div class="subtitle">Colores, menos turistas</div>
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="question-group">
                    <h3><span class="icon"><i class="fa-solid fa-bullseye"></i></span> ¿Qué tipo de experiencia buscas?</h3>
                    <p class="description">Define el estilo general de tu viaje</p>
                    <div class="options-grid">
                        <div class="option-card">
                            <input type="radio" id="exp_relajante" name="experiencia" value="relajante" required>
                            <label for="exp_relajante">
                                <div class="icon"><i class="fa-solid fa-spa"></i></div>
                                <div class="title">Relajante</div>
                                <div class="subtitle">Descanso y bienestar</div>
                            </label>
                        </div>
                        <div class="option-card">
                            <input type="radio" id="exp_aventura" name="experiencia" value="aventura">
                            <label for="exp_aventura">
                                <div class="icon"><i class="fa-solid fa-mountain-sun"></i></div>
                                <div class="title">Aventura</div>
                                <div class="subtitle">Adrenalina y deportes</div>
                            </label>
                        </div>
                        <div class="option-card">
                            <input type="radio" id="exp_cultural" name="experiencia" value="cultural">
                            <label for="exp_cultural">
                                <div class="icon"><i class="fa-solid fa-landmark"></i></div>
                                <div class="title">Cultural</div>
                                <div class="subtitle">Historia y tradiciones</div>
                            </label>
                        </div>
                        <div class="option-card">
                            <input type="radio" id="exp_lujo" name="experiencia" value="lujo">
                            <label for="exp_lujo">
                                <div class="icon"><i class="fa-solid fa-crown"></i></div>
                                <div class="title">Lujo</div>
                                <div class="subtitle">Confort y exclusividad</div>
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="question-group">
                    <h3><span class="icon"><i class="fa-solid fa-award"></i></span> ¿Cuál es tu prioridad principal?</h3>
                    <p class="description">Esto nos ayuda a afinar nuestras recomendaciones según lo más importante para ti</p>
                    <div class="options-grid">
                        <div class="option-card">
                            <input type="radio" id="prio_ahorro" name="prioridad" value="ahorro" required>
                            <label for="prio_ahorro">
                                <div class="icon"><i class="fa-solid fa-piggy-bank"></i></div>
                                <div class="title">Ahorro</div>
                                <div class="subtitle">Viajar económicamente</div>
                            </label>
                        </div>
                        <div class="option-card">
                            <input type="radio" id="prio_diversion" name="prioridad" value="diversion">
                            <label for="prio_diversion">
                                <div class="icon"><i class="fa-solid fa-martini-glass-citrus"></i></div>
                                <div class="title">Diversión</div>
                                <div class="subtitle">Vivir experiencias únicas</div>
                            </label>
                        </div>
                        <div class="option-card">
                            <input type="radio" id="prio_cultura" name="prioridad" value="cultura">
                            <label for="prio_cultura">
                                <div class="icon"><i class="fa-solid fa-book-open"></i></div>
                                <div class="title">Cultura</div>
                                <div class="subtitle">Aprender y enriquecerse</div>
                            </label>
                        </div>
                        <div class="option-card">
                            <input type="radio" id="prio_comodidad" name="prioridad" value="comodidad">
                            <label for="prio_comodidad">
                                <div class="icon"><i class="fa-solid fa-bed"></i></div>
                                <div class="title">Comodidad</div>
                                <div class="subtitle">Viajar sin preocupaciones</div>
                            </label>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="submit-btn"><i class="fa-solid fa-gift"></i> Ver Recomendaciones Personalizadas</button>
            </form>
        </div>
    </main>
    
    <footer>
        <div class="container">
            <p>&copy; 2025 SATA Viajes. Todos los derechos reservados.</p>
            <ul class="footer-links">
                <li><a href="../../index.php">Inicio</a></li>
                <li><a href="../aboutus.php">Nosotros</a></li>
                <li><a href="../contactus.php">Contacto</a></li>
                <li><a href="../viajero.php">Viajero</a></li>
            </ul>
        </div>
    </footer>
    
    <script>
        window.addEventListener('scroll', function() {
            const header = document.getElementById('header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });
        
        document.querySelectorAll('.question-group').forEach(question => {
            question.style.opacity = '0';
            question.style.transform = 'translateY(20px)';
            question.style.transition = 'all 0.6s ease';
            observer.observe(question);
        });
        
        const form = document.getElementById('quizForm');
        const radioInputs = form.querySelectorAll('input[type="radio"]');
        
        radioInputs.forEach(input => {
            const savedValue = localStorage.getItem(input.name);
            if (savedValue === input.value) {
                input.checked = true;
            }
            
            input.addEventListener('change', function() {
                localStorage.setItem(this.name, this.value);
            });
        });
        
        form.addEventListener('submit', function() {
            radioInputs.forEach(input => {
                localStorage.removeItem(input.name);
            });
        });
    </script>
</body>
</html>