<!-- modele.php -->
<!-- Modèle -->


<?php
require_once("config.php");

function convertirEnChiffreRomain($nombre)
{
    $romains = [
        'M' => 1000,
        'CM' => 900,
        'D' => 500,
        'CD' => 400,
        'C' => 100,
        'XC' => 90,
        'L' => 50,
        'XL' => 40,
        'X' => 10,
        'IX' => 9,
        'V' => 5,
        'IV' => 4,
        'I' => 1,
    ];

    $resultat = '';

    foreach ($romains as $symbole => $valeur) {
        $quotient = intval($nombre / $valeur);
        $resultat .= str_repeat($symbole, $quotient);
        $nombre %= $valeur;
    }

    return $resultat;
}

function connecterDatabase()
{
    try {
        $db_access = sprintf('mysql:host=%s;dbname=%s;charset=utf8', DB_HOST, DB_NAME);
        $bdd = new PDO($db_access, DB_USER, DB_PWD);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $bdd;
    } catch (PDOException $e) {
        die('Erreur de connexion : ' . $e->getMessage());
    }
}

function closeDatabase($bdd)
{
    $bdd = null;
}

function ajouterPersonnage($nom, $annee_naissance_decimal, $image)
{
    $bdd = connecterDatabase();

    $image_path = 'images/' . basename($image['name']);
    $image_content = file_get_contents($image['tmp_name']);
    $encoded_image = base64_encode($image_content);

    // Vérifier et créer le dossier si nécessaire
    if (!file_exists('images')) {
        mkdir('images', 0755, true);
    }

    // Convertir l'année en chiffre romain
    $chiffre_romain = convertirEnChiffreRomain($annee_naissance_decimal);

    // Enregistrez $encoded_image et le chiffre romain dans votre base de données
    $requete = $bdd->prepare('INSERT INTO ma_table (nom, annee_naissance, chiffre_romain, image) VALUES (?, ?, ?, ?)');
    if (!$requete->execute([$nom, $annee_naissance_decimal, $chiffre_romain, $encoded_image])) {
        // Affichez les informations sur l'erreur
        $errorInfo = $requete->errorInfo();
        echo "Erreur d'exécution de la requête : " . $errorInfo[2];
    }

    closeDatabase($bdd);
}

function recupererPersonnages()
{
    $bdd = connecterDatabase();
    $requete = $bdd->query('SELECT nom, annee_naissance, chiffre_romain, image FROM ma_table');
    $personnages = $requete->fetchAll(PDO::FETCH_ASSOC);
    closeDatabase($bdd);

    return $personnages;
}
?>
