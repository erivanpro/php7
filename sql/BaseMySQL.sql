CREATE TABLE articles (
	identifiant INT(11) NOT NULL AUTO_INCREMENT,
	libelle VARCHAR(40) NOT NULL,
	prix FLOAT DEFAULT '0' NOT NULL,
	PRIMARY KEY (identifiant)
);

INSERT INTO articles (libelle, prix) VALUES ('Abricots', 35.5);
INSERT INTO articles (libelle, prix) VALUES ('Cerises', 48.9);
INSERT INTO articles (libelle, prix) VALUES ('Fraises', 29.95);
INSERT INTO articles (libelle, prix) VALUES ('Pêches', 37.2);

CREATE TABLE utilisateurs (
	identifiant VARCHAR(20) NOT NULL,
	mot_de_passe VARCHAR(20) NOT NULL,
	PRIMARY KEY (identifiant)
);

INSERT INTO utilisateurs (identifiant, mot_de_passe) VALUES ( 'heurtel', 'olivier');

CREATE TABLE auteurs (
	prenom VARCHAR(40) NOT NULL,
	nom VARCHAR(40) NOT NULL,
	PRIMARY KEY (nom,prenom)
);

delimiter //

CREATE PROCEDURE ps_creer_article
  (
  -- Libellé du nouvel article.
  IN p_libelle VARCHAR(25),
  -- Prix du nouvel article.
  IN p_prix DECIMAL(5,2),
  -- Identifiant du nouvel article.
  OUT p_identifiant INT
  )
BEGIN
  /*
  ** Insérer le nouvel article et
  ** récupérer l'identifiant affecté.
  */
  INSERT INTO articles (libelle,prix)
  VALUES (p_libelle,p_prix);
  SET p_identifiant = LAST_INSERT_ID();
END;
//

CREATE PROCEDURE ps_lire_articles
  (
  -- Prix maximum.
  IN p_prix_max DECIMAL(5,2)
  )
BEGIN
  /*
  ** Sélectionner les articles dont le prix est
  ** inférieur au montant passé en paramètre.
  */
  SELECT
    libelle
  FROM
    articles
  WHERE
    prix < p_prix_max;
END;
//

CREATE FUNCTION fs_nombre_articles
  (
  -- Prix maximum.
  p_prix_max DECIMAL(5,2)
  )
  RETURNS INT
BEGIN
  /*
  ** Compter le nombre d'articles dont le prix est
  ** inférieur au montant passé en paramètre.
  */
  DECLARE v_resultat INT;
  SELECT
    COUNT(*)
  INTO
    v_resultat
  FROM
    articles
  WHERE
    prix < p_prix_max;
  RETURN v_resultat;
END;
//

delimiter ;
