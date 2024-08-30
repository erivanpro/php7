CREATE TABLE articles (
	identifiant INTEGER PRIMARY KEY,
	libelle VARCHAR(40) NOT NULL,
	prix FLOAT DEFAULT 0 NOT NULL
);

INSERT INTO articles (libelle, prix) VALUES ('Abricots', 35.5);
INSERT INTO articles (libelle, prix) VALUES ('Cerises', 48.9);
INSERT INTO articles (libelle, prix) VALUES ('Fraises', 29.95);
INSERT INTO articles (libelle, prix) VALUES ('Pêches', 37.2);

CREATE TABLE utilisateurs (
	identifiant VARCHAR(20) PRIMARY KEY,
	mot_de_passe VARCHAR(20) NOT NULL
);

INSERT INTO utilisateurs (identifiant, mot_de_passe) VALUES ( 'heurtel', 'olivier');

CREATE TABLE auteurs (
	prenom VARCHAR(40) NOT NULL,
	nom VARCHAR(40) NOT NULL,
	PRIMARY KEY (nom,prenom)
);
