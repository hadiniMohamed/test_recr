<?php
class StockMovement {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function recordSale($magasinId, $produitId, $quantiteVendue) {
        // Insert the sale record in mouvement_stock
        $query = "
            INSERT INTO mouvement_stock (id_produit, id_magasin, quantite_mouvement, date_mouvement)
            VALUES (:produit, :magasin, :quantite, NOW())
        ";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':magasin', $magasinId);
        $stmt->bindParam(':produit', $produitId);
        $stmt->bindParam(':quantite', $quantiteVendue);
        $stmt->execute();
    
        // Update stock in stock_produit_magasin
        $updateQuery = "
            UPDATE stock_produit_magasin
            SET stock = stock - :quantite
            WHERE id_magasin = :magasin AND id_produit = :produit
        ";
    
        $updateStmt = $this->conn->prepare($updateQuery);
        $updateStmt->bindParam(':magasin', $magasinId);
        $updateStmt->bindParam(':produit', $produitId);
        $updateStmt->bindParam(':quantite', $quantiteVendue);
        $updateStmt->execute();
    }
    
}
