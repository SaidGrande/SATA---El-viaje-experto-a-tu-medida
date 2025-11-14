% Sistema Experto para determinar tipo de viajero y recomendaciones
% Autor: Sistema SATA
% Fecha: 2025

% Cargar los hechos del usuario desde los archivos generados por PHP
:- [hechos_usuario].
:- [datos_practicos].

% ================================
% REGLAS PARA TIPO DE VIAJERO
% ================================

% Viajero Cultural
viajero_cultural :-
    respuesta(museos, si),
    respuesta(gastronomia, si),
    respuesta(interaccion, si).

% Viajero Extremo
viajero_extremo :-
    respuesta(adrenalina, si),
    respuesta(extremo, si).

% Viajero Tranquilo
viajero_tranquilo :-
    respuesta(relajacion, si),
    respuesta(tranquilo, si),
    respuesta(adrenalina, no).

% Viajero Natural
viajero_natural :-
    respuesta(naturaleza, si),
    respuesta(senderismo, si).

% ================================
% REGLAS PARA COMPAÑÍA
% ================================

% Viajero Solitario
compania_solitario :-
    respuesta(solo, si),
    respuesta(familia, no),
    respuesta(amigos, no),
    respuesta(pareja, no).

% Viajero Familiar
compania_familiar :-
    respuesta(familia, si).

% Viajero con Amigos
compania_amigos :-
    respuesta(amigos, si),
    respuesta(familia, no).

% Viajero en Pareja
compania_pareja :-
    respuesta(pareja, si),
    respuesta(familia, no),
    respuesta(amigos, no).

% ================================
% DESCRIPCIONES
% ================================

descripcion_viajero(cultural, 'El viajero cultural busca entender la esencia de cada destino. Le interesan las costumbres, la historia, la gastronomía local y la interacción con habitantes del lugar.').
descripcion_viajero(extremo, 'El viajero extremo busca emociones fuertes. No se conforma con ver el paisaje, quiere vivirlo hasta el límite. Ama los deportes de riesgo y la adrenalina.').
descripcion_viajero(tranquilo, 'El viajero tranquilo disfruta de momentos de calma y relajación en destinos serenos. Busca conectar con la serenidad del entorno.').
descripcion_viajero(natural, 'El viajero natural ama la naturaleza y busca conectarse con paisajes vírgenes. Disfruta del senderismo y actividades al aire libre.').

descripcion_compania(solitario, 'Prefieres viajar solo, disfrutando de tu libertad y autodescubrimiento.').
descripcion_compania(familiar, 'Viajas en familia, creando recuerdos inolvidables con tus seres queridos.').
descripcion_compania(amigos, 'Te gusta viajar con amigos, compartiendo aventuras y risas.').
descripcion_compania(pareja, 'Prefieres viajar en pareja, disfrutando de momentos románticos.').

% ================================
% DETERMINACIÓN DE PERFIL
% ================================

determinar_tipo(Tipo) :-
    (viajero_cultural -> Tipo = 'Cultural'
    ; viajero_extremo -> Tipo = 'Extremo'
    ; viajero_tranquilo -> Tipo = 'Tranquilo'
    ; viajero_natural -> Tipo = 'Natural'
    ; Tipo = 'Mixto').

determinar_compania(Compania) :-
    (compania_solitario -> Compania = 'Solitario'
    ; compania_familiar -> Compania = 'Familiar'
    ; compania_amigos -> Compania = 'Amigos'
    ; compania_pareja -> Compania = 'Pareja'
    ; Compania = 'Flexible').

determinar_perfil :-
    determinar_tipo(Tipo),
    determinar_compania(Compania),
    open('resultado.txt', write, Stream),
    format(Stream, 'Tipo de Viajero: ~w~n', [Tipo]),
    format(Stream, 'Compañía Preferida: ~w~n', [Compania]),
    close(Stream),
    format('Perfil determinado: ~w - ~w~n', [Tipo, Compania]).

% ================================
% RECOMENDACIONES DE DESTINOS
% ================================

% Destinos según tipo de viajero y presupuesto
destino(cultural, economico, 'Ciudad de México, México', 'Rica historia azteca, museos de clase mundial y gastronomía increíble a precios accesibles').
destino(cultural, economico, 'Cusco, Perú', 'Puerta a Machu Picchu, cultura inca viva y mercados tradicionales').
destino(cultural, moderado, 'Roma, Italia', 'Cuna de la civilización occidental, arte renacentista y cocina italiana auténtica').
destino(cultural, moderado, 'Atenas, Grecia', 'Historia antigua, Acrópolis y deliciosa comida mediterránea').
destino(cultural, confortable, 'Kyoto, Japón', 'Templos zen, jardines tradicionales y ceremonia del té').
destino(cultural, lujo, 'París, Francia', 'Capital del arte, Louvre, alta cocina y elegancia parisina').

destino(extremo, economico, 'Baños, Ecuador', 'Puenting, rafting y cañonismo en los Andes ecuatorianos').
destino(extremo, moderado, 'Queenstown, Nueva Zelanda', 'Capital mundial de la aventura: bungee, skydiving y jet boating').
destino(extremo, moderado, 'Interlaken, Suiza', 'Paracaidismo sobre los Alpes, parapente y deportes extremos').
destino(extremo, confortable, 'Moab, Utah, USA', 'Mountain biking, escalada en roca y rafting en cañones épicos').
destino(extremo, lujo, 'Chamonix, Francia', 'Heli-skiing, escalada del Mont Blanc y experiencias alpinas de élite').

destino(tranquilo, economico, 'Tulum, México', 'Playas caribeñas, ruinas mayas y ambiente relajado').
destino(tranquilo, moderado, 'Ubud, Bali', 'Retiros de yoga, terrazas de arroz y templos pacíficos').
destino(tranquilo, confortable, 'Santorini, Grecia', 'Vistas al mar Egeo, puestas de sol y tranquilidad mediterránea').
destino(tranquilo, confortable, 'Toscana, Italia', 'Viñedos, colinas ondulantes y pueblos medievales serenos').
destino(tranquilo, lujo, 'Maldivas', 'Resorts sobre el agua, spas de clase mundial y privacidad absoluta').

destino(natural, economico, 'Costa Rica', 'Volcanes, selvas tropicales, biodiversidad increíble').
destino(natural, moderado, 'Patagonia, Argentina', 'Glaciares imponentes, trekking y paisajes vírgenes').
destino(natural, moderado, 'Islandia', 'Cascadas, géiseres, auroras boreales y naturaleza salvaje').
destino(natural, confortable, 'Parques Nacionales de USA', 'Yellowstone, Yosemite, Grand Canyon - naturaleza épica').
destino(natural, lujo, 'Fiordos de Noruega', 'Cruceros de lujo por fiordos, naturaleza nórdica espectacular').

% Ajuste por duración
ajuste_duracion(fin_semana, 'Destinos cercanos o vuelos cortos (máximo 4 horas)').
ajuste_duracion(semana, 'Destinos regionales o continentales').
ajuste_duracion(dos_semanas, 'Destinos internacionales, posibilidad de combinar ciudades').
ajuste_duracion(mes_mas, 'Viajes largos, múltiples países o inmersión profunda').

% Ajuste por temporada
ajuste_temporada(verano, 'Playas, destinos costeros, festivales al aire libre').
ajuste_temporada(invierno, 'Esquí, montañas nevadas, destinos cálidos del hemisferio sur').
ajuste_temporada(primavera, 'Clima templado, flores en floración, menos turistas').
ajuste_temporada(otono, 'Colores otoñales, vendimia, temporada baja con mejores precios').

% ================================
% RECOMENDACIONES PERSONALIZADAS
% ================================

generar_recomendaciones :-
    determinar_tipo(Tipo),
    determinar_compania(Compania),
    presupuesto(Presupuesto),
    duracion(Duracion),
    temporada(Temporada),
    experiencia(Experiencia),
    prioridad(Prioridad),
    
    % Convertir tipo a minúsculas para matching
    downcase_atom(Tipo, TipoLower),
    
    % Encontrar destinos que coincidan
    findall(
        [Nombre, Desc],
        destino(TipoLower, Presupuesto, Nombre, Desc),
        Destinos
    ),
    
    % Generar archivo de recomendaciones
    open('recomendaciones.txt', write, Stream),
    format(Stream, 'PERFIL DEL VIAJERO~n', []),
    format(Stream, '==================~n~n', []),
    format(Stream, 'Tipo: ~w~n', [Tipo]),
    format(Stream, 'Compañía: ~w~n~n', [Compania]),
    
    format(Stream, 'DATOS DEL VIAJE~n', []),
    format(Stream, '===============~n~n', []),
    format(Stream, 'Presupuesto: ~w~n', [Presupuesto]),
    format(Stream, 'Duración: ~w~n', [Duracion]),
    format(Stream, 'Temporada: ~w~n', [Temporada]),
    format(Stream, 'Tipo de Experiencia: ~w~n', [Experiencia]),
    format(Stream, 'Prioridad: ~w~n~n', [Prioridad]),
    
    format(Stream, 'DESTINOS RECOMENDADOS~n', []),
    format(Stream, '=====================~n~n', []),
    escribir_destinos(Stream, Destinos),
    
    format(Stream, '~nCONSEJOS PERSONALIZADOS~n', []),
    format(Stream, '========================~n~n', []),
    ajuste_duracion(Duracion, ConsejoDuracion),
    format(Stream, 'Duración: ~w~n~n', [ConsejoDuracion]),
    ajuste_temporada(Temporada, ConsejoTemporada),
    format(Stream, 'Temporada: ~w~n', [ConsejoTemporada]),
    
    close(Stream),
    format('Recomendaciones generadas exitosamente~n', []).

% Predicado auxiliar para escribir destinos
escribir_destinos(_, []).
escribir_destinos(Stream, [[Nombre, Desc]|T]) :-
    format(Stream, '📍 ~w~n', [Nombre]),
    format(Stream, '   ~w~n~n', [Desc]),
    escribir_destinos(Stream, T).

% Predicado auxiliar para convertir a minúsculas
downcase_atom(Atom, Lower) :-
    atom_chars(Atom, Chars),
    maplist(downcase_char, Chars, LowerChars),
    atom_chars(Lower, LowerChars).

downcase_char(Upper, Lower) :-
    char_type(Upper, upper),
    char_type(Lower, lower),
    upcase_atom(Lower, Upper), !.
downcase_char(Char, Char).

% ================================
% CONSULTAS ÚTILES
% ================================

consultar_tipo(Tipo) :-
    descripcion_viajero(Tipo, Descripcion),
    format('~w: ~w~n', [Tipo, Descripcion]).

listar_tipos :-
    write('Tipos de viajero disponibles:'), nl,
    descripcion_viajero(Tipo, Descripcion),
    format('- ~w: ~w~n', [Tipo, Descripcion]),
    fail.
listar_tipos.

mostrar_respuestas :-
    write('Respuestas del usuario:'), nl,
    respuesta(Pregunta, Valor),
    format('  ~w: ~w~n', [Pregunta, Valor]),
    fail.
mostrar_respuestas.