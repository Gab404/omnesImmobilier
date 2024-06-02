<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            position: relative; /* Needed for positioning */
        }
        a {
            display: inline-block;
            margin: 10px;
            padding: 20px 40px;
            background-color: #0056b3;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        a:hover {
            background-color: #052360;
        }
        .logo {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px; /* Adjust size as needed */
            object-fit: cover; /* Ensure the image covers the space without distortion */
            border: 5px solid #0056b3; /* Add border */
            border-radius: 5px; /* Optional: rounded corners */
            
        }
        .gif {
            position: fixed;
            bottom: 10px;
            right: 10px;
            width: 250px; /* Adjust size as needed */
            border: 5px solid #0056b3; /* Add border */
            border-radius: 5px; /* Optional: rounded corners */
        }
    </style>
</head>
<body>
    <center>
    <h1 class="my-4 text-center mb-5" style="color: #007bff;">
    <span style="color: black;">Choisissez </span>une horaire de visite
        </h1>
    </center>
<center>
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
</center>
<img src="assets/omnes.gif" alt="Omnes Immobilier GIF" class="gif">
<img src="assets/pub.gif" alt="Omnes Immobilier Logo" class="logo">
</body>
</html>