<?php
require_once("connexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';
    $annee_naissance_decimal = $_POST['annee_naissance'] ?? '';
    $image = $_FILES['image'] ?? null;

    if ($nom && $annee_naissance_decimal && $image && $image['error'] === UPLOAD_ERR_OK) {
        $image_path = 'images/' . basename($image['name']);
        $image_content = file_get_contents($image['tmp_name']);
        $encoded_image = base64_encode($image_content);

        // Vérifier et créer le dossier si nécessaire
        if (!file_exists('images')) {
            mkdir('images', 0755, true);
        }

        // Enregistrez $encoded_image dans votre base de données
        $bdd = connecterDatabase();
        $requete = $bdd->prepare('INSERT INTO ma_table (nom, annee_naissance, image) VALUES (?, ?, ?)');
        if (!$requete->execute([$nom, $annee_naissance_decimal, $encoded_image])) {
            // Affichez les informations sur l'erreur
            $errorInfo = $requete->errorInfo();
            echo "Erreur d'exécution de la requête : " . $errorInfo[2];
        }
        closeDatabase($bdd);
    } else {
        echo '<div class="alert alert-danger" role="alert">Données saisies incorrectes</div>';
    }
}

$bdd = connecterDatabase();

$requete = $bdd->query('SELECT nom, annee_naissance, image FROM ma_table');

$personnages = $requete->fetchAll(PDO::FETCH_ASSOC);
closeDatabase($bdd);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Trombinoscope</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h1>Trombinoscope</h1>

    <!-- Bloc message d'erreur -->
    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !($nom && $annee_naissance_decimal && $image && $image['error'] === UPLOAD_ERR_OK)): ?>
        <div class="alert alert-danger" role="alert">Données saisies incorrectes</div>
    <?php endif; ?>

    <!-- Formulaire -->
    <h2>Ajouter un personnage</h2>
    <form action="#" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom du personnage :</label>
            <input type="text" class="form-control" id="nom" name="nom" required>
        </div>
        <div class="mb-3">
            <label for="annee_naissance" class="form-label">Année de naissance décimale :</label>
            <input type="number" class="form-control" id="annee_naissance" name="annee_naissance" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image :</label>
            <input type="file" class="form-control" id="image" name="image" required>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>

    <hr>

    <!-- Tableau des personnages -->
    <h2>Personnages enregistrés</h2>
    <table class="table">
        <thead>
        <tr>
            <th>Année de naissance</th>
            <th>Nom</th>
            <th>Image</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($personnages as $personnage): ?>
                <tr>
                    <td><?php echo $personnage['annee_naissance']; ?></td>
                    <td><?php echo $personnage['nom']; ?></td>
                    <td><img src="data:image/jpeg;base64,<?php echo $personnage['image']; ?>" alt="<?php echo $personnage['nom']; ?>" style="max-width: 100px; max-height: 100px;"></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
