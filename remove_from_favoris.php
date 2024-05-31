<?php
// Connexion à la base de données
$db = new PDO('mysql:host=localhost;dbname=omnesimmobilier', 'root', '');

// Récupération des données du formulaire
$mailClient = $_POST['mailClient'];
$idImmobilier = $_POST['idImmobilier'];

// Suppression de l'immobilier des favoris
$query = $db->prepare("DELETE FROM favoris WHERE mailClient = :mailClient AND idImmobilier = :idImmobilier");
$query->execute(['mailClient' => $mailClient, 'idImmobilier' => $idImmobilier]);

// Redirection vers la page précédente
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>