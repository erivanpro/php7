CREATE TABLE articles (
	identifiant NUMBER(9),
	libelle VARCHAR2(40) CONSTRAINT articles$nn01 NOT NULL,
	prix NUMBER(6,2) CONSTRAINT articles$nn02 NOT NULL,
	CONSTRAINT articles$pk PRIMARY KEY (identifiant)
);

CREATE SEQUENCE s_articles;

CREATE OR REPLACE TRIGGER ins_articles
BEFORE INSERT ON articles
FOR EACH ROW
BEGIN
	SELECT s_articles.NEXTVAL INTO :new.identifiant FROM dual;
END;
/

INSERT INTO articles (libelle, prix) VALUES ('Abricots', 35.5);
INSERT INTO articles (libelle, prix) VALUES ('Cerises', 48.9);
INSERT INTO articles (libelle, prix) VALUES ('Fraises', 29.95);
INSERT INTO articles (libelle, prix) VALUES ('Pêches', 37.2);
COMMIT;

CREATE TABLE utilisateurs (
	identifiant VARCHAR(20) ,
	mot_de_passe VARCHAR(20) CONSTRAINT utilisateurs$nn01 NOT NULL,
	CONSTRAINT utilisateurs$pk PRIMARY KEY (identifiant)
);

INSERT INTO utilisateurs (identifiant, mot_de_passe) VALUES ( 'heurtel', 'olivier');
COMMIT;

CREATE TABLE auteurs (
	prenom VARCHAR2(40) NOT NULL,
	nom VARCHAR2(40) NOT NULL,
	CONSTRAINT auteurs$pk PRIMARY KEY (nom,prenom)
);

CREATE OR REPLACE PACKAGE pkg_articles IS
	TYPE curseur IS REF CURSOR;
	PROCEDURE creer(	
							p_libelle IN VARCHAR2,
							p_prix IN NUMBER,
							p_identifiant OUT NUMBER);
	FUNCTION compter RETURN NUMBER;
	PROCEDURE lire(
							p_identifiant IN NUMBER,
							p_curseur OUT curseur);
END pkg_articles;
/

CREATE OR REPLACE PACKAGE BODY pkg_articles IS
	-- procédure d'insertion dans la table articles
	-- retourne l'identifiant du nouvel article 
	-- dans p_identifiant
	PROCEDURE creer(	
							p_libelle IN VARCHAR2,
							p_prix IN NUMBER,
							p_identifiant OUT NUMBER)
	IS
	BEGIN
		INSERT INTO articles(identifiant,libelle,prix)
		VALUES(s_articles.NEXTVAL,p_libelle,p_prix)
		RETURNING identifiant INTO p_identifiant;
		COMMIT;
	END creer;
	-- fonction de comptage des articles
	FUNCTION compter RETURN NUMBER
	IS
		v_nombre NUMBER(9) := 0;
	BEGIN
		SELECT COUNT(identifiant) INTO v_nombre
		FROM articles;
		RETURN v_nombre;
	END compter;
	-- procédure de lecture d'un article (si p_identifiant > 0) 
	-- ou de tous les articles (si p_identifiant = 0)
	-- le résultat est retourné sous la forme d'un curseur
	PROCEDURE lire(
							p_identifiant IN NUMBER,
							p_curseur OUT curseur)
	IS
	BEGIN
			IF p_identifiant = 0 THEN
				OPEN p_curseur FOR
					SELECT * FROM articles;
			ELSE
				OPEN p_curseur FOR
					SELECT * FROM articles
					WHERE identifiant = p_identifiant;
			END IF;
	END lire;
END pkg_articles;
/

CREATE OR REPLACE PROCEDURE lire_curseur_implicite
-- procédure qui retourne un résultat sous la forme  
-- d'un curseur implicite (nouveauté d'Oracle 12c)
-- cette procédure ne fonctionnera pas dans une 
-- version antérieure à Oracle 12c
IS
  rc SYS_REFCURSOR;
BEGIN
  OPEN rc FOR
    SELECT * FROM articles;
  DBMS_SQL.RETURN_RESULT(rc);
END lire_curseur_implicite;
/
