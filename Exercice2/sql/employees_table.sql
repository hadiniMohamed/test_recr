CREATE TABLE employe (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255),
    prenom VARCHAR(255),
    id_magasin INT,
    FOREIGN KEY (id_magasin) REFERENCES magasin(id_magasin)
);

CREATE TABLE employe_poste (
    id_employe INT,
    poste VARCHAR(255),
    PRIMARY KEY (id_employe, poste),
    FOREIGN KEY (id_employe) REFERENCES employe(id)
);
