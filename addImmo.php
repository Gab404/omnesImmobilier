<?php
session_start();
 // Vérifiez si l'utilisateur ou l'utilisatrice est connecté
 if(isset($_SESSION['email'])) {

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "omnesimmobilier";

  $compte_email = $_SESSION['email'];

  // Création de la connexion
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Vérification de la connexion
  if ($conn->connect_error) {
      die("Connexion échouée: " . $conn->connect_error);
  }

  // Requête SQL pour récupérer le type de compte
  $sql = "SELECT type FROM compte WHERE email = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $compte_email);
  $stmt->execute();
  $stmt->bind_result($compte_type);
  $stmt->fetch();
  $stmt->close();

  
} else {
}
?>

<?php
$host = 'localhost'; // Remplacez par votre hôte
$db   = 'omnesImmobilier'; // Remplacez par le nom de votre base de données
$user = 'root'; // Remplacez par votre nom d'utilisateur
$pass = ''; // Remplacez par votre mot de passe
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $photoPath = $_POST['photoPath'];
    $description = $_POST['description'];
    $nbPiece = $_POST['nbPiece'];
    $nbChambre = $_POST['nbChambre'];
    $dimension = $_POST['dimension'];
    $adresse = $_POST['adresse'];
    $pathVideo = $_POST['pathVideo'];
    $type = $_POST['type'];
    $prix = $_POST['prix'];
    $agent = $_POST['agent'];

    $sql = "INSERT INTO immobilier (photoPath, description, nbPiece, nbChambre, dimension, adresse, pathVideo, type, prix, agent) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt= $pdo->prepare($sql);
    $stmt->execute([$photoPath, $description, $nbPiece, $nbChambre, $dimension, $adresse, $pathVideo, $type, $prix, $agent]);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="css/style.css">
    
    <style>
        /* Ajoutez ici vos styles personnalisés */
    </style>
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <title>Omnes Immobilier - Ajouter un Bien Immobilier</title>
</head>
<body>

<style>
  body {
    background: url('assets/bgLogin.jpg') no-repeat center center fixed;
    background-size: cover;
  }
</style>

<div class="container mt-5" style="width: 70%;">
    <h1>Rajouter un bien immobilier:</h1>

    <form method="post" action="" class="mt-4">
        <div class="form-group">
            <label for="photoPath">Chemin de la Photo :</label>
            <input type="text" class="form-control" id="photoPath" name="photoPath">
        </div>
        <div class="form-group">
            <label for="description">Description :</label>
            <input type="text" class="form-control" id="description" name="description">
        </div>
        <div class="form-group">
            <label for="nbPiece">Nombre de Pièces :</label>
            <input type="number" class="form-control" id="nbPiece" name="nbPiece">
        </div>
        <div class="form-group">
            <label for="nbChambre">Nombre de Chambres :</label>
            <input type="number" class="form-control" id="nbChambre" name="nbChambre">
        </div>
        <div class="form-group">
            <label for="dimension">Dimension :</label>
            <input type="number" class="form-control" id="dimension" name="dimension">
        </div>
        <div class="form-group">
            <label for="adresse">Adresse :</label>
            <input type="text" class="form-control" id="adresse" name="adresse">
        </div>
        <div class="form-group">
            <label for="pathVideo">Chemin de la Vidéo :</label>
            <input type="text" class="form-control" id="pathVideo" name="pathVideo">
        </div>
        <div class="form-group">
            <label for="type">Type :</label>
            <select class="form-control" id="type" name="type">
                <option value="residentiel">Résidentiel</option>
                <option value="location">Location</option>
                <option value="commercial">Commercial</option>
                <option value="terrain">Terrain</option>
            </select>
        </div>
        <div class="form-group">
            <label for="prix">Prix :</label>
            <input type="number" class="form-control" id="prix" name="prix">
        </div>
        <div class="form-group">
            <label for="agent">Agent :</label>
            <input type="text" class="form-control" id="agent" name="agent">
        </div>
        <button type="submit" class="btn btn-primary">Soumettre</button>
    </form>
</div>

<!-- Ajoutez ici le code pour votre chatbot -->

<script>
    // Ajoutez ici vos scripts JavaScript personnalisés
</script>

<script src="js/chatbot.js"></script>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.sticky.js"></script>
<script src="js/main.js"></script>
</body>
</html>
