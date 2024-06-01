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
      .carousel-text {
        color: white;
      }
      .footer {
          background-color: #f1f1f1;
          padding: 40px 0;
      }
      .map-container {
          width: 100%;
          height: 400px;
      }
      .presentation {
          max-width: 600px;
          padding: 20px;
          background-color: white;
          box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
          border-radius: 8px;
          margin: auto;
          color: black;
      }
      .presentation h1, .presentation h2, .presentation h3, .presentation h4, .presentation h5, .presentation h6 {
          text-align: center;
          color: #333;
      }
      .presentation p {
          text-align: left;
          color: #505050;
      }
      .site-logo {
          display: flex;
          align-items: center;
      }
      .site-logo img {
          max-height: 50px;
          margin-right: 10px;
      }
      #info-semaine .row {
      display: flex;
      flex-wrap: wrap;
    }

    #info-semaine .col-md-4 {
      display: flex;
      flex-direction: column;
    }

    #info-semaine .card {
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: box-shadow 0.3s ease-in-out;
    }

    #info-semaine .card:hover {
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    #info-semaine .card-body {
      flex-grow: 1;
    }

    #info-semaine .card-title {
      font-size: 20px;
      color: #333;
    }

    #info-semaine .card-text {
        font-size: 16px;
        color: #666;
    }
    #info-semaine .card-img-top {
      width: 100%;
      height: 200px; /* Ajustez cette valeur selon vos besoins */
      object-fit: cover;
      object-position: center;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
    }
    </style>
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <title>Omnes Immobilier - Home</title>
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
                <li class="active"><a href="index.php"><span>Home</span></a></li>
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
                  // Vérifiez si l'utilisateur ou l'utilisatrice est connecté
                  if(isset($_SESSION['email'])) {
                      echo '<li><a href="myAccount.php"><span>Mon Compte</span></a></li>';
                      echo '<li><a href="logout.php"><span>Déconnexion</span></a></li>';
                      if ($compte_type == '3') {
                        echo '<li><a href="admin.php"><span>Admin</span></a></li>';
                      }
                      else {
                      }
                  } else {
                      echo '<li><a href="login.php"><span>Connexion</span></a></li>';
                      echo '<li><a href="signup.php"><span>Inscription</span></a></li>';

                  }
                  ?>
              </ul>
            </nav>
          </div>


          <div class="d-inline-block d-xl-none ml-md-0 mr-auto py-3" style="position: relative; top: 3px;"><a href="#" class="site-menu-toggle js-menu-toggle text-white"><span class="icon-menu h3"></span></a></div>

          </div>

        </div>
      </div>
      
    </header>

    <?php if(isset($_SESSION['account_created'])): ?>
    <div id="notificationContainer" class="alert alert-success position-fixed w-25 text-center fixed-top mx-auto" role="alert" style="z-index: 9999; background-color: rgba(215, 237, 218, 0.9); top: 20px;">
        <strong>Votre compte a été créé avec succès!</strong>
    </div>
    <?php unset($_SESSION['account_created']); ?>
    <?php endif; ?>

<section id="accueil" class="mt-0">
  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="5000" style="max-height: 500px;">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="assets/villa.jpg" class="d-block w-100" alt="..." style="max-height: 500px;object-fit: cover;">
        <div class="carousel-caption d-none d-md-block">
          <h5>Villa de luxe</h5>
          <p class="carousel-text">Explorez nos villas de luxe avec piscine et vue imprenable sur la mer.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="assets/immobilierCommercial.jpg" class="d-block w-100" alt="..." style="max-height: 500px;object-fit: cover;">
        <div class="carousel-caption d-none d-md-block">
          <h5>Immobilier Commercial</h5>
          <p class="carousel-text">Consultez nos larges offres d'immobilier commercial dans toute la France.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="assets/appartement.jpg" class="d-block w-100" alt="..." style="max-height: 500px;object-fit: cover;">
        <div class="carousel-caption d-none d-md-block">
          <h5>Appartement moderne</h5>
          <p class="carousel-text">Découvrez notre sélection d'appartements modernes à vendre ou à louer.</p>
        </div>
      </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</section>
    </br></br>
    </br></br>

    <div class="container mt-5">
    <h1>Rajouter un bien immobilier:</h1>

    <form method="post" action="" class="mt-4">
        <div class="form-group">
            <label for="photoPath">Photo Path:</label>
            <input type="text" class="form-control" id="photoPath" name="photoPath">
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <input type="text" class="form-control" id="description" name="description">
        </div>
        <div class="form-group">
            <label for="nbPiece">Number of Rooms:</label>
            <input type="number" class="form-control" id="nbPiece" name="nbPiece">
        </div>
        <div class="form-group">
            <label for="nbChambre">Number of Bedrooms:</label>
            <input type="number" class="form-control" id="nbChambre" name="nbChambre">
        </div>
        <div class="form-group">
            <label for="dimension">Dimension:</label>
            <input type="number" class="form-control" id="dimension" name="dimension">
        </div>
        <div class="form-group">
            <label for="adresse">Address:</label>
            <input type="text" class="form-control" id="adresse" name="adresse">
        </div>
        <div class="form-group">
            <label for="pathVideo">Video Path:</label>
            <input type="text" class="form-control" id="pathVideo" name="pathVideo">
        </div>
        <div class="form-group">
            <label for="type">Type:</label>
            <input type="text" class="form-control" id="type" name="type">
        </div>
        <div class="form-group">
            <label for="prix">Price:</label>
            <input type="number" class="form-control" id="prix" name="prix">
        </div>
        <div class="form-group">
            <label for="agent">Agent:</label>
            <input type="text" class="form-control" id="agent" name="agent">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>


  

  <div id="chatbot" style="position: fixed; bottom: 0; right: 0; width: 300px; height: 400px; border: 1px solid #dee2e6; padding: 10px; background-color: white; z-index: 1000; border-radius: 15px 0px 0px 0px; box-shadow: 0 0 10px rgba(0,0,0,0.1); opacity: 0; visibility: hidden; transition: visibility 0s, opacity 0.5s linear;">
  <div id="chatbot-messages" style="height: 90%; overflow: auto; border: 1px solid #dee2e6; border-radius: 10px; padding: 10px; margin-bottom: 10px;"></div>
  <input id="chatbot-input" type="text" style="width: 100%; padding: 5px; border: 1px solid #dee2e6; border-radius: 5px;" placeholder="Type your message here..." />
</div>

<button id="chatbot-toggle" style="position: fixed; bottom: 10px; right: 10px; z-index: 1001; background-color: #007BFF; color: white; border: none; border-radius: 50%; width: 50px; height: 50px; font-size: 24px; line-height: 50px; text-align: center;">&#8593;</button>



    <br></br>
    <br></br>

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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var successMessage = document.getElementById('notificationContainer');
        if (successMessage) {
            setTimeout(function () {
                successMessage.style.display = 'none';
            }, 3000);
        }
    });
</script>

<script>
  document.getElementById('chatbot-toggle').addEventListener('click', function() {
    var chatbot = document.getElementById('chatbot');
    var toggleButton = document.getElementById('chatbot-toggle');
    if (chatbot.style.opacity === '0') {
      chatbot.style.opacity = '1';
      chatbot.style.visibility = 'visible';
      toggleButton.innerHTML = '&#8595;';
    } else {
      chatbot.style.opacity = '0';
      chatbot.style.visibility = 'hidden';
      toggleButton.innerHTML = '&#8593;';
    }
  });
</script>
    <script src="js/chatbot.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>
