<?php

$resultat = $erreur = null;

// verify the submit form 
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if the field is filled in
    if (isset($_POST['nombre']) && $_POST['nombre'] !== '') {
        // get the value 
        $nombre = htmlspecialchars($_POST['nombre']);

        // check if if number
        if (is_numeric($nombre)) {
            // calculate the square
            $carre = $nombre * $nombre;

            $resultat = "Le carré de " . $nombre . " est " . $carre . ".";
        } else {
            $erreur = "Please enter a valid number";
        }
    } else {
        $erreur = "The field must not be empty";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Calcul du Carré</title>
</head>
<body>
    <h1>Calcul du Carré</h1>
    <form method="POST" action="">
        <label for="nombre">Entrez un nombre :</label>
        <input type="number" id="nombre" name="nombre" required>
        <button type="submit">Calculer le carré</button>
    </form>

    <!-- Display of result or errors -->
    <?php if ($resultat): ?>
        <p class="result"><?= $resultat ?></p>
    <?php elseif ($erreur): ?>
        <p class="error"><?= $erreur ?></p>
    <?php endif; ?>
</body>
</html>
