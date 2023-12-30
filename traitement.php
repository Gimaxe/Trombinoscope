<!-- traitement.php -->
<!-- Contrôleur -->


<?php
require_once("modele.php");

$nom = $annee_naissance_decimal = $image = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';
    $annee_naissance_decimal = $_POST['annee_naissance'] ?? '';
    $image = $_FILES['image'] ?? null;

    if ($nom && $annee_naissance_decimal && $image && $image['error'] === UPLOAD_ERR_OK) {
        ajouterPersonnage($nom, $annee_naissance_decimal, $image);
    } else {
        echo '<div class="alert alert-danger" role="alert">Données saisies incorrectes</div>';
    }
}

$personnages = recupererPersonnages();
?>

<?php foreach ($personnages as $personnage): ?>
    <tr>
        <td><?php echo $personnage['chiffre_romain']; ?></td>
        <td><?php echo $personnage['nom']; ?></td>
        <td><img src="data:image/jpeg;base64,<?php echo $personnage['image']; ?>" alt="<?php echo $personnage['nom']; ?>" style="max-width: 100px; max-height: 100px;"></td>
    </tr>
<?php endforeach; ?>