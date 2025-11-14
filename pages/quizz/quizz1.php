<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['respuestas'] = $_POST;
    
    // Crear el archivo de hechos para Prolog
    $hechos = "% Hechos generados desde PHP\n";
    
    foreach ($_POST as $pregunta => $respuesta) {
        if ($respuesta === 'si') {
            $hechos .= "respuesta('$pregunta', si).\n";
        } else {
            $hechos .= "respuesta('$pregunta', no).\n";
        }
    }
    
    // RUTAS CORREGIDAS - Desde pages/quizz/ hacia src/
    $dir_php = __DIR__ . '/../../src/php';
    if (!is_dir($dir_php)) {
        mkdir($dir_php, 0777, true);
    }
    
    $archivo_hechos = $dir_php . '/hechos_usuario.pl';
    file_put_contents($archivo_hechos, $hechos);
    
    // Verificar que el directorio temp existe
    $dir_temp = __DIR__ . '/../../src/temp';
    if (!is_dir($dir_temp)) {
        mkdir($dir_temp, 0777, true);
    }
    
    // Cambiar al directorio de Prolog para ejecutar
    $dir_prolog = __DIR__ . '/../../src/prolog';
    $old_dir = getcwd();
    chdir($dir_prolog);
    
    // Ejecutar SWI-Prolog
    $comando = "swipl -s viajero_experto1.pl -g \"determinar_perfil, halt.\" -t 'halt(1)' 2>&1";
    $resultado = shell_exec($comando);
    
    // Volver al directorio original
    chdir($old_dir);
    
    // Log de depuración
    file_put_contents($dir_temp . '/debug.txt', 
        "Comando: $comando\n" .
        "Resultado: $resultado\n" .
        "Hechos guardados en: $archivo_hechos\n" .
        "Directorio prolog: $dir_prolog\n" .
        "Archivo existe: " . (file_exists($archivo_hechos) ? 'SI' : 'NO') . "\n"
    );
    
    // Redirigir a la página de resultados
    header('Location: quizz1.php?resultado=1');
    exit;
}

// Mostrar resultado si existe
$mostrar_resultado = isset($_GET['resultado']);
$resultado = '';

if ($mostrar_resultado) {
    $archivo_resultado = __DIR__ . '/../../src/temp/resultado.txt';
    
    if (file_exists($archivo_resultado)) {
        $resultado = file_get_contents($archivo_resultado);
        
        if (empty(trim($resultado))) {
            $resultado = "Error: El archivo de resultados está vacío.\n";
            $resultado .= "Verifica que SWI-Prolog esté instalado y configurado correctamente.\n";
            
            $debug_file = __DIR__ . '/../../src/temp/debug.txt';
            if (file_exists($debug_file)) {
                $resultado .= "\n--- Log de Depuración ---\n";
                $resultado .= file_get_contents($debug_file);
            }
        }
    } else {
        $resultado = "Error: No se encontró el archivo de resultados.\n";
        $resultado .= "Ruta esperada: $archivo_resultado\n";
        
        $archivo_hechos = __DIR__ . '/../../src/php/hechos_usuario.pl';
        if (file_exists($archivo_hechos)) {
            $resultado .= "\n--- Hechos del Usuario ---\n";
            $resultado .= file_get_contents($archivo_hechos);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SATA - Descubre tu Tipo de Viajero</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/quizz/quizz1.css">
</head>
<body>
    <div class="particles">
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
                </ul>
            </nav>
        </div>
    </header>
    
    <main class="main-content">
        <div class="container">
            <?php if ($mostrar_resultado): ?>
                <div class="resultado-container">
                    <?php
                    $lineas = explode("\n", trim($resultado));
                    $tipo_viajero = "";
                    $compania = "";
                    
                    foreach ($lineas as $linea) {
                        if (strpos($linea, 'Tipo de Viajero:') !== false) {
                            $tipo_viajero = trim(str_replace('Tipo de Viajero:', '', $linea));
                        } elseif (strpos($linea, 'Compañía Preferida:') !== false) {
                            $compania = trim(str_replace('Compañía Preferida:', '', $linea));
                        }
                    }
                    
                    if (empty($tipo_viajero)) {
                        echo "<h2>Error al Procesar Resultados</h2>";
                        echo "<pre>" . htmlspecialchars($resultado) . "</pre>";
                        echo "<p><a href='quizz1.php' class='btn-volver'>Intentar de Nuevo</a></p>";
                    } else {
                        $descripciones = [
                            'Cultural' => 'El viajero cultural busca entender la esencia de cada destino. Le interesan las costumbres, la historia, la gastronomía local y la interacción con habitantes del lugar. Prefiere museos, sitios históricos y experiencias auténticas.',
                            'Extremo' => 'El viajero extremo busca emociones fuertes. No se conforma con ver el paisaje, quiere vivirlo hasta el límite. Ama los deportes de riesgo, la adrenalina y los desafíos físicos que pongan a prueba sus capacidades.',
                            'Tranquilo' => 'El viajero tranquilo disfruta de momentos de calma y relajación en destinos serenos. Busca desconectarse del estrés diario, conectando con la serenidad del entorno en spas, playas tranquilas o retiros de bienestar.',
                            'Natural' => 'El viajero natural ama la naturaleza y busca conectarse con paisajes vírgenes. Disfruta del senderismo, la observación de fauna y flora, y actividades al aire libre que le permitan apreciar la belleza natural del planeta.',
                            'Mixto' => 'Tu perfil combina varios intereses de viaje. Eres versátil y disfrutas de experiencias variadas en tus aventuras.'
                        ];
                        
                        $companias_desc = [
                            'Solitario' => 'Prefieres viajar solo, disfrutando de tu propia compañía y la libertad de decidir cada paso de tu aventura.',
                            'Familiar' => 'Viajas en familia, creando recuerdos inolvidables con tus seres queridos y buscando experiencias que todos disfruten.',
                            'Amigos' => 'Te gusta viajar con amigos, compartiendo risas, aventuras y momentos únicos con tu grupo de confianza.',
                            'Pareja' => 'Prefieres viajar en pareja, disfrutando de momentos románticos y experiencias compartidas con tu ser amado.',
                            'Flexible' => 'Eres flexible en cuanto a compañía, adaptándote a diferentes estilos de viaje.'
                        ];
                        
                        $imagenes = [
                            'Cultural' => '../../assets/images/index/QP/cultural.jpeg',
                            'Extremo' => '../../assets/images/index/QP/extremo.jpeg',
                            'Tranquilo' => '../../assets/images/index/QP/tranquilo.jpeg',
                            'Natural' => '../../assets/images/index/QP/naturista.jpeg'
                        ];
                        
                        $imagen_resultado = $imagenes[$tipo_viajero] ?? '../../assets/images/perfil/sata.png';
                    ?>
                    
                    <h2>¡Tu Perfil de Viajero!</h2>
                    
                    <div class="resultado-icon">
                        <img src="<?php echo htmlspecialchars($imagen_resultado); ?>" alt="<?php echo htmlspecialchars($tipo_viajero); ?>" class="resultado-imagen">
                    </div>
                    
                    <div class="perfil-titulo"><?php echo htmlspecialchars($tipo_viajero); ?></div>
                    
                    <p><?php echo $descripciones[$tipo_viajero] ?? 'Descripción no disponible'; ?></p>
                    
                    <div class="resultado-caracteristicas">
                        <h3>Características de tu Perfil</h3>
                        <?php if ($tipo_viajero === 'Cultural'): ?>
                            <div class="caracteristica-item">Visitas museos y sitios históricos</div>
                            <div class="caracteristica-item">Te interesa la gastronomía local</div>
                            <div class="caracteristica-item">Buscas interactuar con habitantes locales</div>
                            <div class="caracteristica-item">Prefieres experiencias auténticas</div>
                        <?php elseif ($tipo_viajero === 'Extremo'): ?>
                            <div class="caracteristica-item">Buscas emociones fuertes y adrenalina</div>
                            <div class="caracteristica-item">Te gustan los deportes de riesgo</div>
                            <div class="caracteristica-item">No temes a los desafíos físicos</div>
                            <div class="caracteristica-item">Prefieres actividades al límite</div>
                        <?php elseif ($tipo_viajero === 'Tranquilo'): ?>
                            <div class="caracteristica-item">Buscas momentos de paz y relajación</div>
                            <div class="caracteristica-item">Prefieres destinos serenos</div>
                            <div class="caracteristica-item">Te gusta desconectar del estrés</div>
                            <div class="caracteristica-item">Disfrutas de spas y retiros de bienestar</div>
                        <?php elseif ($tipo_viajero === 'Natural'): ?>
                            <div class="caracteristica-item">Amas la naturaleza y paisajes vírgenes</div>
                            <div class="caracteristica-item">Disfrutas del senderismo</div>
                            <div class="caracteristica-item">Te interesa la fauna y flora</div>
                            <div class="caracteristica-item">Prefieres actividades al aire libre</div>
                        <?php endif; ?>
                    </div>
                    
                    <?php if ($compania): ?>
                        <p style="margin-top: 40px; font-size: 1.4em; color: var(--accent-glow);">
                            <strong>Compañía Preferida:</strong> <?php echo htmlspecialchars($compania); ?>
                        </p>
                        <p style="font-size: 1.1em;"><?php echo $companias_desc[$compania] ?? ''; ?></p>
                    <?php endif; ?>
                    
                    <div style="margin-top: 50px;">
                        <a href="../../index.php" class="btn-volver">Volver al Inicio</a>
                        <a href="quizz2.php" class="btn-volver">Siguiente: Tipo de Viaje</a>
                    </div>
                    
                    <?php } ?>
                </div>
            <?php else: ?>
                <div class="quiz-header">
                    <h1>Descubre tu Tipo de Viajero</h1>
                    <div class="divider"></div>
                    <p>Responde estas preguntas para conocer tu perfil de viajero ideal</p>
                </div>
                
                <div class="progress-container">
                    <div class="progress-bar">
                        <div class="progress-fill" id="progressBar"></div>
                    </div>
                    <div class="progress-text">
                        <span id="progressText">0 de 13 preguntas completadas</span>
                    </div>
                </div>
                
                <form method="POST" class="quiz-form" id="quizForm">
                    <div class="question-group">
                        <h3>¿Te interesa visitar museos y sitios históricos?</h3>
                        <div class="radio-group">
                            <div class="radio-option">
                                <input type="radio" id="museos_si" name="museos" value="si" required>
                                <label for="museos_si">Sí</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="museos_no" name="museos" value="no">
                                <label for="museos_no">No</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="question-group">
                        <h3>¿Disfrutas de la gastronomía local y probar nuevos sabores?</h3>
                        <div class="radio-group">
                            <div class="radio-option">
                                <input type="radio" id="gastronomia_si" name="gastronomia" value="si" required>
                                <label for="gastronomia_si">Sí</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="gastronomia_no" name="gastronomia" value="no">
                                <label for="gastronomia_no">No</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="question-group">
                        <h3>¿Te gusta interactuar con habitantes locales?</h3>
                        <div class="radio-group">
                            <div class="radio-option">
                                <input type="radio" id="interaccion_si" name="interaccion" value="si" required>
                                <label for="interaccion_si">Sí</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="interaccion_no" name="interaccion" value="no">
                                <label for="interaccion_no">No</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="question-group">
                        <h3>¿Buscas emociones fuertes y deportes de riesgo?</h3>
                        <div class="radio-group">
                            <div class="radio-option">
                                <input type="radio" id="adrenalina_si" name="adrenalina" value="si" required>
                                <label for="adrenalina_si">Sí</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="adrenalina_no" name="adrenalina" value="no">
                                <label for="adrenalina_no">No</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="question-group">
                        <h3>¿Te atraen las actividades físicas extremas?</h3>
                        <div class="radio-group">
                            <div class="radio-option">
                                <input type="radio" id="extremo_si" name="extremo" value="si" required>
                                <label for="extremo_si">Sí</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="extremo_no" name="extremo" value="no">
                                <label for="extremo_no">No</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="question-group">
                        <h3>¿Prefieres momentos de paz y relajación?</h3>
                        <div class="radio-group">
                            <div class="radio-option">
                                <input type="radio" id="relajacion_si" name="relajacion" value="si" required>
                                <label for="relajacion_si">Sí</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="relajacion_no" name="relajacion" value="no">
                                <label for="relajacion_no">No</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="question-group">
                        <h3>¿Te gustan los destinos tranquilos y serenos?</h3>
                        <div class="radio-group">
                            <div class="radio-option">
                                <input type="radio" id="tranquilo_si" name="tranquilo" value="si" required>
                                <label for="tranquilo_si">Sí</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="tranquilo_no" name="tranquilo" value="no">
                                <label for="tranquilo_no">No</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="question-group">
                        <h3>¿Amas la naturaleza y los paisajes naturales?</h3>
                        <div class="radio-group">
                            <div class="radio-option">
                                <input type="radio" id="naturaleza_si" name="naturaleza" value="si" required>
                                <label for="naturaleza_si">Sí</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="naturaleza_no" name="naturaleza" value="no">
                                <label for="naturaleza_no">No</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="question-group">
                        <h3>¿Disfrutas del senderismo y actividades al aire libre?</h3>
                        <div class="radio-group">
                            <div class="radio-option">
                                <input type="radio" id="senderismo_si" name="senderismo" value="si" required>
                                <label for="senderismo_si">Sí</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="senderismo_no" name="senderismo" value="no">
                                <label for="senderismo_no">No</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="question-group">
                        <h3>¿Prefieres viajar solo?</h3>
                        <div class="radio-group">
                            <div class="radio-option">
                                <input type="radio" id="solo_si" name="solo" value="si" required>
                                <label for="solo_si">Sí</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="solo_no" name="solo" value="no">
                                <label for="solo_no">No</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="question-group">
                        <h3>¿Te gusta viajar en familia?</h3>
                        <div class="radio-group">
                            <div class="radio-option">
                                <input type="radio" id="familia_si" name="familia" value="si" required>
                                <label for="familia_si">Sí</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="familia_no" name="familia" value="no">
                                <label for="familia_no">No</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="question-group">
                        <h3>¿Prefieres viajar con amigos?</h3>
                        <div class="radio-group">
                            <div class="radio-option">
                                <input type="radio" id="amigos_si" name="amigos" value="si" required>
                                <label for="amigos_si">Sí</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="amigos_no" name="amigos" value="no">
                                <label for="amigos_no">No</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="question-group">
                        <h3>¿Te gusta viajar en pareja?</h3>
                        <div class="radio-group">
                            <div class="radio-option">
                                <input type="radio" id="pareja_si" name="pareja" value="si" required>
                                <label for="pareja_si">Sí</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="pareja_no" name="pareja" value="no">
                                <label for="pareja_no">No</label>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="submit-btn">Descubrir mi Perfil de Viajero</button>
                </form>
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
        
        const form = document.getElementById('quizForm');
        if (form) {
            const totalQuestions = 13;
            const radioInputs = form.querySelectorAll('input[type="radio"]');
            const progressBar = document.getElementById('progressBar');
            const progressText = document.getElementById('progressText');
            
            radioInputs.forEach(input => {
                input.addEventListener('change', updateProgress);
            });
            
            function updateProgress() {
                const answeredGroups = new Set();
                radioInputs.forEach(input => {
                    if (input.checked) {
                        answeredGroups.add(input.name);
                    }
                });
                
                const answered = answeredGroups.size;
                const percentage = (answered / totalQuestions) * 100;
                
                progressBar.style.width = percentage + '%';
                progressText.textContent = `${answered} de ${totalQuestions} preguntas completadas`;
            }
            
            updateProgress();
        }
        
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
    </script>
</body>
</html>