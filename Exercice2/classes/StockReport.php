<?php

class StockReport {

    private $db;

    public function __construct($db) {
        $this->db = $db;  
    }

    public function getStockMovements($enseigne = 'Super U') {
        $sql = "SELECT magasin.ville_magasin, produit.ean_produit, mouvement_stock.quantite_mouvement, 
                       IF(mouvement_stock.quantite_mouvement < 0, mouvement_stock.quantite_mouvement * produit.prix_produit, NULL) AS revenue, 
                       mouvement_stock.date_mouvement
                FROM mouvement_stock
                JOIN produit ON mouvement_stock.id_produit = produit.id_produit
                JOIN magasin ON mouvement_stock.id_magasin = magasin.id_magasin
                JOIN enseigne ON magasin.id_enseigne = enseigne.id_enseigne
                WHERE enseigne.nom_enseigne = :enseigne";
    
        // Prepare and execute the statement
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':enseigne', $enseigne, PDO::PARAM_STR);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function getEnseignes() {
        $sql = "SELECT id_enseigne, nom_enseigne FROM enseigne";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
