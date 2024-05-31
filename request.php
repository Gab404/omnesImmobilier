<?php
// Démarrer la session pour récupérer la variable $_SESSION['email']
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    // Redirection vers la page d'accueil ou de connexion
    header("Location: index.php");
    exit();
}

// Vérifier si les données nécessaires ont été envoyées via GET
if (!isset($_GET['date']) || !isset($_GET['agentEmail']) || !isset($_GET['propertyAddress']) || !isset($_GET['hour'])) {
    // Redirection vers la page d'erreur
    header("Location: error.php");
    exit();
}

// Récupérer les données envoyées via GET
$date = $_GET['date'];
$agentEmail = $_GET['agentEmail'];
$propertyAddress = $_GET['propertyAddress'];
$hour = $_GET['hour'];


// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "omnesimmobilier";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    // Redirection vers la page d'erreur
    header("Location: error.php");
    exit();
}

// Échapper les entrées utilisateur pour éviter les attaques par injection SQL
$clientEmail = $conn->real_escape_string($_SESSION['email']);

// Insérer un nouveau rendez-vous dans la table "planning"
$sql = "INSERT INTO planning (mailClient, mailAgent, date, heure, adresse) VALUES ('$clientEmail', '$agentEmail', '$date', '$hour', '$propertyAddress')";

if ($conn->query($sql) === TRUE) {
    // Redirection vers la page immobilier.php
    header("Location: immobilier.php");
    exit();
} else {
    // Redirection vers la page d'erreur
    header("Location: error.php");
    exit();
}

// Fermer la connexion à la base de données
$conn->close();
?>
