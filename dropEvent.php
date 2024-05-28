<?php
// Vérifier si la requête est une requête POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données JSON envoyées
    $eventId = $_POST['event_id'];

    // Vérifier si l'ID de l'événement est défini
    if (isset($eventId)) {
        // Récupérer l'ID de l'événement depuis les données JSON
        // Connexion à la base de données
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "omnesimmobilier";

        // Créer une connexion
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Vérifier la connexion
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Échapper les entrées utilisateur pour éviter les attaques par injection SQL
        $eventId = $conn->real_escape_string($eventId);

        // Requête SQL pour supprimer l'événement de la base de données
        $sql = "DELETE FROM planning WHERE id = '$eventId'";

        if ($conn->query($sql) === TRUE) {
            // Succès de la suppression de l'événement
            // Redirection vers planning.php une fois terminé
            header("Location: planning.php");
            exit(); // Assure que le script se termine ici pour éviter toute exécution supplémentaire
        } else {
            // Erreur lors de la suppression de l'événement
            echo json_encode(["success" => false, "error" => $conn->error]);
        }

        // Fermer la connexion à la base de données
        $conn->close();
    } else {
        // L'ID de l'événement n'est pas défini dans les données JSON
        echo json_encode(["success" => false, "error" => "ID de l'événement non spécifié"]);
    }
} else {
    // La requête n'est pas une requête POST
    echo json_encode(["success" => false, "error" => "Méthode de requête invalide"]);
}
?>
