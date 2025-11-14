% Sistema Experto de Recomendaciones de Destinos
% Autor: Sistema SATA
% Fecha: 2025

% Cargar archivos de datos del usuario (si existen)
:- catch(consult('hechos_usuario.pl'), _, true).
:- catch(consult('datos_practicos.pl'), _, true).

% ================================
% BASE DE CONOCIMIENTO - DESTINOS
% ================================

% destino(Nombre, Tipo, Presupuesto, Temporada, Experiencia, Descripcion, Actividades)

% DESTINOS CULTURALES
destino('Roma, Italia', cultural, moderado, primavera, cultural, 
    'Cuna de la civilizacion occidental con arte renacentista',
    'Coliseo, Vaticano, Foro Romano y pasta autentica').

destino('Kyoto, Japon', cultural, confortable, primavera, cultural,
    'Ciudad de templos zen y jardines tradicionales',
    'Ceremonia del te, templos dorados, jardines zen').

destino('Atenas, Grecia', cultural, moderado, verano, cultural,
    'Historia antigua viva con la Acropolis',
    'Parthenon, Agora antigua, museos y cocina mediterranea').

destino('Ciudad de Mexico', cultural, economico, otono, cultural,
    'Metropolis vibrante con historia azteca',
    'Piramides de Teotihuacan, Museo Frida Kahlo, tacos').

destino('Cusco, Peru', cultural, economico, verano, cultural,
    'Puerta a Machu Picchu con cultura inca viva',
    'Machu Picchu, Valle Sagrado, mercados tradicionales').

destino('Paris, Francia', cultural, lujo, primavera, lujo,
    'Capital del arte con el Louvre y Torre Eiffel',
    'Museos, cafes parisinos, gastronomia Michelin').

destino('Estambul, Turquia', cultural, moderado, otono, cultural,
    'Puente entre Europa y Asia con bazares milenarios',
    'Santa Sofia, Gran Bazar, crucero por Bosforo').

destino('Marrakech, Marruecos', cultural, economico, primavera, cultural,
    'Ciudad de especias y zocos coloridos',
    'Medina, jardines Majorelle, zocos y tagine').

% DESTINOS EXTREMOS
destino('Queenstown, Nueva Zelanda', extremo, confortable, verano, aventura,
    'Capital mundial de la aventura',
    'Bungee jumping, skydiving, jet boating y parapente').

destino('Interlaken, Suiza', extremo, confortable, verano, aventura,
    'Paraiso alpino de deportes extremos',
    'Paracaidismo sobre Alpes, parapente, rafting').

destino('Moab, Utah', extremo, moderado, primavera, aventura,
    'Desierto de canones rojos ideal para aventura',
    'Mountain biking, escalada en roca, rafting').

destino('Banos, Ecuador', extremo, economico, verano, aventura,
    'Ciudad andina perfecta para adrenalina',
    'Puenting, columpio del fin del mundo, canyoning').

destino('Chamonix, Francia', extremo, lujo, invierno, aventura,
    'Cuna del alpinismo con el Mont Blanc',
    'Heli-skiing, escalada en hielo, esqui extremo').

destino('Costa Rica', extremo, moderado, verano, aventura,
    'Pais de aventura con volcanes y selvas',
    'Zip-lining, rafting, surf y puentes colgantes').

destino('Patagonia Chilena', extremo, moderado, verano, aventura,
    'Torres del Paine con trekking epico',
    'Trekking W, escalada en hielo, kayak glaciar').

destino('Nepal Himalaya', extremo, economico, primavera, aventura,
    'Hogar del Everest con trekking legendario',
    'Trekking campo base Everest, rafting').

% DESTINOS TRANQUILOS
destino('Maldivas', tranquilo, lujo, invierno, lujo,
    'Paraiso de islas privadas con aguas cristalinas',
    'Snorkel, spa sobre el agua, cenas romanticas').

destino('Santorini, Grecia', tranquilo, confortable, verano, relajante,
    'Isla de casas blancas con puestas de sol',
    'Contemplar atardeceres, vinos locales, Oia').

destino('Ubud, Bali', tranquilo, moderado, verano, relajante,
    'Centro espiritual de Bali',
    'Yoga, meditacion, templos, masajes balineses').

destino('Toscana, Italia', tranquilo, confortable, primavera, relajante,
    'Colinas ondulantes con vinedos',
    'Catas de vino, cocina italiana, vinedos').

destino('Tulum, Mexico', tranquilo, moderado, invierno, relajante,
    'Playas caribenas con ruinas mayas',
    'Yoga en la playa, cenotes, masajes').

destino('Bora Bora', tranquilo, lujo, verano, lujo,
    'Laguna turquesa con bungalows sobre agua',
    'Buceo, spa de lujo, cenas privadas').

destino('Seychelles', tranquilo, lujo, verano, lujo,
    'Archipielago de playas virgenes',
    'Playas privadas, snorkel, spa').

destino('Kyoto Templos Zen', tranquilo, moderado, otono, relajante,
    'Retiro espiritual en templos tradicionales',
    'Meditacion zen, jardines, banos termales').

% DESTINOS NATURALES
destino('Islandia', natural, confortable, verano, aventura,
    'Tierra de hielo y fuego con glaciares',
    'Cascadas, auroras boreales, aguas termales').

destino('Patagonia Argentina', natural, moderado, verano, aventura,
    'Glaciares imponentes y paisajes virgenes',
    'Glaciar Perito Moreno, trekking, fauna').

destino('Parques Nacionales USA', natural, moderado, verano, aventura,
    'Yellowstone, Yosemite y Grand Canyon',
    'Geiseres, cascadas, canones, vida salvaje').

destino('Costa Rica Natural', natural, economico, verano, aventura,
    'Biodiversidad increible con volcanes',
    'Senderismo en volcanes, fauna, playas').

destino('Fiordos de Noruega', natural, lujo, verano, lujo,
    'Fiordos espectaculares con naturaleza nordica',
    'Cruceros de lujo, senderismo, auroras').

destino('Amazonas Brasil', natural, economico, verano, aventura,
    'Selva tropical mas grande del mundo',
    'Expediciones en canoa, fauna, comunidades').

destino('Galapagos Ecuador', natural, confortable, invierno, aventura,
    'Islas con fauna unica',
    'Snorkel con tortugas, lobos marinos, iguanas').

destino('Nueva Zelanda Sur', natural, confortable, verano, aventura,
    'Paisajes de pelicula',
    'Fiordos Milford Sound, glaciares, lagos').

% ================================
% DETERMINACIÓN DEL TIPO DE VIAJERO
% ================================

determinar_tipo(cultural) :-
    respuesta(museos, si),
    respuesta(gastronomia, si),
    respuesta(interaccion, si), !.

determinar_tipo(extremo) :-
    respuesta(adrenalina, si),
    respuesta(extremo, si), !.

determinar_tipo(tranquilo) :-
    respuesta(relajacion, si),
    respuesta(tranquilo, si), !.

determinar_tipo(natural) :-
    respuesta(naturaleza, si),
    respuesta(senderismo, si), !.

determinar_tipo(mixto).

% ================================
% COMPATIBILIDAD Y PUNTUACIÓN
% ================================

compatibilidad_destino(Nombre, Puntos) :-
    destino(Nombre, TipoD, PresupuestoD, TemporadaD, ExperienciaD, _, _),
    determinar_tipo(TipoU),
    presupuesto(PresupuestoU),
    temporada(TemporadaU),
    experiencia(ExperienciaU),
    calcular_puntos(TipoD, TipoU, PresupuestoD, PresupuestoU, TemporadaD, TemporadaU, ExperienciaD, ExperienciaU, Puntos).

calcular_puntos(TipoD, TipoU, PresupD, PresupU, TempD, TempU, ExpD, ExpU, Total) :-
    (TipoD = TipoU -> PT = 40 ; PT = 0),
    (PresupD = PresupU -> PP = 30 ; PP = 0),
    (TempD = TempU -> PTe = 15 ; PTe = 0),
    (ExpD = ExpU -> PE = 15 ; PE = 0),
    Total is PT + PP + PTe + PE.

% ================================
% GENERACIÓN DE RECOMENDACIONES INICIALES
% ================================

generar_recomendaciones_iniciales :-
    findall([Puntos, Nombre], compatibilidad_destino(Nombre, Puntos), Lista),
    msort(Lista, ListaOrdenada),
    reverse(ListaOrdenada, ListaDesc),
    tomar_n(12, ListaDesc, Mejores),
    open('recomendaciones_iniciales.txt', write, Stream),
    escribir_lista_inicial(Stream, Mejores),
    close(Stream).

tomar_n(0, _, []) :- !.
tomar_n(_, [], []) :- !.
tomar_n(N, [H|T], [H|R]) :-
    N > 0,
    N1 is N - 1,
    tomar_n(N1, T, R).

escribir_lista_inicial(_, []).
escribir_lista_inicial(Stream, [[_, Nombre]|T]) :-
    format(Stream, 'DESTINO: ~w~n', [Nombre]),
    escribir_lista_inicial(Stream, T).

% ================================
% GENERACIÓN DE RECOMENDACIONES FINALES
% ================================

generar_recomendaciones_finales :-
    consult('seleccion_destinos.pl'),
    findall(Tipo, (destino_favorito(N), destino(N, Tipo, _, _, _, _, _)), Tipos),
    findall(Pres, (destino_favorito(N), destino(N, _, Pres, _, _, _, _)), Presupuestos),
    findall(Temp, (destino_favorito(N), destino(N, _, _, Temp, _, _, _)), Temporadas),
    findall(Exp, (destino_favorito(N), destino(N, _, _, _, Exp, _, _)), Experiencias),
    mas_comun(Tipos, TipoC),
    mas_comun(Presupuestos, PresupuestoC),
    mas_comun(Temporadas, TemporadaC),
    mas_comun(Experiencias, ExperienciaC),
    
    % Encontrar destinos similares con puntuación
    findall([Puntos, N, D, A], 
        (destino(N, TipoD, PresupD, TempD, ExpD, D, A),
         \+ destino_favorito(N),
         calcular_similitud(TipoD, PresupD, TempD, ExpD, TipoC, PresupuestoC, TemporadaC, ExperienciaC, Puntos)), 
        SimilaresConPuntos),
    
    % Ordenar por puntuación
    msort(SimilaresConPuntos, ListaOrdenada),
    reverse(ListaOrdenada, ListaDesc),
    
    % Tomar TOP 3
    tomar_n(3, ListaDesc, Top3),
    
    % Guardar TOP 3
    open('recomendaciones_finales.txt', write, Stream),
    format(Stream, 'TOP 3 DESTINOS RECOMENDADOS~n', []),
    format(Stream, '===========================~n~n', []),
    escribir_top3(Stream, Top3, TipoC, ExperienciaC),
    close(Stream).

% Calcular similitud entre destino y patrón del usuario
calcular_similitud(TipoD, PresupD, TempD, ExpD, TipoU, PresupU, TempU, ExpU, Total) :-
    (TipoD = TipoU -> PT = 50 ; PT = 0),
    (PresupD = PresupU -> PP = 30 ; PP = 0),
    (TempD = TempU -> PTe = 15 ; PTe = 0),
    (ExpD = ExpU -> PE = 5 ; PE = 0),
    Total is PT + PP + PTe + PE.

% Escribir TOP 3
escribir_top3(_, [], _, _).
escribir_top3(Stream, [[Puntos, Nom, Desc, Act]|T], Tipo, Exp) :-
    length(T, Restantes),
    Posicion is 3 - Restantes,
    format(Stream, '~n*** POSICION #~w ***~n', [Posicion]),
    format(Stream, 'DESTINO: ~w~n', [Nom]),
    format(Stream, 'PUNTUACION: ~w puntos de compatibilidad~n', [Puntos]),
    format(Stream, 'DESCRIPCION: ~w~n', [Desc]),
    format(Stream, 'RAZON: Este destino coincide perfectamente con tu perfil ~w y tu preferencia por experiencias tipo ~w~n', [Tipo, Exp]),
    format(Stream, 'ACTIVIDADES: ~w~n', [Act]),
    format(Stream, '~n', []),
    escribir_top3(Stream, T, Tipo, Exp).

mas_comun([H|_], H) :- !.
mas_comun([], mixto).

escribir_lista_final(_, [], _, _).
escribir_lista_final(Stream, [[Nom, Desc, Act]|T], Tipo, Exp) :-
    format(Stream, 'DESTINO: ~w~n', [Nom]),
    format(Stream, 'DESCRIPCION: ~w~n', [Desc]),
    format(Stream, 'RAZON: Coincide con tu perfil ~w y preferencia ~w~n', [Tipo, Exp]),
    format(Stream, 'ACTIVIDADES: ~w~n~n', [Act]),
    escribir_lista_final(Stream, T, Tipo, Exp).