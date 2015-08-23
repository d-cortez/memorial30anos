SELECT 	p.ParoquiaDescricao, q.EncontroNumero, COUNT(q.`Sequencial`) AS Qtd, q.`DataInsercao`
FROM 	quadrante q, paroquia p
WHERE 	q.`ParoquiaCodigo` = p.`ParoquiaCodigo`
GROUP BY q.`ParoquiaCodigo`, q.EncontroNumero
ORDER BY 4 DESC

SELECT * FROM paroquia WHERE `ParoquiaDescricao` LIKE '%franc%'
SELECT * FROM encontro WHERE ParoquiaCodigo = 18

INSERT INTO `quadrante` (`ParoquiaCodigo`, `EncontroNumero`, `NomeCompleto`, `Cracha`)
SELECT 18, 10, nome, cracha FROM importacao WHERE LENGTH(nome)>0;



TRUNCATE importacao;
SELECT * FROM importacao;

LOAD DATA INFILE 'd:/import/santana_6.csv' 
INTO TABLE importacao
FIELDS TERMINATED BY ';';



UPDATE 	quadrante
SET 	`NomeCompleto` = TRIM(NomeCompleto);

SELECT * FROM quadrante
WHERE LENGTH (NomeCompleto) = 0
ORDER BY NomeCompleto;