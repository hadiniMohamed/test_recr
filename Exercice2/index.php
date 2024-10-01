<?php
require_once './config/Database.php';
require_once './classes/StockReport.php';
require_once './classes/Revenue.php';
require_once './classes/StockInfo.php';
require_once './classes/StockMovement.php';

$db = (new Database())->connect();
$stockReport = new StockReport($db);
$revenue = new Revenue($db);
$stockInfo = new StockInfo($db);
$stockMovement = new StockMovement($db);
$superUMovements = $stockReport->getStockMovements();


$revenueData = $revenue->getHariboRevenueInLeclerc();
echo '<h2>Revenue for Haribo in Leclerc</h2>';
echo '<pre>' . json_encode($revenueData, JSON_PRETTY_PRINT) . '</pre>';

// Define test parameters for the sale
$magasinId = 3;
$produitId = 17; 
$quantiteVendue = 200; 

// Record the sale
try {
    $stockMovement->recordSale($magasinId, $produitId, $quantiteVendue);
    $queryStock = "
        SELECT spm.stock FROM stock_produit_magasin spm 
        WHERE spm.id_magasin = :magasinId AND spm.id_produit = :produitId
    ";
    $stmtStock = $db->prepare($queryStock);
    $stmtStock->bindParam(':magasinId', $magasinId);
    $stmtStock->bindParam(':produitId', $produitId);
    $stmtStock->execute();
    
    $updatedStock = $stmtStock->fetch(PDO::FETCH_ASSOC);
    echo "Updated stock for product ID $produitId in store ID $magasinId: " . $updatedStock['stock'] . ".<br>";
} catch (Exception $e) {
    echo "Error recording sale: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mouvements de Stock</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../Exercice3.js"></script>
</head>
<body>
<h1>Mouvements de Stock </h1>
    <label for="enseigne">Choisir une enseigne :</label>
    <select id="enseigne">
        <!-- ther's no data in the table enseignes that's why i added staticly -->
            <option value="Super U" selected>Super U</option>
            <option value="Leclerc">Leclerc</option>
            <option value="Carrefour">Carrefour</option>
        <!-- <?php foreach ($enseignes as $enseigne): ?>
            <option value="<?= $enseigne['nom_enseigne']; ?>" <?= $enseigne['nom_enseigne'] == 'Super U' ? 'selected' : ''; ?>>
                <?= $enseigne['nom_enseigne']; ?>
            </option>
        <?php endforeach; ?> -->
    </select>
    <table border="1">
        <thead>
            <tr>
                <th><input type="text" id="filter-ville" placeholder="Ville du Magasin"></th>
                <th><input type="text" id="filter-produit" placeholder="Produit"></th>
                <th><input type="number" id="filter-quantite" placeholder="Quantité"></th>
                <th><input type="number" id="filter-revenue" placeholder="Chiffre d'Affaires"></th>
                <th><input type="date" id="filter-date" placeholder="Date Mouvement"></th>
            </tr>
            <tr>
                <th>Ville du Magasin</th>
                <th>Produit</th>
                <th>Quantité Mouvement</th>
                <th>Chiffre d'Affaires</th>
                <th>Date Mouvement</th>
            </tr>
        </thead>
    <tbody>
        <?php foreach ($superUMovements as $movement): ?>
        <tr>
            <td><?= $movement['ville_magasin']; ?></td>
            <td><?= $movement['ean_produit']; ?></td>
            <td><?= $movement['quantite_mouvement']; ?></td>
            <td><?= $movement['revenue'] ? $movement['revenue'] : 'N/A'; ?></td>
            <td><?= $movement['date_mouvement']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
