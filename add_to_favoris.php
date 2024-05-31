<?php
// Connexion à la base de données
$db = new PDO('mysql:host=localhost;dbname=omnesimmobilier', 'root', '');

// Récupération des données du formulaire
$mailClient = $_POST['mailClient'];
$idImmobilier = $_POST['idImmobilier'];

// Vérification si l'immobilier est déjà dans les favoris
$query = $db->prepare("SELECT * FROM favoris WHERE mailClient = :mailClient AND idImmobilier = :idImmobilier");
$query->execute(['mailClient' => $mailClient, 'idImmobilier' => $idImmobilier]);
$result = $query->fetch();

if (!$result) {
    // L'immobilier n'est pas dans les favoris, on l'ajoute
    $query = $db->prepare("INSERT INTO favoris (mailClient, idImmobilier) VALUES (:mailClient, :idImmobilier)");
    $query->execute(['mailClient' => $mailClient, 'idImmobilier' => $idImmobilier]);
}

// Redirection vers la page précédente
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>