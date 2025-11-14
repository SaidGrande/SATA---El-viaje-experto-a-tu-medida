% ===================================================================
% ===           MOTOR DE INFERENCIA - SISTEMA SATA V2             ===
% ===================================================================
% Este motor toma las respuestas del usuario y datos prácticos
% para recomendar 8 destinos personalizados.

% Cargar archivos de conocimiento
:- dynamic respuesta/2.
:- dynamic presupuesto/1.
:- dynamic duracion/1.
:- dynamic temporada/1.
:- dynamic experiencia/1.
:- dynamic prioridad/1.

:- consult('hechos_usuario.pl').
:- consult('datos_practicos.pl').
:- consult('destinos.pl').

% ===================================================================
% === MAPEO DE RESPUESTAS A TAGS
% ===================================================================

% Cultural
tag_usuario(cultura) :- respuesta(museos, si).
tag_usuario(historia) :- respuesta(museos, si).
tag_usuario(arte) :- respuesta(museos, si).
tag_usuario(gastronomia) :- respuesta(gastronomia, si).
tag_usuario(urbano) :- respuesta(interaccion, si).

% Extremo/Aventura
tag_usuario(aventura) :- respuesta(adrenalina, si).
tag_usuario(deportes_extremos) :- respuesta(extremo, si).
tag_usuario(montana) :- respuesta(extremo, si).

% Tranquilo/Relajante
tag_usuario(relajante) :- respuesta(relajacion, si).
tag_usuario(playa) :- respuesta(tranquilo, si).
tag_usuario(yoga) :- respuesta(relajacion, si).
tag_usuario(espiritual) :- respuesta(tranquilo, si).

% Natural
tag_usuario(naturaleza) :- respuesta(naturaleza, si).
tag_usuario(senderismo) :- respuesta(senderismo, si).
tag_usuario(ecoturismo) :- respuesta(naturaleza, si).
tag_usuario(animales) :- respuesta(naturaleza, si).
tag_usuario(paisajes) :- respuesta(senderismo, si).

% Compañía
tag_usuario(solo) :- respuesta(solo, si).
tag_usuario(familia) :- respuesta(familia, si).
tag_usuario(amigos) :- respuesta(amigos, si).
tag_usuario(pareja) :- respuesta(pareja, si).

% ===================================================================
% === SISTEMA DE SCORING
% ===================================================================

% Obtener todos los tags del usuario (sin duplicados)
tags_de_interes(Tags) :-
    findall(Tag, tag_usuario(Tag), TagsConDuplicados),
    list_to_set(TagsConDuplicados, Tags).

% Contar cuántos tags coinciden
contar_coincidencias(TagsDestino, TagsUsuario, Coincidencias) :-
    intersection(TagsUsuario, TagsDestino, TagsComunes),
    length(TagsComunes, Coincidencias).

% Calcular puntuación de un destino
calcular_score(ID, Score) :-
    destino(ID, _, _, TagsDestino, PresupuestoDest, DuracionDest, TemporadaDest, ExperienciaDest, PrioridadDest),
    tags_de_interes(TagsUsuario),
    presupuesto(PresupuestoUser),
    duracion(DuracionUser),
    temporada(TemporadaUser),
    experiencia(ExperienciaUser),
    prioridad(PrioridadUser),
    
    % Puntos por tags coincidentes (máx 50 puntos)
    contar_coincidencias(TagsDestino, TagsUsuario, NumTagsComunes),
    ScoreTags is min(50, NumTagsComunes * 5),
    
    % Puntos por presupuesto (30 puntos si coincide exactamente)
    (PresupuestoUser = PresupuestoDest -> ScorePresupuesto = 30 ; ScorePresupuesto = 0),
    
    % Puntos por duración (10 puntos si coincide)
    (DuracionUser = DuracionDest -> ScoreDuracion = 10 ; ScoreDuracion = 0),
    
    % Puntos por temporada (10 puntos si coincide)
    (TemporadaUser = TemporadaDest -> ScoreTemporada = 10 ; ScoreTemporada = 0),
    
    % Puntos por experiencia (15 puntos si coincide)
    (ExperienciaUser = ExperienciaDest -> ScoreExperiencia = 15 ; ScoreExperiencia = 0),
    
    % Puntos por prioridad (10 puntos si coincide)
    (PrioridadUser = PrioridadDest -> ScorePrioridad = 10 ; ScorePrioridad = 0),
    
    % Score total (máximo 125 puntos)
    Score is ScoreTags + ScorePresupuesto + ScoreDuracion + ScoreTemporada + ScoreExperiencia + ScorePrioridad.

% ===================================================================
% === UTILIDADES
% ===================================================================

% Tomar los primeros N elementos de una lista
take(0, _, []) :- !.
take(_, [], []) :- !.
take(N, [H|T], [H|R]) :-
    N > 0,
    N1 is N - 1,
    take(N1, T, R).

% Extraer solo los IDs de la lista Score-ID
extraer_ids([], []).
extraer_ids([_-ID|T], [ID|R]) :-
    extraer_ids(T, R).

% ===================================================================
% === RECOMENDACIÓN DE DESTINOS
% ===================================================================

% Encontrar los mejores N destinos
recomendar_destinos(N, DestinosRecomendados) :-
    findall(Score-ID, calcular_score(ID, Score), Scores),
    sort(0, @>=, Scores, ScoresOrdenados),
    take(N, ScoresOrdenados, TopN),
    extraer_ids(TopN, DestinosRecomendados).

% ===================================================================
% === PREDICADO PRINCIPAL
% ===================================================================

main :-
    recomendar_destinos(8, Destinos),
    imprimir_destinos(Destinos),
    halt.

% Imprimir cada destino en una línea
imprimir_destinos([]).
imprimir_destinos([ID|Resto]) :-
    writeln(ID),
    imprimir_destinos(Resto).

% ===================================================================
% === PREDICADOS DE DEBUGGING
% ===================================================================

% Mostrar todos los scores ordenados
debug_scores :-
    findall(Score-ID-Nombre, (
        calcular_score(ID, Score),
        destino(ID, Nombre, _, _, _, _, _, _, _)
    ), Scores),
    sort(0, @>=, Scores, ScoresOrdenados),
    write('=== SCORES DE DESTINOS ==='), nl,
    imprimir_scores(ScoresOrdenados).

imprimir_scores([]).
imprimir_scores([Score-ID-Nombre|Resto]) :-
    format('~w puntos: ~w (~w)~n', [Score, Nombre, ID]),
    imprimir_scores(Resto).

% Ver qué tags tiene el usuario
debug_tags :-
    tags_de_interes(Tags),
    write('Tags del usuario: '), writeln(Tags).

% Ver datos prácticos
debug_datos :-
    presupuesto(P),
    duracion(D),
    temporada(T),
    experiencia(E),
    prioridad(Pr),
    format('Presupuesto: ~w~n', [P]),
    format('Duración: ~w~n', [D]),
    format('Temporada: ~w~n', [T]),
    format('Experiencia: ~w~n', [E]),
    format('Prioridad: ~w~n', [Pr]).