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

// Vérifie si l'utilisateur est connecté
if(isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    // Récupérer les informations de l'utilisateur
    $sql = "SELECT photo FROM compte WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($photo);
    $stmt->fetch();
    $stmt->close();

    // Vérification si la photo est récupérée
    if ($photo) {
        $imageData = base64_encode($photo);
    } else {
        $imageData = null;
    }
}
$conn->close();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body {
            background-color: white;
        }
        .footer {
            background-color: #f1f1f1;
            padding: 40px 0;
        }
        .map-container {
            width: 100%;
            height: 400px;
        }
        .hero-image {
            width: 100%;
            height: 500px;
            object-fit: cover;
        }
        .site-logo {
          display: flex;
          align-items: center;
      }
      .site-logo img {
          max-height: 50px; /* Ajustez cette valeur en fonction de la taille de votre image */
          margin-right: 10px;
      }
    </style>
    <title>Omnes Immobilier - Mon Compte</title>
</head>
<body>
    <div class="site-mobile-menu">
        <div class="site-mobile-menu-header">
            <div class="site-mobile-menu-close mt-3">
                <span class="icon-close2 js-menu-toggle"></span>
            </div>
        </div>
        <div class="site-mobile-menu-body"></div>
    </div>
    
    <header class="site-navbar" role="banner">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-11 col-xl-2">
            <h1 class="mb-0 site-logo">
              <a href="index.php" class="text-white mb-0">
                <img src="assets/logo.png" alt="Logo">
                <div class="ml-5" style="position: absolute; top: 0%; left: 10%;  ">
                  Omnes Immobilier
                </div>
              </a>
            </h1>
          </div>
                <div class="col-12 col-md-10 d-none d-xl-block">
                    <nav class="site-navigation position-relative text-right" role="navigation">
                        <ul class="site-menu js-clone-nav mr-auto d-none d-lg-block">
                            <li><a href="index.php"><span>Home</span></a></li>
                            <li class="has-children">
                                <a href="#"><span>Recherche</span></a>
                                <ul class="dropdown arrow-top">
                                    <li><a href="agent.php">Agent</a></li>
                                    <li><a href="residentiel.php">Immobilier Résidentiel</a></li>
                                    <li><a href="terrain.php">Terrain</a></li>
                                    <li><a href="location.php">Appartement à Louer</a></li>
                                    <li><a href="commercial.php">Entrepôts Commerciaux</a></li>
                                </ul>
                            </li>
                            <li><a href="immobilier.php"><span>Tout Parcourir</span></a></li>
                            <li><a href="planning.php"><span>Rendez-Vous</span></a></li>
                            <?php
                            if(isset($_SESSION['email'])) {
                                echo '<li class="active"><a href="myAccount.php"><span>Mon Compte</span></a></li>';
                                echo '<li><a href="logout.php"><span>Déconnexion</span></a></li>';
                            } else {
                                echo '<li><a href="login.php"><span>Connexion</span></a></li>';
                                echo '<li><a href="signup.php"><span>Inscription</span></a></li>';
                            }
                            ?>
                        </ul>
                    </nav>
                </div>
                <div class="d-inline-block d-xl-none ml-md-0 mr-auto py-3" style="position: relative; top: 3px;">
                    <a href="#" class="site-menu-toggle js-menu-toggle text-white">
                        <span class="icon-menu h3"></span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <section id="accueil" class="mt-0">
        <img src="assets/bgAccount.jpg" class="hero-image" alt="Hero Image">
    </section>

    <div class="container-fluid mt-5">
        <h1 class="my-4 text-center mb-5" style="color: #007bff;">
            Bonjour <span style="color: black;"><?php echo $_SESSION['prenom'] . ' ' . $_SESSION['nom']; ?></span>
        </h1>

        <div class="row align-items-center justify-content-center">
            <div class="col-md-6">
                <div class="text-center">
                    <?php
                    if ($imageData) {
                        echo '<img src="data:image/jpeg;base64,' . $imageData . '" alt="Photo de profil" style="width: 120px; height: 120px; margin: 5% 0; border-radius: 50%; object-fit: cover;">';
                    } else {
                        echo '<img src="assets/photoAccount.jpg" alt="Photo de profil par défaut" style="max-width: 20%; margin: 5% 0;">';
                    }
                    ?>
                    <form id="uploadForm" action="upload.php" method="post" enctype="multipart/form-data" style="position: relative; display: inline-block;">
                        <input type="file" name="photo" accept="image/*" required onchange="document.getElementById('uploadForm').submit();" style="opacity: 0; position: absolute; left: 0; top: 0; width: 100%; height: 100%;">
                        <button type="button" class="btn btn-primary" style="pointer-events: none; margin: 0 10%; font-size: 70%;">Modifier</button>
                    </form>

                    <p><strong>Email :</strong> 
                        <span id="emailDisplay"><?php echo isset($_SESSION['email']) ? $_SESSION['email'] : 'Email non défini'; ?></span>
                        <button type="button" class="btn btn-link btn-sm ml-auto" onclick="editField('email')">Modifier</button>
                        <form id="emailForm" action="upload.php" method="post" style="display: none; inline-block;">
                            <input type="email" name="email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>" required>
                            <button type="submit" class="btn btn-primary btn-sm">Enregistrer</button>
                        </form>
                    </p>

                    <p><strong>Adresse :</strong> 
                        <span id="adresseDisplay"><?php echo isset($_SESSION['adresse']) ? $_SESSION['adresse'] : 'Adresse non définie'; ?></span>
                        <button type="button" class="btn btn-link btn-sm ml-auto" onclick="editField('adresse')">Modifier</button>
                        <form id="adresseForm" action="upload.php" method="post" style="display: none; inline-block;">
                            <input type="text" name="adresse" value="<?php echo isset($_SESSION['adresse']) ? $_SESSION['adresse'] : ''; ?>" required>
                            <button type="submit" class="btn btn-primary btn-sm">Enregistrer</button>
                        </form>
                    </p>

                    <p><strong>Téléphone :</strong> 
                        <span id="telDisplay"><?php echo isset($_SESSION['tel']) ? $_SESSION['tel'] : 'Téléphone non défini'; ?></span>
                        <button type="button" class="btn btn-link btn-sm ml-auto" onclick="editField('tel')">Modifier</button>
                        <form id="telForm" action="upload.php" method="post" style="display: none; inline-block;">
                            <input type="tel" name="tel" value="<?php echo isset($_SESSION['tel']) ? $_SESSION['tel'] : ''; ?>" required>
                            <button type="submit" class="btn btn-primary btn-sm">Enregistrer</button>
                        </form>
                    </p>
                </div>
            </div>
        </div>

        <script>
        function editField(field) {
            document.getElementById(field + 'Display').style.display = 'none';
            document.getElementById(field + 'Form').style.display = 'inline-block';
        }
        </script>
    </div>

    <footer class="footer">
        <div class="container-fluid">
            <div class="row text-center">
                <div class="site-logo col-md-12 mb-3">
                    <h5 class="mb-0 site-logo" style="font-size: 160%;">Omnes Immobilier</h5>
                </div>
                <div class="col-md-4 mb-3">
                    <p>Adresse : 10 Rue Sextius Michel, 75015 Paris, France</p>
                </div>
                <div class="col-md-4 mb-3">
                    <p>Téléphone : +33 1 23 45 67 89</p>
                </div>
                <div class="col-md-4 mb-3">
                    <p>Email : contact@omnesimmobilier.fr</p>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="map-container">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2624.5364824916036!2d2.2896013156759247!3d48.84883177928647!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e671c6b24f2cd7%3A0x6f98e5e56b1d39c3!2s10%20Rue%20Sextius%20Michel%2C%2075015%20Paris%2C%20France!5e0!3m2!1sen!2sus!4v1652874998836!5m2!1sen!2sus" 
                            width="100%" 
                            height="70%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
