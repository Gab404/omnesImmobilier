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

// Récupération de l'entrée utilisateur pour la recherche
$searchInput = $_POST['searchInput'];
if ($searchInput !== '') {
    $sql = "
        SELECT 
            c.photoPath AS agentPhoto,
            c.email AS agentEmail,
            i.photoPath AS immobilierPhoto, 
            i.description, 
            i.nbPiece, 
            i.nbChambre, 
            i.dimension, 
            i.adresse, 
            i.type, 
            i.prix,
            i.id
        FROM 
            immobilier i
        JOIN 
            compte c ON i.agent = c.email
        WHERE 
            i.type = 'residentiel' AND (i.id = ? OR i.adresse LIKE ?)";
} else {
    $sql = "
        SELECT 
            c.photoPath AS agentPhoto,
            c.email AS agentEmail,
            i.photoPath AS immobilierPhoto, 
            i.description, 
            i.nbPiece, 
            i.nbChambre, 
            i.dimension, 
            i.adresse, 
            i.type, 
            i.prix,
            i.id
        FROM 
            immobilier i
        JOIN 
            compte c ON i.agent = c.email
        WHERE
            i.type = 'residentiel'";
}

$stmt = $conn->prepare($sql);
if ($searchInput !== '') {
    $searchParam = "%" . $searchInput . "%";
    $stmt->bind_param("ss", $searchInput, $searchParam);
}
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="col-md-4">';
        echo '    <div class="card">';
        echo '        <img src="' . $row["immobilierPhoto"] . '" class="card-img-top" alt="Photo de ' . $row["description"] . '">';
        echo '        <div class="card-body d-flex flex-column">';
        echo '            <div class="mt-auto text-center">';
        echo '              <h5 class="card-title">' . $row["description"] . '</h5>';
        if ($row["type"] == "location") {
            echo '              <p class="card-text" style="font-size: 20px;"><b>' . number_format($row["prix"], 2) . '€ / mois</b></p>';
        } else if ($row["type"] == "terrain") {
            echo '              <p class="card-text" style="font-size: 20px;"><b>' . number_format($row["prix"], 2) . '€ / m²</b></p>';
        } else {
            echo '              <p class="card-text" style="font-size: 20px;"><b>' . number_format($row["prix"], 2) . '€</b></p>';
        }
        echo '              <img src="' . $row["agentPhoto"] . '" class="agent-photo" alt="Photo de l\'agent">';
        echo '              <a href="#" data-immo="' . $row["immobilierPhoto"] . '" data-agentEmail="' . $row["agentEmail"] . '" data-adresse="' . $row["adresse"] . '" data-nbPiece="' . $row["nbPiece"] . '" data-nbChambre="' . $row["nbChambre"] . '" data-description="' . $row["description"] . '" data-id="' . $row["id"] . '" data-dimension="' . $row["dimension"] . '" data-prix="' . number_format($row["prix"], 2) . '" class="btn btn-primary btn-immo">Détails</a>';
        echo '            </div>';
        echo '        </div>';
        echo '    </div>';
        echo '</div>';        
    }
} else {
    echo '<div class="col-12"><p class="text-center" style="color: #007bff;">Aucun résultat trouvé.</p></div>';
}
$conn->close();
?>
