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

$searchQuery = $_POST['searchQuery'];
if ($searchQuery !== '') {
    $sql = "SELECT email, nom, prenom, photoPath FROM agent WHERE nom LIKE '%$searchQuery%'";
} else {
    // Si l'input est vide, récupérer tous les agents
    $sql = "SELECT email, nom, prenom, photoPath FROM agent";
}
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="col-md-4">';
        echo '    <div class="card">';
        echo '        <img src="' . $row["photoPath"] . '" class="card-img-top" alt="Photo de ' . $row["prenom"] . ' ' . $row["nom"] . '">';
        echo '        <div class="card-body d-flex flex-column">';
        echo '            <div class="mt-auto text-center">';
        echo '              <h5 class="card-title">' . $row["prenom"] . ' ' . $row["nom"] . '</h5>';
        echo '              <p class="card-text">' . $row["email"] . '</p>';
        echo '              <a href="#" class="btn btn-primary btn-cv">CV</a>';
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
