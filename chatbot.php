<?php
// Démarrer la session pour récupérer la variable $_SESSION['email']
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
// if (!is_array($compteAgent)) {
//   echo '$compteAgent n\'est pas un tableau';
// } else {
//   echo '$compteAgent est un tableau';
// }

// Fermer la connexion à la base de données
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
</head>
<body>
    
    
 
<div id="chatbot" style="position: fixed; bottom: 0; right: 0; width: 300px; height: 400px; border: 1px solid #dee2e6; padding: 10px; background-color: #333; color: white; z-index: 1000; border-radius: 15px 0px 0px 0px; box-shadow: 0 0 10px rgba(0,0,0,0.1); opacity: 0; visibility: hidden; transition: visibility 0s, opacity 0.2s linear;">
  <div id="chatbot-messages" style="height: 90%; overflow: auto; border: 1px solid #dee2e6; border-radius: 10px; padding: 10px; margin-bottom: 10px; transition: visibility 0s, opacity 1s linear; /* Transition plus rapide */"></div>
</div>

<button id="chatbot-toggle" style="position: fixed; bottom: 10px; right: 10px; z-index: 1001; background-color: #007BFF; color: white; border: none; border-radius: 50%; width: 50px; height: 50px; font-size: 24px; line-height: 50px; text-align: center;">&#8593;</button>

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
<!-- <script src="js/chatbot.js"></script> -->

</body>
</html>
