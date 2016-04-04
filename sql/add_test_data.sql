INSERT INTO Opettaja (nimi, salasana) VALUES ('Santeri', 'Santeri123');

INSERT INTO Tyoaihe (nimi, kuvaus) VALUES ('Työaihe', 'Tämä on testi ehheh');

INSERT INTO Suoritus (tyoaihe_id, opettaja_id, suoritusaika, arvosana) VALUES (1, 1, 40, 4);

INSERT INTO Laboratoriokurssi (opettaja_id, nimi) VALUES (1, 'testikurssi');

INSERT INTO Yhteenveto (laboratoriokurssi_id) VALUES (1);

INSERT INTO Labratyoaihe VALUES (1, 1); 