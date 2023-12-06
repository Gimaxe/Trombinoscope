<?php
require_once("config.php");

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
?>
