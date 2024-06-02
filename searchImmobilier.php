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
$mailClient = $_SESSION['email'];

$compte_type = $_SESSION['rights'];

// Paramètres pour la requête préparée
$searchParam = "%" . $searchInput . "%";

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
            f.id AS favorisId,
            i.id
        FROM 
            immobilier i
        JOIN 
            compte c ON i.agent = c.email
        LEFT JOIN
            favoris f ON i.id = f.idImmobilier AND f.mailClient = ?
        WHERE 
            (i.id = ? OR i.adresse LIKE ?)";
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
            f.id AS favorisId,
            i.id
        FROM 
            immobilier i
        JOIN 
            compte c ON i.agent = c.email
        LEFT JOIN
            favoris f ON i.id = f.idImmobilier AND f.mailClient = ? ";
}

$stmt = $conn->prepare($sql);

if ($searchInput !== '') {
    $stmt->bind_param("sss", $searchParam, $searchInput, $searchParam);
} else {
    $stmt->bind_param("s", $searchParam);
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
        echo '              <a href="#" data-immo="' . $row["immobilierPhoto"] . '" data-agentemail="' . $row["agentEmail"] . '" data-adresse="' . $row["adresse"] . '" data-nbpiece="' . $row["nbPiece"] . '" data-nbchambre="' . $row["nbChambre"] . '" data-description="' . $row["description"] . '" data-id="' . $row["id"] . '" data-dimension="' . $row["dimension"] . '" data-prix="' . number_format($row["prix"], 2) . '" class="btn btn-primary btn-immo">Détails</a>';
        if ($row['favorisId']) {
            echo '<form action="remove_from_favoris.php" method="post" class="favoris-form" style="position: absolute; right: 10%; bottom: 10%;">
                    <input type="hidden" name="idImmobilier" value="' . $row["id"] . '">
                    <input type="hidden" name="mailClient" value="' . $_SESSION["email"] . '">
                    <button type="submit" class="favoris-btn favorited"><i class="fas fa-heart" style="font-size: 150%;"></i></button>
                </form>';
        } else {
            echo '<form action="add_to_favoris.php" method="post" class="favoris-form" style="position: absolute; right: 10%; bottom: 10%;">
                    <input type="hidden" name="idImmobilier" value="' . $row["id"] . '">
                    <input type="hidden" name="mailClient" value="' . $_SESSION["email"] . '">
                    <button type="submit" class="favoris-btn"><i class="far fa-heart" style="font-size: 150%;"></i></button>
                </form>';
        }
        if ($compte_type == 3) {
            echo '<form action="delete_immobilier.php" method="post" onsubmit="return confirm(\'Êtes-vous sûr de vouloir supprimer cet immobilier ?\');" style="display:inline;">
                    <input type="hidden" name="idImmobilier" value="' . $row["id"] . '">
                    <button type="submit" class="btn-delete">
                        &times;
                    </button>
                  </form>';
        }
        echo '            </div>';
        echo '        </div>';
        echo '    </div>';
        echo '</div>';
    }
} else {
    echo '<div class="col-12"><p class="text-center" style="color: #007bff;">0 résultats</p></div>';
}
$conn->close();
?>
