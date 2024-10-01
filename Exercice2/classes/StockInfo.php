<?php
class StockInfo {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getNutellaStockInCarrefour() {
        $query = "
            SELECT p.libelle_produit AS produit, spm.stock AS stock, m.ville_magasin AS magasin, e.nom_enseigne AS enseigne 
            FROM produit p
            JOIN fournisseur_produit fp ON p.id_produit = fp.id_produit
            JOIN fournisseur f ON fp.id_fournisseur = f.id_fournisseur
            JOIN stock_produit_magasin spm ON p.id_produit = spm.id_produit
            JOIN magasin m ON spm.id_magasin = m.id_magasin
            JOIN enseigne e ON m.id_enseigne = e.id_enseigne
            WHERE f.nom_fournisseur = :fournisseur AND e.nom_enseigne = :enseigne
        ";
    
        $fournisseur = 'NUTELLA';
        $enseigne = 'CARREFOUR';
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':fournisseur', $fournisseur);
        $stmt->bindParam(':enseigne', $enseigne);
        
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
