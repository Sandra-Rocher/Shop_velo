CREATE TABLE produits (
    id INTEGER PRIMARY KEY AUTO_INCREMENT, 
    designation VARCHAR(255) NOT NULL, 
    reference VARCHAR(5) NOT NULL, 
    price_ht NUMERIC(4,2) NOT NULL, 
    stock INTEGER, 
    alerte INTEGER NOT NULL, 
    id_tva INTEGER NOT NULL
) ;


-- / Table : clients /

CREATE TABLE clients (
    id INTEGER PRIMARY KEY AUTO_INCREMENT, 
    nom VARCHAR(255) NOT NULL, 
    prenom VARCHAR(255) NOT NULL, 
    adresse1 VARCHAR(255) NOT NULL, 
    adresse2 VARCHAR(255), 
    code_postal INTEGER NOT NULL, 
    ville VARCHAR(255) NOT NULL, 
    email VARCHAR(255), 
    telephone VARCHAR(10)
) ;


-- / Table : personnel /

CREATE TABLE personnel (
    id INTEGER PRIMARY KEY AUTO_INCREMENT, 
    nom VARCHAR(255) NOT NULL, 
    id_password VARCHAR(255) NOT NULL, 
    id_role INTEGER NOT NULL
) ;


-- / Table : facture /

CREATE TABLE facture (
    id INTEGER PRIMARY KEY AUTO_INCREMENT, 
    dateFact DATETIME NOT NULL, 
    prix_ht NUMERIC(10,2) NOT NULL, 
    prix_ttc NUMERIC(10,2) NOT NULL, 
    id_clients INTEGER NOT NULL, 
    id_personnel INTEGER NOT NULL
) ;


-- / Table : tva /

CREATE TABLE tva (
    id INTEGER PRIMARY KEY AUTO_INCREMENT, 
    taux INTEGER NOT NULL
) ;


-- / Table : ligne_facture 

CREATE TABLE ligne_facture (
    quantité INTEGER NOT NULL, 
    id_produits INTEGER, 
    id_facture INTEGER, PRIMARY KEY(id_produits, id_facture)
) ;





ALTER TABLE ligne_facture ADD CONSTRAINT FK_produits_id_produits_ligne_facture FOREIGN KEY (id_produits) REFERENCES produits(id) ;

ALTER TABLE ligne_facture ADD CONSTRAINT FK_facture_id_facture_ligne_facture FOREIGN KEY (id_facture) REFERENCES facture(id) ;

ALTER TABLE facture ADD CONSTRAINT FK_clients_id_clients_facture FOREIGN KEY (id_clients) REFERENCES clients(id) ;

ALTER TABLE facture ADD CONSTRAINT FK_personnel_id_personnel_facture FOREIGN KEY (id_personnel) REFERENCES personnel(id) ;

ALTER TABLE produits ADD CONSTRAINT FK_tva_id_tva_produits FOREIGN KEY (id_tva) REFERENCES tva(id) ;