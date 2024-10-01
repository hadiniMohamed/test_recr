<?php
class Revenue {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getHariboRevenueInLeclerc() {
        $query = "
            SELECT SUM(ms.quantite_mouvement * p.prix_produit) AS chiffre_affaires
            FROM mouvement_stock ms
            JOIN stock_produit_magasin spm ON ms.id_magasin = spm.id_magasin AND ms.id_produit = spm.id_produit
            JOIN produit p ON spm.id_produit = p.id_produit
            JOIN magasin m ON spm.id_magasin = m.id_magasin
            JOIN enseigne e ON m.id_enseigne = e.id_enseigne
            WHERE e.nom_enseigne = 'LECLERC' AND ms.quantite_mouvement < 0 AND p.libelle_produit LIKE '%Haribo%'
        ";
    
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
}
