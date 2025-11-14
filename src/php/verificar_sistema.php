<?php
/**
 * Script de Verificación del Sistema SATA
 * Ejecutar desde navegador o línea de comandos para diagnosticar problemas
 */

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación del Sistema SATA</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            background: #1a1a1a;
            color: #00ff00;
            padding: 20px;
            line-height: 1.6;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: #0a0a0a;
            padding: 30px;
            border: 2px solid #00ff00;
            border-radius: 10px;
        }
        h1 {
            color: #ffd700;
            text-align: center;
            border-bottom: 2px solid #ffd700;
            padding-bottom: 10px;
        }
        h2 {
            color: #00ffff;
            margin-top: 30px;
            border-left: 4px solid #00ffff;
            padding-left: 10px;
        }
        .check {
            display: flex;
            align-items: center;
            margin: 10px 0;
            padding: 10px;
            background: #111;
            border-radius: 5px;
        }
        .ok {
            color: #00ff00;
            font-weight: bold;
        }
        .error {
            color: #ff0000;
            font-weight: bold;
        }
        .warning {
            color: #ffaa00;
            font-weight: bold;
        }
        .icon {
            font-size: 20px;
            margin-right: 10px;
            min-width: 30px;
        }
        pre {
            background: #000;
            padding: 15px;
            border-left: 4px solid #ffd700;
            overflow-x: auto;
            color: #00ff00;
        }
        .summary {
            margin-top: 30px;
            padding: 20px;
            background: #000;
            border: 2px solid #ffd700;
            border-radius: 5px;
        }
        .summary h3 {
            color: #ffd700;
            margin-top: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 VERIFICACIÓN DEL SISTEMA SATA</h1>
        
        <?php
        $errors = 0;
        $warnings = 0;
        $checks = 0;
        
        // ===== 1. VERIFICAR PHP =====
        echo "<h2>1. Entorno PHP</h2>";
        
        $checks++;
        if (version_compare(PHP_VERSION, '7.4.0', '>=')) {
            echo check_ok("PHP versión: " . PHP_VERSION);
        } else {
            echo check_error("PHP versión " . PHP_VERSION . " (Se requiere 7.4+)");
            $errors++;
        }
        
        $checks++;
        if (function_exists('shell_exec')) {
            echo check_ok("shell_exec() está habilitado");
        } else {
            echo check_error("shell_exec() está deshabilitado (necesario para ejecutar Prolog)");
            $errors++;
        }
        
        $checks++;
        if (is_writable(__DIR__)) {
            echo check_ok("Permisos de escritura en el directorio");
        } else {
            echo check_error("Sin permisos de escritura en: " . __DIR__);
            $errors++;
        }
        
        // ===== 2. VERIFICAR SWI-PROLOG =====
        echo "<h2>2. SWI-Prolog</h2>";
        
        $checks++;
        $prolog_version = shell_exec('swipl --version 2>&1');
        if ($prolog_version && strpos($prolog_version, 'SWI-Prolog') !== false) {
            echo check_ok("SWI-Prolog instalado");
            echo "<pre>" . htmlspecialchars(trim($prolog_version)) . "</pre>";
        } else {
            echo check_error("SWI-Prolog NO encontrado");
            echo "<pre>Salida: " . htmlspecialchars($prolog_version ?: "(vacío)") . "</pre>";
            $errors++;
        }
        
        // ===== 3. VERIFICAR ARCHIVOS REQUERIDOS =====
        echo "<h2>3. Archivos del Sistema</h2>";
        
        $required_files = [
            '../../index.php' => 'Página principal',
            '../../pages/quizz/quizz1.php' => 'Quiz 1 - Perfil de viajero',
            '../../pages/quizz/quizz2.php' => 'Quiz 2 - Datos prácticos',
            '../../pages/quizz/quizz3.php' => 'Quiz 3 - Recomendaciones',
            '../prolog/viajero_experto1.pl' => 'Motor Prolog - Perfil',
            '../prolog/motor_inferencia.pl' => 'Motor Prolog - Recomendaciones',
            '../prolog/destinos.pl' => 'Base de conocimiento'
        ];
        
        foreach ($required_files as $file => $desc) {
            $checks++;
            if (file_exists($file)) {
                $size = filesize($file);
                echo check_ok("$desc ($file) - " . number_format($size) . " bytes");
                
                if ($size < 100 && strpos($file, '.pl') !== false) {
                    echo check_warning("  ⚠️ Archivo muy pequeño, puede estar incompleto");
                    $warnings++;
                }
            } else {
                echo check_error("$desc ($file) NO ENCONTRADO");
                $errors++;
            }
        }
        
        // ===== 4. VERIFICAR BASE DE CONOCIMIENTO =====
        echo "<h2>4. Base de Conocimiento</h2>";
        
        $checks++;
        if (file_exists('../prolog/destinos.pl')) {
            $content = file_get_contents('../prolog/destinos.pl');
            $num_destinos = preg_match_all('/destino\(/', $content);
            
            if ($num_destinos > 0) {
                echo check_ok("Base de datos: $num_destinos destinos encontrados");
                
                if ($num_destinos < 20) {
                    echo check_warning("  ⚠️ Solo $num_destinos destinos. Se recomienda tener al menos 50 para mejores resultados");
                    $warnings++;
                }
            } else {
                echo check_error("No se encontraron destinos en destinos.pl");
                $errors++;
            }
            
            // Verificar presupuestos
            $presupuestos = ['economico', 'moderado', 'confortable', 'lujo'];
            foreach ($presupuestos as $p) {
                $count = substr_count($content, ", $p,");
                echo check_info("  Presupuesto '$p': $count destinos");
            }
        }
        
        // ===== 5. PROBAR MOTOR DE INFERENCIA =====
        echo "<h2>5. Prueba del Motor de Inferencia</h2>";
        
        // Crear archivos de prueba
        $checks++;
        $test_hechos = <<<PROLOG
% Hechos de prueba
respuesta(museos, si).
respuesta(gastronomia, si).
respuesta(interaccion, si).
respuesta(adrenalina, no).
respuesta(extremo, no).
respuesta(relajacion, no).
respuesta(tranquilo, no).
respuesta(naturaleza, no).
respuesta(senderismo, no).
respuesta(solo, no).
respuesta(familia, no).
respuesta(amigos, si).
respuesta(pareja, no).
PROLOG;
        
        $test_datos = <<<PROLOG
% Datos de prueba
presupuesto(moderado).
duracion(semana).
temporada(primavera).
experiencia(cultural).
prioridad(cultura).
PROLOG;
        
        if (file_put_contents('../prolog/hechos_usuario.pl', $test_hechos) !== false) {
            echo check_ok("Archivo de prueba hechos_usuario.pl creado");
        } else {
            echo check_error("No se pudo crear hechos_usuario.pl");
            $errors++;
        }
        
        $checks++;
        if (file_put_contents('../prolog/datos_practicos.pl', $test_datos) !== false) {
            echo check_ok("Archivo de prueba datos_practicos.pl creado");
        } else {
            echo check_error("No se pudo crear datos_practicos.pl");
            $errors++;
        }
        
        // Ejecutar motor de inferencia
        $checks++;
        echo "<div class='check'><span class='icon'>⏳</span> Ejecutando motor de inferencia...</div>";
        
        $comando = 'swipl -s motor_inferencia.pl -g main -t halt 2>&1';
        $output = shell_exec($comando);
        
        if ($output !== null && trim($output) !== '') {
            $lineas = array_filter(array_map('trim', explode("\n", trim($output))));
            $destinos_encontrados = count($lineas);
            
            if ($destinos_encontrados > 0) {
                echo check_ok("Motor ejecutado correctamente: $destinos_encontrados destinos recomendados");
                echo "<pre>" . htmlspecialchars(implode("\n", array_slice($lineas, 0, 8))) . "</pre>";
            } else {
                echo check_warning("Motor ejecutado pero sin resultados");
                echo "<pre>" . htmlspecialchars($output) . "</pre>";
                $warnings++;
            }
        } else {
            echo check_error("Error al ejecutar el motor de inferencia");
            echo "<pre>Sin salida del comando</pre>";
            $errors++;
        }
        
        // ===== 6. VERIFICAR SESIONES =====
        echo "<h2>6. Configuración de Sesiones</h2>";
        
        $checks++;
        if (session_status() === PHP_SESSION_ACTIVE || @session_start()) {
            echo check_ok("Las sesiones PHP están funcionando");
            session_destroy();
        } else {
            echo check_error("Problema con las sesiones PHP");
            $errors++;
        }
        
        // ===== 7. IMÁGENES =====
        echo "<h2>7. Recursos Visuales</h2>";
        
        $image_files = [
            '../../assets/images/index/QP/cultural.jpeg',
            '../../assets/images/index/QP/extremo.jpeg',
            '../../assets/images/index/QP/tranquilo.jpeg',
            '../../assets/images/index/QP/naturista.jpeg',
            '../../assets/images/index/fondo/hermoso-tiro-horizontal-del-sol-naciente-y-altas-montanas-rocosas-bajo-el-cielo-nublado.jpg'
        ];
        
        $images_found = 0;
        foreach ($image_files as $img) {
            $checks++;
            if (file_exists($img)) {
                echo check_ok("Imagen: $img");
                $images_found++;
            } else {
                echo check_warning("Imagen no encontrada: $img");
                $warnings++;
            }
        }
        
        if ($images_found === 0) {
            echo check_warning("⚠️ No se encontraron imágenes. El sistema funcionará pero sin imágenes");
        }
        
        // ===== RESUMEN =====
        echo "<div class='summary'>";
        echo "<h3>📊 RESUMEN DE VERIFICACIÓN</h3>";
        echo "<p><strong>Total de verificaciones:</strong> $checks</p>";
        
        if ($errors === 0 && $warnings === 0) {
            echo "<p class='ok'>✅ Sistema completamente funcional</p>";
            echo "<p>El sistema SATA está listo para usarse.</p>";
        } elseif ($errors === 0) {
            echo "<p class='warning'>⚠️ Sistema funcional con advertencias ($warnings)</p>";
            echo "<p>El sistema funcionará pero hay algunas mejoras recomendadas.</p>";
        } else {
            echo "<p class='error'>❌ Sistema con errores ($errors errores, $warnings advertencias)</p>";
            echo "<p>Por favor, corrige los errores antes de usar el sistema.</p>";
        }
        
        echo "<hr style='border-color: #ffd700; margin: 20px 0;'>";
        echo "<p><strong>Próximos pasos:</strong></p>";
        
        if ($errors > 0) {
            echo "<ol>";
            echo "<li>Revisa los errores marcados en rojo arriba</li>";
            echo "<li>Consulta el archivo LEEME.md para instrucciones detalladas</li>";
            echo "<li>Vuelve a ejecutar este script después de hacer correcciones</li>";
            echo "</ol>";
        } else {
            echo "<ol>";
            echo "<li>✅ Accede a <a href='index.php' style='color: #00ffff;'>index.php</a> para ver la página principal</li>";
            echo "<li>✅ Comienza el quiz desde <a href='quizz1.php' style='color: #00ffff;'>quizz1.php</a></li>";
            echo "<li>Si encuentras problemas, revisa los logs de Apache/PHP</li>";
            echo "</ol>";
        }
        
        echo "</div>";
        
        // ===== FUNCIONES AUXILIARES =====
        function check_ok($msg) {
            return "<div class='check'><span class='icon ok'>✅</span><span class='ok'>$msg</span></div>";
        }
        
        function check_error($msg) {
            return "<div class='check'><span class='icon error'>❌</span><span class='error'>$msg</span></div>";
        }
        
        function check_warning($msg) {
            return "<div class='check'><span class='icon warning'>⚠️</span><span class='warning'>$msg</span></div>";
        }
        
        function check_info($msg) {
            return "<div class='check'><span class='icon'>ℹ️</span><span>$msg</span></div>";
        }
        ?>
        
        <div style="margin-top: 40px; text-align: center; color: #666;">
            <p>Script de verificación ejecutado el <?php echo date('Y-m-d H:i:s'); ?></p>
            <p><a href="?" style="color: #00ffff;">Volver a ejecutar verificación</a></p>
        </div>
    </div>
</body>
</html>