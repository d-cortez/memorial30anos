SELECT	* FROM paroquia

TRUNCATE TABLE encontro
SELECT	* FROM encontro ORDER BY EncontroAno DESC

CALL GerarEncontro (1, 3, 1985); 	-- Natal
CALL GerarEncontro (2, 28, 1988); 	-- Sta terezinha
CALL GerarEncontro (3, 36, 1988); 	-- candelaria
CALL GerarEncontro (4, 6, 2010); 	-- Emaus
CALL GerarEncontro (5, 14, 2002); 	-- Dom Bosco
CALL GerarEncontro (6, 4, 2012); 	-- Anchieta
CALL GerarEncontro (7, 24, 1991); 	-- Nossa Senhora Aparecida
CALL GerarEncontro (8, 23, 1995); 	-- Nossa Senhora da Esperança
CALL GerarEncontro (9, 4, 2012); 	-- Nossa Senhora da Conceicao
CALL GerarEncontro (10, 8, 2008); 	-- Nossa Senhora de Lourdes

CALL GerarEncontro (11, 3, 2013); 	-- Nossa Senhora do Perpetuo Socorro
CALL GerarEncontro (12, 4, 2012); 	-- Sagrada Familia
CALL GerarEncontro (13, 4, 2012); 	-- Santa Luzia
CALL GerarEncontro (14, 22, 1992); 	-- Santa Rita de Cássia dos Impossíveis
CALL GerarEncontro (15, 18, 1996); 	-- Sant'Ana
CALL GerarEncontro (16, 26, 1989); 	-- Santo Afonso
CALL GerarEncontro (17, 4, 2012); 	-- Santo Antônio de Pádua
CALL GerarEncontro (18, 24, 1991); 	-- São Francisco de Assis
CALL GerarEncontro (19, 2, 2014); 	-- Diocese de Mossoro - Assu
CALL GerarEncontro (20, 11, 2005); 	-- São João Batista
CALL GerarEncontro (21, 4, 2012); 	-- São Paulo Apóstolo
CALL GerarEncontro (22, 27, 1989); 	-- São Pedro