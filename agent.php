<?php
session_start();
 // Vérifier si l'utilisateur est connecté
 if (!isset($_SESSION['email'])) {
  // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
  header("Location: login.php");
  exit();
}

$compte_email = $_SESSION['email'];

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "omnesimmobilier";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Requête SQL pour récupérer le type de compte
$sql = "SELECT type FROM compte WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $compte_email);
$stmt->execute();
$stmt->bind_result($compte_type);
$stmt->fetch();
$stmt->close();


// Échapper les entrées utilisateur pour éviter les attaques par injection SQL
$clientEmail = $conn->real_escape_string($_SESSION['email']);

// Requête SQL pour récupérer les événements du client connecté
$sql = "SELECT p.*, c.photoPath, TIME_FORMAT(p.heure, '%H:%i') as formatted_time
      FROM planning p
      INNER JOIN compte c ON p.mailAgent = c.email
      WHERE p.mailClient = '$clientEmail'";
$result = $conn->query($sql);

// Créer un tableau associatif pour stocker les événements
$events = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
      $row['heure'] = $row['formatted_time']; // Remplacer 'heure' par 'formatted_time'
      // Ajouter la colonne photoPath à chaque objet event
      $row['photoPath'] = $row['photoPath'];
      $events[$row['date']][] = $row; // Utiliser la date comme clé et stocker tous les événements pour cette date
  }
}

// Récupérer les agents de type 2
$sql = "SELECT * FROM compte WHERE type = 2";
$result2 = $conn->query($sql);
$compteAgent = $result2->fetch_all(MYSQLI_ASSOC);

$email = $_SESSION['email'];

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

// Requête SQL pour récupérer les données des agents
$sql = "SELECT email, nom, prenom, photoPath, cvPath, tel as telephone FROM compte WHERE type = 2";
$result = $conn->query($sql);

 // Requête SQL pour récupérer le type de compte
 $sql = "SELECT type FROM compte WHERE email = ?";
 $stmt = $conn->prepare($sql);
 $stmt->bind_param("s", $email);
 $stmt->execute();
 $stmt->bind_result($compte_type);
 $stmt->fetch();
 $stmt->close();
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
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        .custom-box {
            border: 4px solid black;
            padding: 20px;
            background-color: #f8f9fa;
            text-align: center;
            width: fit-content;
            margin: 0 auto;
            font-family: Arial, sans-serif;
            color: black;
            font-size: 40px;
        }
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
            margin-top: 1rem;
            margin-bottom: 1rem; 
        }
        .right-column {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .gif {
            width: 600px;
            height: auto;
            margin-top: 1rem;
            margin-bottom: 1rem; 
        }
        .card {
            margin: 15px;
            border: none;
            overflow: hidden;
            position: relative;
        }
        .card img {
            transition: transform 0.5s ease;
        }
        .card-img-top {
            width: 100%; 
            height: 250px;
            object-fit: cover;
        }
        .card:hover img {
            transform: scale(1.1);
        }
        .card .card-body {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0, 123, 255, 0.3);
            color: white;
            opacity: 0;
            transition: opacity 0.5s ease;
        }
        .card:hover .card-body {
            opacity: 1;
        }
        .card-title, .card-text {
            color: white;
        }
        .btn-cv {
            width: 40%;
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
            max-height: 50px;
            margin-right: 10px;
        }
        .chatbot-question {
        background-color: #0067d6; /* Blue */
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
        transition-duration: 0.4s;
        border-radius: 20px;
        }

        .chatbot-question:hover {
        background-color: #005cbf; /* Darker blue */
        color: white;
        }
    </style>
    <title>Omnes Immobilier - Agents</title>
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
                <div class="ml-5" style="position: absolute; top: 0%; left: 10%;">
                  Omnes Immobilier
                </div>
              </a>
            </h1>
          </div>
          <div class="col-12 col-md-10 d-none d-xl-block">
            <nav class="site-navigation position-relative text-right" role="navigation">
              <ul class="site-menu js-clone-nav mr-auto d-none d-lg-block">
                <li><a href="index.php"><span>Home</span></a></li>
                <li class="has-children active">
                  <a href="#"><span>Recherche</span></a>
                  <ul class="dropdown arrow-top">
                    <li class="active"><a href="agent.php">Agent</a></li>
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
          <div class="d-inline-block d-xl-none ml-md-0 mr-auto py-3" style="position: relative; top: 3px;">
            <a href="#" class="site-menu-toggle js-menu-toggle text-white">
              <span class="icon-menu h3"></span>
            </a>
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
        <img src="assets/bgAgent.jpg" class="hero-image" alt="Hero Image">
    </section>

    <div class="container-fluid mt-5 text-center">
    <h1 class="my-4 text-center mb-5" style="color: #007bff;">
    <span style="color: black;">Nos </span>Agents
        </h1>
        <div class="container-fluid mt-3 text-center" style="width: 30%;">
            <div class="row">
                <div class="col-md-12">
                    <input type="text" id="searchInput" class="form-control mb-3" placeholder="Rechercher par nom ou prénom">
                </div>
            </div>
        </div>
        <div class="row" id="searchResult">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="col-md-4">';
                    echo '    <div class="card">';
                    echo '        <img src="' . $row["photoPath"] . '" class="card-img-top" alt="Photo de ' . $row["prenom"] . ' ' . $row["nom"] . '">';
                    echo '        <div class="card-body d-flex flex-column">';
                    echo '            <div class="mt-auto text-center">';
                    echo '              <h5 class="card-title">' . $row["prenom"] . ' ' . $row["nom"] . '</h5>';
                    echo '              <p class="card-text">Email : ' . $row["email"] . '</p>';
                    echo '              <p class="card-text">Téléphone : ' . $row["telephone"] . '</p>';
                    echo '              <a href="#" data-cv="' . addslashes($row["cvPath"]) . '" class="btn btn-primary btn-cv">CV</a>';
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
        </div>
    </div>

    <!-- Modal pour afficher le CV -->
    <div class="modal fade" id="cvModal" tabindex="-1" role="dialog" aria-labelledby="cvModalLabel" aria-hidden="true" style="z-index: 2000;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="width: 70%;">
                <div class="modal-header">
                    <h5 class="modal-title" id="cvModalLabel">CV</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="cvImage" src="" alt="CV" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <div id="chatbot" style="position: fixed; bottom: 0; right: 0; width: 300px; height: 400px; border: 1px solid #dee2e6; padding: 10px; background-color: #333; color: white; z-index: 1000; border-radius: 15px 0px 0px 0px; box-shadow: 0 0 10px rgba(0,0,0,0.1); opacity: 0; visibility: hidden; transition: visibility 0s, opacity 0.2s linear;">
  <div id="chatbot-messages" style="height: 90%; overflow: auto; border: 1px solid #dee2e6; border-radius: 10px; padding: 10px; margin-bottom: 10px; transition: visibility 0s, opacity 1s linear; /* Transition plus rapide */"></div>
</div>

<button id="chatbot-toggle" style="position: fixed; bottom: 10px; right: 10px; z-index: 1001; background-color: #007BFF; color: white; border: none; border-radius: 50%; width: 50px; height: 50px; font-size: 24px; line-height: 50px; text-align: center;">&#8593;</button>

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
                <div class="gif">
                <img src="assets/omnes.gif" alt="Omnes Immobilier GIF" width="300">
            </div>
            <div class="right-column">
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            document.querySelectorAll('.btn-cv').forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    // Ajoutez ici le code que vous voulez exécuter lorsque le bouton est cliqué
                    let cvPath = this.getAttribute('data-cv');
                    console.log(cvPath); // Ceci est juste un exemple, vous pouvez le remplacer par votre propre code
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            var successMessage = document.getElementById('notificationContainer');
            if (successMessage) {
                setTimeout(function () {
                    successMessage.style.display = 'none';
                }, 3000);
            }
        });

        $(document).ready(function() {
            $('.btn-cv').on('click', function() {
                var cvPath = decodeURIComponent($(this).data('cv')); // Récupère le chemin du CV et décode les backslashes échappés
                console.log(cvPath); // Vérifiez la valeur de cvPath
                $('#cvImage').attr('src', cvPath); // Met à jour l'attribut src de l'image dans le modal
                
                // Ouvre le modal
                $('#cvModal').modal('show');
            });
        });

        // Recherche dynamique des agents
        document.getElementById("searchInput").addEventListener("input", function() {
            var inputVal = this.value;
            searchAgents(inputVal);
        });

        function searchAgents(inputVal) {
            var searchQuery = inputVal;
            fetch('searchAgent.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'searchQuery=' + encodeURIComponent(searchQuery),
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById('searchResult').innerHTML = data;
            })
            .catch(error => {
                console.error('Erreur lors de la recherche:', error);
            });
        }
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
<script>
var chatbotMessages = document.getElementById('chatbot-messages');
var agents = <?php echo json_encode($compteAgent); ?>;
var chatFlow = {
  "Contacter les agents ?": {
    response: "Choississez un moyen de contact :",
    followUp: {
      "Email": {
        response: "Choississez un agent :",
        followUp: {}
      },
      "Video Conférence": {
        response: "Choississez un agent :",
        followUp: {}
      }
    }
  },
  "En savoir plus sur le site ?": {
    response: "Chez OmnesImmobilier, notre mission est simple : vous offrir un service personnalisé et de qualité pour répondre à toutes vos attentes. Nous nous engageons à vous fournir des solutions adaptées à vos besoins spécifiques, en mettant l'accent sur la transparence, la fiabilité et la satisfaction client."
  }
};

agents.forEach(function(agent) {
  chatFlow["Contacter les agents ?"].followUp["Video Conférence"].followUp[agent.prenom] = {
    response: "Je vous met en contact avec : " + agent.prenom 
  };
  chatFlow["Contacter les agents ?"].followUp["Email"].followUp[agent.prenom] = {
    response: "Je vous redirige vers l'email de " + agent.prenom + " est " + agent.email
  };
});

var currentChat = chatFlow;

function displayMessage(message, className, boolQuestion) {
  var messageDiv = document.createElement('div');
  messageDiv.textContent = message;
  messageDiv.className = className;
  chatbotMessages.appendChild(messageDiv);

  if (!boolQuestion) {
    var nextButton = document.createElement('button');
    nextButton.textContent = 'Suivant';
    nextButton.className = 'chatbot-question'; // Assign the same class as the question buttons
    nextButton.style.padding = '5px 10px'; // Adjust the padding to make the button smaller
    chatbotMessages.appendChild(nextButton);

    nextButton.addEventListener('click', function() {
      if (message.startsWith("Je vous met en contact avec :")) {
        var agent = message.split(" ")[7];
        console.log(agent);
        var currentPage = encodeURIComponent(window.location.href);
        window.location.href = "videoConference.php?agent=" + encodeURIComponent(agent) + "&currentPage=" + currentPage;
      }
      if (message.startsWith("Je vous redirige vers l'email de ")) {
        var email = message.split(" ")[8];
        console.log(email);
        var currentPage = encodeURIComponent(window.location.href);
        window.location.href = "sendEmail.php?email=" + encodeURIComponent(email) + "&currentPage=" + currentPage;
      }
      if (currentChat.followUp) {
        displayQuestions(currentChat.followUp);
        currentChat = currentChat.followUp;
      } else {
        displayQuestions(chatFlow);
        currentChat = chatFlow;
      }
    });
    
  }
}

function displayQuestions(questions) {
  chatbotMessages.innerHTML = ''; // Clear the chatbot messages
  for (var question in questions) {
    displayMessage(question, 'chatbot-question', true);
  }
}

function hideQuestions() {
  chatbotMessages.innerHTML = '';
}

displayQuestions(currentChat); // Display the main questions at the beginning

// Add a click event listener to each question
chatbotMessages.addEventListener('click', function(e) {
  if (e.target && e.target.className === 'chatbot-question') {
    var question = e.target.textContent;

    var response = currentChat[question].response;
    var followUp = currentChat[question].followUp;

    // Update currentChat to the selected question
    currentChat = currentChat[question];

    // Remove the user's question
    e.target.parentNode.removeChild(e.target);

    hideQuestions(); // Hide the questions after the user has clicked on one

    displayMessage(response, 'chatbot-response', false);
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
