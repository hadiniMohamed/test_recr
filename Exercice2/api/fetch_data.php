<?php
require_once '../config/Database.php';
require_once '../classes/StockReport.php';

$db = (new Database())->connect();
$stockReport = new StockReport($db);

// verify if enseige exist
if (isset($_GET['enseigne'])) {
    $enseigne = $_GET['enseigne'];
    $movements = $stockReport->getStockMovements($enseigne);

    if(empty($movements)){
        echo "<tr>
                There's no resualt
              </tr>";
    }else{
        foreach ($movements as $movement) {
            echo "<tr>
                    <td>{$movement['ville_magasin']}</td>
                    <td>{$movement['ean_produit']}</td>
                    <td>{$movement['quantite_mouvement']}</td>
                    <td>" . ($movement['revenue'] ? $movement['revenue'] : 'N/A') . "</td>
                    <td>{$movement['date_mouvement']}</td>
                  </tr>";
        }
    }
    
}
?>
