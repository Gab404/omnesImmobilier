<?php
session_start();
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
        .footer {
            background-color: #f1f1f1;
            padding: 40px 0;
        }
        .map-container {
            width: 100%;
            height: 400px;
        }
        .TextPresentation {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%; 
        }
        .presentation {
            max-width: 600px;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin: auto;
            color : black;
        }

        .presentation h1, .presentation h2, .presentation h3, .presentation h4, .presentation h5, .presentation h6 {
            text-align: center;
        }

        .presentation p {
            text-align: left;
            color: black;
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

      <div class="container">
        <div class="row align-items-center">
          
          <div class="col-11 col-xl-2">
            <h1 class="mb-0 site-logo"><a href="index.php" class="text-white mb-0">Omnes Immobilier</a></h1>
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
                  // Vérifiez si l'utilisateur est connecté
                  if(isset($_SESSION['email'])) {
                      echo '<li><a href="myAccount.php"><span>Mon Compte</span></a></li>';
                      echo '<li><a href="logout.php"><span>Déconnexion</span></a></li>';
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
          <p>Explorez nos villas de luxe avec piscine et vue imprenable sur la mer.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="assets/immobilierCommercial.jpg" class="d-block w-100" alt="..." style="max-height: 500px;object-fit: cover;">
        <div class="carousel-caption d-none d-md-block">
          <h5>Immobilier Commercial</h5>
          <p>Consultez nos larges offres d'immobilier commercial dans toute la France.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="assets/appartement.jpg" class="d-block w-100" alt="..." style="max-height: 500px;object-fit: cover;">
        <div class="carousel-caption d-none d-md-block">
          <h5>Appartement moderne</h5>
          <p>Découvrez notre sélection d'appartements modernes à vendre ou à louer.</p>
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
    <div class="presentation">
        <h1>OmnesImmobilier : Votre Partenaire de Confiance en Immobilier</h1>
        <br></br>
        <p>Bienvenue chez <strong>OmnesImmobilier</strong>, votre expert de confiance pour toutes vos transactions immobilières. Forts de notre expérience et de notre connaissance approfondie du marché, nous vous accompagnons dans chaque étape de vos projets immobiliers, que ce soit pour l'achat, la vente, la location ou la gestion de biens.</p>
        
        <div class="section-title">Notre Mission</div>
        <p>Chez OmnesImmobilier, notre mission est simple : vous offrir un service personnalisé et de qualité pour répondre à toutes vos attentes. Nous nous engageons à vous fournir des solutions adaptées à vos besoins spécifiques, en mettant l'accent sur la transparence, la fiabilité et la satisfaction client.</p>
        
        <div class="section-title">Nos Services</div>
        <p><strong>Achat et Vente</strong> : Que vous soyez à la recherche de votre résidence principale, d'une résidence secondaire ou d'un investissement locatif, nous vous aidons à trouver le bien idéal. Notre équipe d'experts vous accompagne également dans la vente de votre propriété, en vous proposant une estimation précise et en mettant en place des stratégies de marketing efficaces pour une vente rapide et au meilleur prix.</p>
        <p><strong>Location</strong> : Nous vous aidons à trouver le locataire parfait pour votre bien ou à dénicher la location qui répond à tous vos critères. Grâce à notre réseau et notre expertise, nous assurons une gestion locative sans tracas.</p>
        <p><strong>Gestion de Biens</strong> : Libérez-vous des contraintes de la gestion immobilière grâce à nos services complets de gestion de biens. Nous prenons en charge toutes les démarches administratives et techniques pour que vous puissiez profiter de vos investissements en toute sérénité.</p>
        <p><strong>Conseil en Investissement</strong> : Bénéficiez de notre expertise pour optimiser vos investissements immobiliers. Nous vous guidons dans le choix des meilleurs placements et vous accompagnons dans leur gestion pour maximiser votre rentabilité.</p>
        
        <div class="section-title">Nos Valeurs</div>
        <p><strong>Professionnalisme</strong> : Notre équipe est composée de professionnels passionnés et expérimentés, dédiés à vous offrir un service irréprochable.</p>
        <p><strong>Écoute et Proximité</strong> : Nous privilégions une relation de proximité avec nos clients, basée sur l'écoute et la compréhension de vos besoins.</p>
        <p><strong>Innovation</strong> : Toujours à l'affût des dernières tendances et technologies, nous utilisons des outils modernes pour optimiser nos services et vous offrir une expérience client exceptionnelle.</p>
        
        <div class="section-title">Contactez-nous</div>
        <p>N'attendez plus pour concrétiser vos projets immobiliers ! Contactez-nous dès aujourd'hui pour discuter de vos besoins et découvrir comment nous pouvons vous aider à réaliser vos ambitions.</p>
        
        <p><strong>OmnesImmobilier</strong><br>
        Votre avenir commence ici.</p>
    </div>
    </br></br>
    </br></br>
<footer class="footer">
        <div class="container">
            <div class="row text-center">
                <div class="site-logo col-md-12 mb-3">
                    <h5 class="mb-0 site-logo" style="font-size: 160%;">Omnes Immobilier: Votre Partenaire de Confiance en Immobilier</h5>
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

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>
