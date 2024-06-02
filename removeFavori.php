<?php
session_start();

// Informations de connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "omnesimmobilier";

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Vérifie si l'utilisateur est connecté
if (isset($_SESSION['email'])) {
    if (isset($_POST['favorisId'])) {
        $favorisId = $_POST['favorisId'];

        // Supprimer le favori de la base de données
        $sql = "DELETE FROM favoris WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $favorisId);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Favori supprimé avec succès.";
        } else {
            $_SESSION['message'] = "Erreur lors de la suppression du favori.";
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "Aucun ID de favori fourni.";
    }
} else {
    $_SESSION['message'] = "Utilisateur non connecté.";
}

$conn->close();

header("Location: myAccount.php");
exit();
?>
