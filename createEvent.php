<?php
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

// Récupérer la date et l'email de l'agent depuis GET
$date = $_GET['date'];
$agentEmail = $_GET['agentEmail'];
$propertyAddress = $_GET['propertyAddress'];

// Préparer la plage horaire de 9h à 18h
$startHour = 9;
$endHour = 18;

// Récupérer les heures déjà prises pour cette date et cet agent
// Récupérer les heures déjà prises pour cette date et cet agent
$sql = "SELECT heure AS hour FROM planning WHERE mailAgent = '$agentEmail' AND DATE(date) = '$date'";
$result = $conn->query($sql);



$hoursTaken = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $hoursTaken[] = $row['hour'];
    }
}

// Générer la liste des heures disponibles
$availableHours = array();
for ($hour = $startHour; $hour <= $endHour; $hour++) {
    $formattedHour = sprintf("%02d:00", $hour); // Ajouter les minutes pour formater l'heure
    if (!in_array($formattedHour . ':00', $hoursTaken)) {
        $availableHours[] = $formattedHour; // Ajouter l'heure disponible
    }
}
// Afficher les heures disponibles
foreach ($availableHours as $hour) {
    echo "<a href='request.php?date=$date&agentEmail=$agentEmail&propertyAddress=$propertyAddress&hour=$hour:00'>$hour:00</a><br>";
}

// Fermer la connexion à la base de données
$conn->close();
?>
