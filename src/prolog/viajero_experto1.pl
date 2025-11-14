% Sistema Experto para determinar tipo de viajero
% Autor: Sistema SATA
% Fecha: 2025

% Cargar los hechos del usuario desde el archivo generado por PHP
:- consult('hechos_usuario.pl').

% Reglas para determinar el tipo de viajero

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

% Reglas para determinar la compañía preferida

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

% Descripciones de los tipos de viajero
descripcion_viajero(cultural, 'El viajero cultural busca entender la esencia de cada destino. Le interesan las costumbres, la historia, la gastronomía local y la interacción con habitantes del lugar.').
descripcion_viajero(extremo, 'El viajero extremo busca emociones fuertes. No se conforma con ver el paisaje, quiere vivirlo hasta el límite. Ama los deportes de riesgo y la adrenalina.').
descripcion_viajero(tranquilo, 'El viajero tranquilo disfruta de momentos de calma y relajación en destinos serenos. Busca conectar con la serenidad del entorno.').
descripcion_viajero(natural, 'El viajero natural ama la naturaleza y busca conectarse con paisajes vírgenes. Disfruta del senderismo y actividades al aire libre.').

% Descripciones de compañía
descripcion_compania(solitario, 'Prefieres viajar solo, disfrutando de tu libertad y autodescubrimiento.').
descripcion_compania(familiar, 'Viajas en familia, creando recuerdos inolvidables con tus seres queridos.').
descripcion_compania(amigos, 'Te gusta viajar con amigos, compartiendo aventuras y risas.').
descripcion_compania(pareja, 'Prefieres viajar en pareja, disfrutando de momentos románticos.').

% Predicado para determinar el tipo de viajero
determinar_tipo(Tipo) :-
    (viajero_cultural -> Tipo = 'Cultural'
    ; viajero_extremo -> Tipo = 'Extremo'
    ; viajero_tranquilo -> Tipo = 'Tranquilo'
    ; viajero_natural -> Tipo = 'Natural'
    ; Tipo = 'Mixto').

% Predicado para determinar la compañía
determinar_compania(Compania) :-
    (compania_solitario -> Compania = 'Solitario'
    ; compania_familiar -> Compania = 'Familiar'
    ; compania_amigos -> Compania = 'Amigos'
    ; compania_pareja -> Compania = 'Pareja'
    ; Compania = 'Flexible').

% Predicado principal que determina el perfil completo
determinar_perfil :-
    determinar_tipo(Tipo),
    determinar_compania(Compania),
    open('../temp/resultado.txt', write, Stream),
    format(Stream, 'Tipo de Viajero: ~w~n', [Tipo]),
    format(Stream, 'Compañía Preferida: ~w~n', [Compania]),
    close(Stream),
    format('Perfil determinado: ~w - ~w~n', [Tipo, Compania]).

% Predicado para consultar información sobre un tipo de viajero
consultar_tipo(Tipo) :-
    descripcion_viajero(Tipo, Descripcion),
    format('~w: ~w~n', [Tipo, Descripcion]).

% Predicado para listar todos los tipos de viajero
listar_tipos :-
    write('Tipos de viajero disponibles:'), nl,
    descripcion_viajero(Tipo, Descripcion),
    format('- ~w: ~w~n', [Tipo, Descripcion]),
    fail.
listar_tipos.

% Predicado para obtener recomendaciones basadas en el perfil
recomendar_destinos(Tipo, Destinos) :-
    (Tipo = 'Cultural' -> 
        Destinos = ['Roma, Italia', 'Kyoto, Japón', 'Atenas, Grecia', 'Ciudad de México']
    ; Tipo = 'Extremo' ->
        Destinos = ['Queenstown, Nueva Zelanda', 'Interlaken, Suiza', 'Costa Rica', 'Moab, Utah']
    ; Tipo = 'Tranquilo' ->
        Destinos = ['Bali, Indonesia', 'Maldivas', 'Toscana, Italia', 'Santorini, Grecia']
    ; Tipo = 'Natural' ->
        Destinos = ['Patagonia, Argentina', 'Islandia', 'Parques Nacionales de Costa Rica', 'Noruega']
    ; Destinos = ['Destino personalizado según tus preferencias']).

% Predicado para obtener actividades recomendadas
recomendar_actividades(Tipo, Actividades) :-
    (Tipo = 'Cultural' ->
        Actividades = ['Visitas guiadas a museos', 'Tours gastronómicos', 'Clases de cocina local', 'Intercambios culturales']
    ; Tipo = 'Extremo' ->
        Actividades = ['Paracaidismo', 'Rafting', 'Escalada en roca', 'Bungee jumping']
    ; Tipo = 'Tranquilo' ->
        Actividades = ['Spa y masajes', 'Yoga y meditación', 'Paseos en la playa', 'Lectura y relajación']
    ; Tipo = 'Natural' ->
        Actividades = ['Senderismo', 'Observación de aves', 'Camping', 'Fotografía de naturaleza']
    ; Actividades = ['Actividades variadas según tus intereses']).

% Predicado para análisis avanzado del perfil
analisis_completo :-
    determinar_tipo(Tipo),
    determinar_compania(Compania),
    recomendar_destinos(Tipo, Destinos),
    recomendar_actividades(Tipo, Actividades),
    open('analisis_completo.txt', write, Stream),
    format(Stream, '=== ANÁLISIS COMPLETO DE PERFIL DE VIAJERO ===~n~n', []),
    format(Stream, 'Tipo de Viajero: ~w~n', [Tipo]),
    format(Stream, 'Compañía Preferida: ~w~n~n', [Compania]),
    format(Stream, 'Destinos Recomendados:~n', []),
    escribir_lista(Stream, Destinos),
    format(Stream, '~nActividades Recomendadas:~n', []),
    escribir_lista(Stream, Actividades),
    close(Stream).

% Predicado auxiliar para escribir listas
escribir_lista(_, []).
escribir_lista(Stream, [H|T]) :-
    format(Stream, '  - ~w~n', [H]),
    escribir_lista(Stream, T).

% Predicado para debugging - mostrar todas las respuestas
mostrar_respuestas :-
    write('Respuestas del usuario:'), nl,
    respuesta(Pregunta, Valor),
    format('  ~w: ~w~n', [Pregunta, Valor]),
    fail.
mostrar_respuestas.