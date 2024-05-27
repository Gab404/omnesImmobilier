<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "omnesimmobilier";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

$searchInput = $_POST['searchInput'];
if ($searchInput !== '') {
    $sql = "SELECT photoPath, description, nbPiece, nbChambre, dimension, adresse, type, prix FROM immobilier WHERE id = '$searchInput' OR adresse LIKE '%$searchInput%'";
} else {
    $sql = "SELECT photoPath, description, nbPiece, nbChambre, dimension, adresse, type, prix FROM immobilier";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="col-md-4">';
        echo '    <div class="card">';
        echo '        <img src="' . $row["photoPath"] . '" class="card-img-top" alt="Photo de ' . $row["description"] . '">';
        echo '        <div class="card-body d-flex flex-column">';
        echo '            <div class="mt-auto text-center">';
        echo '              <h5 class="card-title">' . $row["description"] . '</h5>';
        echo '              <p class="card-text">' . $row["adresse"] . '</p>';
        echo '              <p class="card-text">' . $row["nbPiece"] . ' pièces, ' . $row["nbChambre"] . ' chambres, ' . $row["dimension"] . '</p>';
        echo '              <p class="card-text">Prix: ' . number_format($row["prix"], 2) . '€</p>';
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
