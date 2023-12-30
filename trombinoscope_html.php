<!-- trombinoscope_html.php -->
<!-- Vue -->


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
            <?php require_once("traitement.php"); ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
