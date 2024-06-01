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

    // Requête SQL pour vérifier l'utilisateur
    $sql = "SELECT * FROM compte WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Utilisateur trouvé, stocker l'email dans la session

        $row = $result->fetch_assoc();
        
        $_SESSION['email'] = $email;
        $_SESSION['prenom'] = $row['prenom'];
        $_SESSION['nom'] = $row['nom'];
        $_SESSION['adresse'] = $row['adresse'];
        $_SESSION['tel'] = $row['tel'];
        $_SESSION['photo'] = $row['photo'];
        $_SESSION['id'] = $row['id'];
        $_SESSION['rights'] = $row['type'];
        
        // Rediriger vers une autre page par exemple
        header("Location: index.php");
        exit();
    } else {
        // Utilisateur non trouvé, afficher un message d'erreur
        $error_message = "Identifiants incorrects. Veuillez réessayer ou s'inscrire via ce lien : <a href='signup.php' style='color: blue;'>Créez un compte</a>.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background: url('assets/bgLogin.jpg') no-repeat center center fixed;
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
                <div class="login-form">
                    <div class="card">
                        <div class="card-header text-center">
                            Connexion
                        </div>
                        <div class="card-body">
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Mot de passe:</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
                            </form>
                            <p>Pas de compte ? <a href="signup.php" style="color: blue;">Inscivez-vous ici</a>.</p>
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
