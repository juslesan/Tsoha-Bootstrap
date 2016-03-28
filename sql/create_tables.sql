CREATE TABLE Opettaja(
    id SERIAL PRIMARY KEY,
    nimi varchar(50) NOT NULL,
    salasana varchar(50) NOT NULL
);

CREATE TABLE Suoritus(
    id SERIAL PRIMARY KEY,
    opettaja_id INTEGER REFERENCES Opettaja(id),
    tyoaihe_id INTEGER REFERENCES Tyoaihe(id),
    arvosana INTEGER,
    suoritusaika INTEGER NOT NULL,
);
CREATE TABLE Tyoaihe(
    id SERIAL PRIMARY KEY,
    nimi varchar(50) NOT NULL,
    kuvaus varchar(3000) NOT NULL,
);
CREATE TABLE Laboratoriokurssi(
    id SERIAL PRIMARY KEY,
    opettaja_id INTEGER REFERENCES Opettaja(id),
    nimi varchar(50) NOT NULL,
);
CREATE TABLE Yhteenveto(
    id SERIAL PRIMARY KEY,
    laboratoriokurssi_id INTEGER REFERENCES Laboratoriokurssi(id),
);
CREATE TABLE Labratyoaihe(
    laboratoriokurssi_id INTEGER REFERENCES Laboratoriokurssi(id),
    tyoaihe_id INTEGER REFERENCES Tyoaihe(id),
);