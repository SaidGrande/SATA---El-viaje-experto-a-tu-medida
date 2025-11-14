% ===================================================================
% ===         BASE DE CONOCIMIENTO (AMPLIADA) - SATA V2           ===
% ===================================================================
%
% ESTRUCTURA:
% destino(ID, Nombre, Pais, [Tags], Presupuesto, Duracion, Temporada, Experiencia, Prioridad).
%
% --- Tags Posibles ---
% Intereses: cultura, historia, gastronomia, arte, urbano, naturaleza, aventura,
%            playa, animales, ecoturismo, montana, senderismo, buceo, esqui,
%            compras, fiesta, relajante, yoga, espiritual, arquitectura, musica,
%            tecnologia, fotografia, ruinas, volcan, termales, desierto.
% Compañía:  solo, pareja, amigos, familia, luna_de_miel.
%
% --- Valores Posibles ---
% Presupuesto: economico, moderado, confortable, lujo.
% Duracion:    fin_semana, semana, dos_semanas, mes_mas.
% Temporada:   verano, invierno, primavera, otono.
% Experiencia: cultural, aventura, relajante, lujo.
% Prioridad:   cultura, diversion, ahorro, comodidad.
%

% --- 1. Ciudades Culturales e Históricas ---
destino(roma, 'Roma', 'Italia', [historia, cultura, gastronomia, urbano, ruinas, arte, arquitectura, pareja, familia, amigos], moderado, semana, primavera, cultural, cultura).
destino(paris, 'París', 'Francia', [cultura, gastronomia, arte, urbano, arquitectura, museos, pareja, amigos, romantico], confortable, semana, primavera, cultural, cultura).
destino(kyoto, 'Kyoto', 'Japón', [cultura, historia, gastronomia, templos, naturaleza, jardines, solo, pareja], confortable, semana, primavera, cultural, cultura).
destino(cuzco, 'Cuzco & Machu Picchu', 'Perú', [historia, cultura, aventura, naturaleza, montana, ruinas, senderismo, solo, amigos], economico, semana, primavera, aventura, cultura).
destino(praga, 'Praga', 'República Checa', [historia, urbano, cultura, arquitectura, economico, amigos, pareja], economico, fin_semana, otono, cultural, ahorro).
destino(atenas, 'Atenas', 'Grecia', [historia, cultura, urbano, ruinas, gastronomia, cuna_civilizacion, pareja, solo], moderado, fin_semana, primavera, cultural, cultura).
destino(cairo, 'El Cairo y Giza', 'Egipto', [historia, cultura, ruinas, desierto, museos, bazares, solo, amigos], economico, semana, otono, cultural, cultura).
destino(estambul, 'Estambul', 'Turquía', [historia, cultura, urbano, gastronomia, compras, bazares, pareja, amigos], moderado, semana, primavera, cultural, cultura).
destino(florencia, 'Florencia', 'Italia', [arte, historia, cultura, gastronomia, urbano, arquitectura, renacimiento, pareja], confortable, fin_semana, primavera, cultural, cultura).
destino(cracovia, 'Cracovia', 'Polonia', [historia, cultura, urbano, economico, segunda_guerra_mundial, amigos, solo], economico, fin_semana, verano, cultural, ahorro).
destino(viena, 'Viena', 'Austria', [cultura, musica, historia, urbano, arquitectura, palacios, pareja], confortable, fin_semana, invierno, cultural, cultura).
destino(edimburgo, 'Edimburgo', 'Escocia', [urbano, historia, cultura, paisajes, castillos, literatura, amigos, pareja], moderado, fin_semana, verano, cultural, cultura).

% --- 2. Grandes Ciudades (Urbanas y Modernas) ---
destino(nueva_york, 'Nueva York', 'EE.UU.', [urbano, cultura, compras, gastronomia, museos, teatro, amigos, pareja], confortable, semana, otono, cultural, diversion).
destino(tokio, 'Tokio', 'Japón', [urbano, cultura, gastronomia, moderno, tecnologia, compras, anime, solo, amigos], confortable, dos_semanas, primavera, cultural, cultura).
destino(londres, 'Londres', 'Reino Unido', [urbano, cultura, historia, compras, museos, teatro, pubs, amigos, familia], confortable, semana, verano, cultural, cultura).
destino(berlin, 'Berlín', 'Alemania', [urbano, historia, cultura, fiesta, moderno, arte_callejero, museos, amigos, solo], moderado, fin_semana, verano, cultural, diversion).
destino(singapur, 'Singapur', 'Singapur', [urbano, moderno, gastronomia, compras, lujo, jardines, familia, pareja], confortable, fin_semana, otono, lujo, comodidad).
destino(seul, 'Seúl', 'Corea del Sur', [urbano, moderno, cultura, kpop, gastronomia, compras, tecnologia, amigos, solo], moderado, semana, otono, cultural, diversion).
destino(sidney, 'Sídney', 'Australia', [urbano, playa, paisajes, aventura, opera, familia, amigos], confortable, semana, verano, aventura, diversion).
destino(amsterdam, 'Ámsterdam', 'Países Bajos', [urbano, cultura, canales, museos, bicicletas, amigos, pareja], moderado, fin_semana, primavera, cultural, cultura).
destino(barcelona, 'Barcelona', 'España', [urbano, cultura, arquitectura, gaudi, gastronomia, playa, amigos, pareja], moderado, semana, primavera, cultural, cultura).
destino(buenos_aires, 'Buenos Aires', 'Argentina', [urbano, cultura, gastronomia, tango, noche, arquitectura, amigos, pareja], economico, semana, primavera, cultural, diversion).
destino(chicago, 'Chicago', 'EE.UU.', [urbano, arquitectura, museos, gastronomia, musica, jazz, amigos], confortable, fin_semana, verano, cultural, cultura).

% --- 3. Aventura y Naturaleza Extrema ---
destino(costa_rica, 'Costa Rica (Manuel Antonio)', 'Costa Rica', [naturaleza, aventura, playa, animales, ecoturismo, selva, familia, pareja], moderado, semana, invierno, aventura, diversion).
destino(queenstown, 'Queenstown', 'Nueva Zelanda', [aventura, naturaleza, deportes_extremos, montana, paisajes, amigos, solo], confortable, dos_semanas, verano, aventura, diversion).
destino(banff, 'Parque Nacional Banff', 'Canadá', [naturaleza, montana, senderismo, animales, paisajes, lagos, solo, familia], moderado, semana, verano, aventura, diversion).
destino(islandia, 'Islandia (Círculo Dorado)', 'Islandia', [naturaleza, paisajes, aventura, aurora_boreal, glaciares, volcan, solo, pareja], confortable, semana, invierno, aventura, diversion).
destino(patagonia, 'Patagonia (Torres del Paine)', 'Chile', [naturaleza, aventura, senderismo, montana, paisajes, glaciares, solo, amigos], confortable, dos_semanas, verano, aventura, diversion).
destino(interlaken, 'Interlaken', 'Suiza', [aventura, montana, naturaleza, deportes_extremos, paisajes, parapente, amigos, solo], confortable, semana, verano, aventura, diversion).
destino(serengeti, 'Safari Serengeti', 'Tanzania', [aventura, naturaleza, animales, safari, fotografia, familia, pareja], lujo, semana, verano, aventura, diversion).
destino(fiordos_noruegos, 'Fiordos Noruegos (Bergen)', 'Noruega', [naturaleza, paisajes, senderismo, crucero, kayak, pareja, familia], confortable, semana, verano, aventura, diversion).
destino(salar_de_uyuni, 'Salar de Uyuni', 'Bolivia', [naturaleza, paisajes, aventura, desierto, fotografia, solo, amigos], economico, fin_semana, primavera, aventura, diversion).
destino(cataratas_iguazu, 'Cataratas del Iguazú', 'Argentina/Brasil', [naturaleza, aventura, agua, paisajes, animales, familia, pareja], moderado, fin_semana, primavera, aventura, diversion).
destino(gran_canon, 'Gran Cañón', 'EE.UU.', [naturaleza, paisajes, senderismo, aventura, desierto, familia, amigos], moderado, fin_semana, otono, aventura, diversion).

% --- 4. Playa, Sol y Relajo ---
destino(cancun, 'Cancún & Riviera Maya', 'México', [playa, diversion, fiesta, todo_incluido, ruinas, cenotes, amigos, pareja, familia], moderado, semana, verano, relajante, diversion).
destino(bali, 'Bali (Seminyak/Canggu)', 'Indonesia', [playa, cultura, diversion, surf, gastronomia, economico, solo, pareja], economico, dos_semanas, primavera, relajante, ahorro).
destino(phuket, 'Phuket', 'Tailandia', [playa, diversion, fiesta, gastronomia, islas, economico, amigos, pareja], economico, semana, invierno, diversion, diversion).
destino(fiyi, 'Islas Fiyi', 'Fiyi', [playa, relajante, buceo, snorkel, pareja, luna_de_miel, familia], confortable, semana, invierno, relajante, comodidad).
destino(santorini, 'Santorini', 'Grecia', [playa, relajante, pareja, paisajes, luna_de_miel, arquitectura, gastronomia], confortable, semana, verano, relajante, comodidad).
destino(creta, 'Creta', 'Grecia', [playa, historia, cultura, gastronomia, ruinas, senderismo, familia, pareja], moderado, semana, verano, relajante, cultura).
destino(zanzibar, 'Zanzíbar', 'Tanzania', [playa, cultura, historia, especias, buceo, economico, pareja], moderado, semana, invierno, relajante, cultura).
destino(tulum, 'Tulum', 'México', [playa, relajante, ruinas, bohemio, yoga, cenotes, pareja, amigos], confortable, semana, invierno, relajante, diversion).
destino(algarve, 'Algarve', 'Portugal', [playa, relajante, golf, gastronomia, cuevas, familia, pareja], moderado, semana, verano, relajante, comodidad).
destino(boracay, 'Boracay', 'Filipinas', [playa, relajante, diversion, economico, deportes_acuaticos, amigos, pareja], economico, semana, invierno, relajante, diversion).

% --- 5. Lujo y Exclusividad ---
destino(maldivas, 'Maldivas', 'Maldivas', [playa, relajante, lujo, buceo, snorkel, pareja, luna_de_miel, bungalows], lujo, semana, invierno, lujo, comodidad).
destino(dubai, 'Dubái', 'E.A.U.', [urbano, lujo, moderno, desierto, compras, arquitectura, familia, pareja], lujo, semana, invierno, lujo, comodidad).
destino(bora_bora, 'Bora Bora', 'Polinesia Francesa', [lujo, playa, relajante, pareja, luna_de_miel, buceo, bungalows], lujo, semana, verano, lujo, comodidad).
destino(st_moritz, 'St. Moritz', 'Suiza', [lujo, invierno, esqui, montana, paisajes, compras, pareja], lujo, semana, invierno, lujo, comodidad).
destino(aspen, 'Aspen', 'EE.UU.', [lujo, invierno, esqui, montana, compras, celebridades, pareja], lujo, semana, invierno, lujo, comodidad).
destino(monaco, 'Mónaco', 'Mónaco', [lujo, urbano, casino, pareja, compras, formula_1], lujo, fin_semana, verano, lujo, comodidad).
destino(los_cabos, 'Los Cabos', 'México', [playa, lujo, diversion, pareja, amigos, golf, pesca], lujo, semana, invierno, lujo, diversion).
destino(seychelles, 'Seychelles', 'Seychelles', [playa, lujo, relajante, naturaleza, rocas_granito, pareja, luna_de_miel], lujo, semana, primavera, lujo, comodidad).

% --- 6. Ecoturismo y Bienestar (Yoga/Relajante) ---
destino(ubud, 'Ubud (Bali)', 'Indonesia', [relajante, cultura, naturaleza, yoga, espiritual, gastronomia, arte, solo, pareja], economico, semana, primavera, relajante, cultura).
destino(sedona, 'Sedona', 'EE.UU.', [relajante, naturaleza, espiritual, senderismo, paisajes, vortex, pareja, solo], confortable, fin_de_semana, primavera, relajante, comodidad).
destino(la_fortuna, 'La Fortuna (Arenal)', 'Costa Rica', [relajante, aventura, naturaleza, volcan, termales, cascadas, familia, pareja], moderado, semana, invierno, relajante, diversion).
destino(monteverde, 'Monteverde', 'Costa Rica', [ecoturismo, naturaleza, aventura, animales, senderismo, puentes_colgantes, familia, solo], moderado, semana, invierno, aventura, diversion).
destino(galapagos, 'Islas Galápagos', 'Ecuador', [naturaleza, animales, ecoturismo, buceo, evolucion, familia, pareja], lujo, semana, primavera, aventura, cultura).
destino(buta, 'Bután', 'Bután', [cultura, naturaleza, espiritual, senderismo, montana, felicidad, monasterios, solo], lujo, dos_semanas, otono, cultural, cultura).

% --- 7. Foco Gastronómico ---
destino(san_sebastian, 'San Sebastián', 'España', [gastronomia, playa, cultura, urbano, pintxos, surf, pareja, amigos], confortable, fin_de_semana, verano, cultural, cultura).
destino(lima, 'Lima', 'Perú', [gastronomia, cultura, urbano, historia, ceviche, pareja, amigos], moderado, fin_de_semana, primavera, cultural, cultura).
destino(lyon, 'Lyon', 'Francia', [gastronomia, cultura, urbano, historia, arquitectura, pareja], moderado, fin_de_semana, otono, cultural, cultura).
destino(bolonia, 'Bolonia', 'Italia', [gastronomia, cultura, urbano, historia, pasta, emilia_romagna, amigos, solo], moderado, fin_de_semana, otono, cultural, cultura).
destino(copenhague, 'Copenhague', 'Dinamarca', [gastronomia, urbano, cultura, moderno, diseno, bicicletas, pareja], confortable, fin_de_semana, verano, cultural, cultura).
destino(oaxaca, 'Oaxaca', 'México', [cultura, gastronomia, historia, mezcal, mole, artesanias, solo, pareja], economico, semana, otono, cultural, cultura).
destino(napoles, 'Nápoles', 'Italia', [gastronomia, cultura, historia, urbano, pizza, pompeya, amigos, solo], economico, fin_de_semana, primavera, cultural, ahorro).

% --- 8. Escapadas Económicas (Ahorro) ---
destino(budapest, 'Budapest', 'Hungría', [urbano, cultura, historia, termales, economico, fiesta, ruinas, amigos, pareja], economico, fin_de_semana, otono, cultural, ahorro).
destino(lisboa, 'Lisboa', 'Portugal', [urbano, cultura, gastronomia, historia, economico, fado, tranvias, pareja, amigos], economico, fin_de_semana, primavera, cultural, ahorro).
destino(hanoi, 'Hanoi', 'Vietnam', [cultura, gastronomia, urbano, historia, economico, motos, solo, amigos], economico, semana, otono, cultural, ahorro).
destino(chiang_mai, 'Chiang Mai', 'Tailandia', [cultura, naturaleza, gastronomia, templos, elefantes, economico, solo, pareja], economico, semana, invierno, cultural, ahorro).
destino(cartagena, 'Cartagena', 'Colombia', [playa, cultura, historia, urbano, colonial, diversion, amigos, pareja], economico, semana, invierno, cultural, diversion).
destino(marrakech, 'Marrakech', 'Marruecos', [cultura, exotico, gastronomia, compras, bazares, desierto, pareja, amigos], economico, fin_de_semana, otono, cultural, cultura).
destino(ciudad_de_mexico, 'Ciudad de México', 'México', [urbano, cultura, gastronomia, historia, museos, antropologia, amigos, solo], economico, semana, primavera, cultural, cultura).