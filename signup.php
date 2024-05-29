<?php
// Démarrer la session
session_start();

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$database = "omnesimmobilier";

$conn = new mysqli($servername, $username, $password, $database);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Vérification des données du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $adresse = $_POST['adresse'];
    $tel = $_POST['tel'];

    // Requête SQL pour insérer un nouvel utilisateur
    $sql = "INSERT INTO compte (email, password, prenom, nom, adresse, tel, type) VALUES ('$email', '$password', '$prenom', '$nom', '$adresse', '$tel', 1)";

    if ($conn->query($sql) === TRUE) {
        // Utilisateur inséré avec succès, rediriger vers une autre page par exemple
        $_SESSION['account_created'] = true; // Indiquer que le compte a été créé avec succès
        header("Location: index.php");
        exit();
    } else {
        // Erreur lors de l'insertion, afficher un message d'erreur
        $error_message = "Erreur lors de l'inscription. Veuillez réessayer.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background: url('assets/bgSignup.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100%;
            margin: 0;
        }
    </style>
</head>
<body>
    <center>
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-6">
                <div class="register-form">
                    <div class="card">
                        <div class="card-header text-center">
                            Inscription
                        </div>
                        <div class="card-body">
                            <?php
                            if(isset($_SESSION['account_created'])) {
                                echo '<div class="alert alert-success" role="alert">
                                        Votre compte a été créé avec succès!
                                      </div>';
                                unset($_SESSION['account_created']); // Supprimer la variable de session après l'affichage du message
                            }
                            ?>
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                <div class="form-group">
                                    <label for="prenom">Prénom:</label>
                                    <input type="text" class="form-control" id="prenom" name="prenom" required>
                                </div>
                                <div class="form-group">
                                    <label for="nom">Nom:</label>
                                    <input type="text" class="form-control" id="nom" name="nom" required>
                                </div>
                                <div class="form-group">
                                    <label for="adresse">Adresse:</label>
                                    <input type="text" class="form-control" id="adresse" name="adresse" required>
                                </div>
                                <div class="form-group">
                                    <label for="tel">Téléphone:</label>
                                    <input type="text" class="form-control" id="tel" name="tel" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Mot de passe:</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">S'inscrire</button>
                            </form>
                            <?php
                            if(isset($error_message)) {
                                echo '<div class="alert alert-danger mt-3" role="alert">' . $error_message . '</div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </center>
</body>
</html>
