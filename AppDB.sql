DROP SCHEMA IF EXISTS venn_8;
CREATE SCHEMA IF NOT EXISTS venn_8;
USE venn_8;

CREATE TABLE bruker(
id INT(10) PRIMARY KEY auto_increment,
Brukernavn VARCHAR(50) NOT NULL UNIQUE,
Passord VARCHAR(60) NOT NULL,
Epost VARCHAR(50) NOT NULL,
Brukertype TINYINT(1)
);

CREATE TABLE ipoversikt(
Brukernavn VARCHAR(50),
feilIP VARCHAR(45),
feilLoginnTeller INT(11),
feilLoginnSiste DATETIME,
CONSTRAINT PRIMARY KEY (Brukernavn, feilIP),
CONSTRAINT FOREIGN KEY (Brukernavn) REFERENCES bruker (Brukernavn)
);

CREATE TABLE studier(
brukernavn VARCHAR(50),
studium VARCHAR(50),
grad VARCHAR(50),
skole VARCHAR(50),
arskull VARCHAR(50),
PRIMARY KEY (brukernavn, studium, grad),
CONSTRAINT FOREIGN KEY (brukernavn) REFERENCES bruker (Brukernavn)
);

CREATE TABLE interesser(
interesse VARCHAR(40) PRIMARY KEY
);

CREATE TABLE brukersinteresser(
interesse VARCHAR(40),
brukernavn VARCHAR(50),
PRIMARY KEY (interesse, brukernavn),
CONSTRAINT FOREIGN KEY (brukernavn) REFERENCES bruker (Brukernavn),
CONSTRAINT FOREIGN KEY (interesse) REFERENCES interesser (interesse)
);

CREATE TABLE personvern(
brukernavn VARCHAR(50) PRIMARY KEY,
skjulInteresse TINYINT(1),
skjulStudium TINYINT(1),
CONSTRAINT FOREIGN KEY (brukernavn) REFERENCES bruker (Brukernavn)
);

CREATE TABLE chat(
chatID INT(10) PRIMARY KEY auto_increment,
dato DATETIME NOT NULL,
melding VARCHAR(40) NOT NULL,
brukernavn VARCHAR(50),
CONSTRAINT FOREIGN KEY (brukernavn) REFERENCES bruker (Brukernavn)
);

CREATE TABLE profil(
Brukernavn CHAR(50) PRIMARY KEY,
Beskrivelse VARCHAR(500),
Fornavn CHAR(50),
Etternavn CHAR(50),
Campus CHAR(30),
Fodselsdato DATE,
Land CHAR(30),
CONSTRAINT FOREIGN KEY (Brukernavn) REFERENCES bruker (Brukernavn)
);

CREATE TABLE regler(
regelID INT(1) PRIMARY KEY auto_increment,
tekst VARCHAR(500) NOT NULL
);

CREATE TABLE nyheter(
nyhetID INT(10) PRIMARY KEY auto_increment,
dato DATETIME NOT NULL,
overskrift VARCHAR(40) NOT NULL,
informasjon VARCHAR(200) NOT NULL
);

CREATE TABLE arrangementer(
arrangementID INT(10) PRIMARY KEY auto_increment,
navn VARCHAR(40) NOT NULL,
arrangor VARCHAR(40) NOT NULL,
sted VARCHAR(40) NOT NULL,
tid DATETIME NOT NULL,
beskrivelse VARCHAR(400) NOT NULL
);

CREATE TABLE paameldinger(
arrangementID INT(10),
brukernavn VARCHAR(40),
paameldt CHAR(15),
CONSTRAINT PRIMARY KEY (arrangementID, brukernavn),
CONSTRAINT FOREIGN KEY (arrangementID) REFERENCES arrangementer (arrangementID),
CONSTRAINT FOREIGN KEY (brukernavn) REFERENCES bruker (Brukernavn)
);

CREATE TABLE karantener(
brukernavn VARCHAR(50) PRIMARY KEY,
epost VARCHAR(50),
dato DATETIME,
niva INT(1),
CONSTRAINT FOREIGN KEY (brukernavn) REFERENCES bruker (Brukernavn)
);

CREATE TABLE systemmeldinger(
meldingsID INT(12) PRIMARY KEY auto_increment,
tittel VARCHAR(25),
dato DATETIME,
tekst VARCHAR(400)
);

CREATE TABLE lestmelding(
meldingsID INT(12),
brukernavn VARCHAR(50),
CONSTRAINT PRIMARY KEY (meldingsID, brukernavn),
CONSTRAINT FOREIGN KEY (meldingsID) REFERENCES systemmeldinger (meldingsID),
CONSTRAINT FOREIGN KEY (brukernavn) REFERENCES bruker (Brukernavn)
);

#Passord til admin er koko
INSERT INTO bruker VALUES(DEFAULT, 'admin', 'd22dc902cd32acf221b39628b04f26dca3ae79cd', 'admin@usn.no', 1);

#Passord til bruker er jojo
INSERT INTO bruker VALUES(DEFAULT, 'bruker', '143df40d02c0ad07cb4fd101738249c7f947615f', '150150@usn.no', 0);

#Stemmer overens med reglene i html fila
INSERT INTO Regler VALUES(DEFAULT, 'Misbruk av nettstedet vil bli rapportert til administratorer.
Dette gjelder spesielt ved rapporter som blir sendt i massivt antall.
Brukernavn og passord er personlig informasjon og skal ikke deles med andre.');
