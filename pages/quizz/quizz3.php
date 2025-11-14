<?php
session_start();

// Variable para controlar el estado
$fase = isset($_GET['fase']) ? $_GET['fase'] : 'inicial';
$error = '';

// Procesar selección de destinos favoritos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['destinos_seleccionados'])) {
    $destinos_seleccionados = $_POST['destinos_seleccionados'];
    
    if (count($destinos_seleccionados) > 4) {
        $error = "Por favor, selecciona máximo 4 destinos.";
        $fase = 'seleccion';
    } else {
        // RUTA CORREGIDA - Guardar en src/php/
        $dir_php = __DIR__ . '/../../src/php';
        if (!is_dir($dir_php)) {
            mkdir($dir_php, 0777, true);
        }
        
        $hechos_seleccion = "% Destinos seleccionados por el usuario\n";
        foreach ($destinos_seleccionados as $destino) {
            $destino_limpio = str_replace("'", "\\'", $destino);
            $hechos_seleccion .= "destino_favorito('$destino_limpio').\n";
        }
        file_put_contents($dir_php . '/seleccion_destinos.pl', $hechos_seleccion);
        
        // Ejecutar Prolog desde el directorio correcto
        $dir_prolog = __DIR__ . '/../../src/prolog';
        $old_dir = getcwd();
        chdir($dir_prolog);
        
        $comando = "swipl -s recomendaciones_experto.pl -g \"generar_recomendaciones_finales, halt.\" 2>&1";
        exec($comando, $output, $return_var);
        
        chdir($old_dir);
        
        $fase = 'final';
    }
}

// Generar recomendaciones iniciales si es primera vez
if ($fase === 'inicial') {
    $dir_prolog = __DIR__ . '/../../src/prolog';
    $old_dir = getcwd();
    chdir($dir_prolog);
    
    $comando = "swipl -s recomendaciones_experto.pl -g \"generar_recomendaciones_iniciales, halt.\" 2>&1";
    exec($comando, $output, $return_var);
    
    chdir($old_dir);
    
    $fase = 'seleccion';
}

// Leer recomendaciones según la fase
$destinos = [];
$destinos_finales = [];

if ($fase === 'seleccion') {
    // RUTA CORREGIDA - Buscar en src/temp/
    $archivo_recom = __DIR__ . '/../../src/temp/recomendaciones_iniciales.txt';
    
    if (file_exists($archivo_recom)) {
        $contenido = file_get_contents($archivo_recom);
        $lineas = explode("\n", $contenido);
        
        foreach ($lineas as $linea) {
            if (strpos($linea, 'DESTINO:') !== false) {
                $nombre = trim(str_replace('DESTINO:', '', $linea));
                if (!empty($nombre)) {
                    $destinos[] = ['nombre' => $nombre];
                }
            }
        }
    }
} elseif ($fase === 'final') {
    // RUTA CORREGIDA - Buscar en src/temp/
    $archivo_finales = __DIR__ . '/../../src/temp/recomendaciones_finales.txt';
    
    if (file_exists($archivo_finales)) {
        $contenido = file_get_contents($archivo_finales);
        $lineas = explode("\n", $contenido);
        
        $destino_actual = null;
        foreach ($lineas as $linea) {
            $linea = trim($linea);
            if (strpos($linea, '*** POSICION') !== false) {
                if ($destino_actual) {
                    $destinos_finales[] = $destino_actual;
                }
                preg_match('/#(\d+)/', $linea, $matches);
                $posicion = isset($matches[1]) ? $matches[1] : '1';
                $destino_actual = [
                    'posicion' => $posicion,
                    'nombre' => '',
                    'puntuacion' => '',
                    'descripcion' => '',
                    'razon' => '',
                    'actividades' => ''
                ];
            } elseif (strpos($linea, 'DESTINO:') !== false && $destino_actual) {
                $destino_actual['nombre'] = trim(str_replace('DESTINO:', '', $linea));
            } elseif (strpos($linea, 'PUNTUACION:') !== false && $destino_actual) {
                $destino_actual['puntuacion'] = trim(str_replace('PUNTUACION:', '', $linea));
            } elseif (strpos($linea, 'DESCRIPCION:') !== false && $destino_actual) {
                $destino_actual['descripcion'] = trim(str_replace('DESCRIPCION:', '', $linea));
            } elseif (strpos($linea, 'RAZON:') !== false && $destino_actual) {
                $destino_actual['razon'] = trim(str_replace('RAZON:', '', $linea));
            } elseif (strpos($linea, 'ACTIVIDADES:') !== false && $destino_actual) {
                $destino_actual['actividades'] = trim(str_replace('ACTIVIDADES:', '', $linea));
            }
        }
        if ($destino_actual) {
            $destinos_finales[] = $destino_actual;
        }
    }
}

// Mapeo de imágenes para cada destino - RUTAS CORREGIDAS
$imagenes_destinos = [
    'Roma, Italia' => '../../assets/images/quizz/roma.jpg',
    'Kyoto, Japon' => '../../assets/images/quizz/kyoto.jpg',
    'Atenas, Grecia' => '../../assets/images/quizz/atenas.jpg',
    'Ciudad de Mexico' => '../../assets/images/quizz/cdmx.jpg',
    'Cusco, Peru' => '../../assets/images/quizz/cusco.jpg',
    'Paris, Francia' => '../../assets/images/quizz/paris.jpg',
    'Estambul, Turquia' => '../../assets/images/quizz/estambul.jpg',
    'Marrakech, Marruecos' => '../../assets/images/quizz/marrakech.jpg',
    'Queenstown, Nueva Zelanda' => '../../assets/images/quizz/queenstown.jpg',
    'Interlaken, Suiza' => '../../assets/images/quizz/interlaken.jpg',
    'Moab, Utah' => '../../assets/images/quizz/moab.jpg',
    'Banos, Ecuador' => '../../assets/images/quizz/banos.jpg',
    'Chamonix, Francia' => '../../assets/images/quizz/chamonix.jpg',
    'Costa Rica' => '../../assets/images/quizz/costarica.jpg',
    'Patagonia Chilena' => '../../assets/images/quizz/patagonia-chile.jpg',
    'Nepal Himalaya' => '../../assets/images/quizz/nepal.jpg',
    'Maldivas' => '../../assets/images/quizz/maldivas.jpg',
    'Santorini, Grecia' => '../../assets/images/quizz/santorini.jpg',
    'Ubud, Bali' => '../../assets/images/quizz/bali.jpg',
    'Toscana, Italia' => '../../assets/images/quizz/toscana.jpg',
    'Tulum, Mexico' => '../../assets/images/quizz/tulum.jpg',
    'Bora Bora' => '../../assets/images/quizz/borabora.jpg',
    'Seychelles' => '../../assets/images/quizz/seychelles.jpg',
    'Kyoto Templos Zen' => '../../assets/images/quizz/kyoto-zen.jpg',
    'Islandia' => '../../assets/images/quizz/islandia.jpg',
    'Patagonia Argentina' => '../../assets/images/quizz/patagonia-argentina.jpg',
    'Parques Nacionales USA' => '../../assets/images/quizz/usa-parks.jpg',
    'Costa Rica Natural' => '../../assets/images/quizz/costarica-natural.jpg',
    'Fiordos de Noruega' => '../../assets/images/quizz/noruega.jpg',
    'Amazonas Brasil' => '../../assets/images/quizz/amazonas.jpg',
    'Galapagos Ecuador' => '../../assets/images/quizz/galapagos.jpg',
    'Nueva Zelanda Sur' => '../../assets/images/quizz/newzealand.jpg'
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SATA - Tus Destinos Recomendados</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/quizz/quizz3.css">
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
            <?php if ($fase === 'seleccion'): ?>
                <div class="quiz-header">
                    <div class="step-indicator">Paso 3 de 3</div>
                    <h1>Destinos Recomendados</h1>
                    <div class="divider"></div>
                    <p>Selecciona hasta 4 destinos que más te interesen</p>
                </div>
                
                <div class="progress-container">
                    <div class="progress-steps">
                        <div class="step completed">1</div>
                        <div class="step completed">2</div>
                        <div class="step active">3</div>
                    </div>
                    <div class="step-labels">
                        <div class="step-label">Perfil de Viajero</div>
                        <div class="step-label">Datos del Viaje</div>
                        <div class="step-label active">Recomendaciones</div>
                    </div>
                </div>
                
                <?php if (!empty($error)): ?>
                    <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                
                <div class="contador">
                    Seleccionados: <span class="numero" id="contador">0</span> / 4
                </div>
                
                <form method="POST" id="destinosForm">
                    <div class="destinos-grid">
                        <?php foreach ($destinos as $destino): ?>
                            <div class="destino-card" data-destino="<?php echo htmlspecialchars($destino['nombre']); ?>">
                                <div class="checkbox"></div>
                                <div class="image-container">
                                    <?php 
                                    $imagen = isset($imagenes_destinos[$destino['nombre']]) 
                                        ? $imagenes_destinos[$destino['nombre']] 
                                        : '../../assets/images/quizz/placeholder.jpg';
                                    ?>
                                    <img src="<?php echo htmlspecialchars($imagen); ?>" 
                                         alt="<?php echo htmlspecialchars($destino['nombre']); ?>" 
                                         onerror="this.style.display='none'; this.parentElement.innerHTML='<div style=\'font-size:3em;color:rgba(255,255,255,0.2);\'>📍</div>';">
                                </div>
                                <div class="content">
                                    <h3><?php echo htmlspecialchars($destino['nombre']); ?></h3>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="submit" class="submit-btn" id="submitBtn" disabled>Ver Recomendaciones Finales</button>
                </form>
                
            <?php elseif ($fase === 'final'): ?>
                <div class="quiz-header">
                    <div class="step-indicator">TOP 3 Final</div>
                    <h1>Tus Destinos Perfectos</h1>
                    <div class="divider"></div>
                    <p>Basados en tu perfil y tus preferencias</p>
                </div>
                
                <div class="top3-container">
                    <?php foreach ($destinos_finales as $destino): ?>
                        <div class="top-card rank-<?php echo $destino['posicion']; ?>">
                            <div class="rank-badge"><?php echo $destino['posicion']; ?></div>
                            <?php if (!empty($destino['puntuacion'])): ?>
                                <div class="score-badge"><?php echo htmlspecialchars($destino['puntuacion']); ?></div>
                            <?php endif; ?>
                            <div class="image-container">
                                <?php 
                                $imagen = isset($imagenes_destinos[$destino['nombre']]) 
                                    ? $imagenes_destinos[$destino['nombre']] 
                                    : '../../assets/images/quizz/placeholder.jpg';
                                ?>
                                <img src="<?php echo htmlspecialchars($imagen); ?>" 
                                     alt="<?php echo htmlspecialchars($destino['nombre']); ?>"
                                     onerror="this.style.display='none'; this.parentElement.innerHTML+='<div style=\'font-size:3em;color:rgba(255,255,255,0.2);position:absolute;top:50%;left:50%;transform:translate(-50%,-50%)\'>📍</div>';">
                            </div>
                            <div class="content">
                                <h3><?php echo htmlspecialchars($destino['nombre']); ?></h3>
                                <?php if (!empty($destino['descripcion'])): ?>
                                    <p class="description"><?php echo htmlspecialchars($destino['descripcion']); ?></p>
                                <?php endif; ?>
                                <?php if (!empty($destino['razon'])): ?>
                                    <div class="reason">
                                        <strong>Por qué es perfecto para ti:</strong> <?php echo htmlspecialchars($destino['razon']); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($destino['actividades'])): ?>
                                    <p class="activities"><strong>Actividades:</strong> <?php echo htmlspecialchars($destino['actividades']); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <a href="../../index.php" class="submit-btn">Volver al Inicio</a>
            <?php endif; ?>
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
        
        <?php if ($fase === 'seleccion'): ?>
        const cards = document.querySelectorAll('.destino-card');
        const form = document.getElementById('destinosForm');
        const contador = document.getElementById('contador');
        const submitBtn = document.getElementById('submitBtn');
        let seleccionados = [];
        
        cards.forEach(card => {
            card.addEventListener('click', function(e) {
                if (e.target.tagName === 'IMG') return;
                
                const destino = this.getAttribute('data-destino');
                
                if (this.classList.contains('selected')) {
                    this.classList.remove('selected');
                    seleccionados = seleccionados.filter(d => d !== destino);
                } else {
                    if (seleccionados.length < 4) {
                        this.classList.add('selected');
                        seleccionados.push(destino);
                    }
                }
                
                contador.textContent = seleccionados.length;
                submitBtn.disabled = seleccionados.length === 0;
            });
        });
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (seleccionados.length === 0) {
                alert('Por favor, selecciona al menos un destino');
                return;
            }
            
            if (seleccionados.length > 4) {
                alert('Por favor, selecciona máximo 4 destinos');
                return;
            }
            
            seleccionados.forEach(destino => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'destinos_seleccionados[]';
                input.value = destino;
                form.appendChild(input);
            });
            
            form.submit();
        });
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });
        
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = `all 0.6s ease ${index * 0.1}s`;
            observer.observe(card);
        });
        <?php endif; ?>
    </script>
</body>
</html>