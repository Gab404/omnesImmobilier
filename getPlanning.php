<?php
// Démarrer la session pour récupérer la variable $_SESSION['email']
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: login.php");
    exit();
}

// Récupérer l'adresse e-mail de l'agent à partir de la requête GET
if(isset($_GET['agentEmail'])) {
    $agentEmail = $_GET['agentEmail'];
} else {
    // Gérer le cas où l'adresse e-mail de l'agent n'est pas fournie
    // Par exemple, rediriger l'utilisateur vers une page d'erreur
    header("Location: error.php");
    exit();
}

// Récupérer l'adresse du bien immobilier à partir de la requête GET
if(isset($_GET['propertyAddress'])) {
    $propertyAddress = $_GET['propertyAddress'];
} else {
    // Gérer le cas où l'adresse du bien immobilier n'est pas fournie
    // Par exemple, rediriger l'utilisateur vers une page d'erreur
    header("Location: error.php");
    exit();
}

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


$sql = "SELECT p.*, c.photoPath, c.nom, c.prenom
        FROM planning p
        INNER JOIN compte c ON p.mailAgent = c.email
        WHERE p.mailAgent = '$agentEmail'";

$result = $conn->query($sql);

// Créer un tableau associatif pour stocker les événements
$events = [];
$agentNom = "";
$agentPrenom = "";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Ajout des dates des rendez-vous à l'array $events
        $events[] = $row['date'];
        $agentNom = $row['nom'];
        $agentPrenom = $row['prenom'];
    }
} else {
    $sql = "SELECT c.nom, c.prenom 
        FROM compte c
        WHERE c.email = '$agentEmail'";

    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        // Ajout des dates des rendez-vous à l'array $events
        $agentNom = $row['nom'];
        $agentPrenom = $row['prenom'];
    }
}

// Fermer la connexion à la base de données
$conn->close();
?>



<!-- Le reste de votre code HTML/JavaScript reste inchangé -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Omnes Immobilier - Planning</title>
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

    .card {
      border: none;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      background-color: #ffffff;
      margin: 50px;
    }

    .calendar-header {
      text-align: center;
      font-size: 24px;
      margin-bottom: 20px;
    }

    .calendar-days {
      display: grid;
      grid-template-columns: repeat(7, 1fr);
      text-align: center;
    }

    .calendar-day {
      padding: 10px;
      border: none;
      cursor: pointer;
    }

    .calendar-day.current-day {
      color: #007bff;
    }

    .calendar-day.past-day {
      color: #ccc;
    }

    .calendar-day:hover {
      background-color: #f0f0f0;
      border-radius: 0.4rem;
    }

    .change-month-btns {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .change-month-btns button {
      border: none;
      background: none;
      font-size: 24px;
      cursor: pointer;
      color: #007bff;
    }

    .change-month-btns button:hover {
      color: #0056b3;
    }
    #eventDetails {
        margin-top: 20px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    #eventDetails h5 {
        margin-bottom: 10px;
        color: #333;
    }

    #eventDetails p {
        margin-bottom: 5px;
        font-size: 16px;
        color: #666;
    }

    .change-month-btns button {
        border: none;
        background: none;
        font-size: 24px;
        cursor: pointer;
        color: #007bff;
        transition: color 0.3s ease;
    }

    .change-month-btns button:hover {
        color: #0056b3;
    }

    .change-month-btns button:focus {
        outline: none; /* Enlève l'outline (bordure) lorsqu'un bouton est cliqué */
    }
    .has-event {
        background-color: #007bff;
        color: #fff;
        border-radius: 0.4rem; 
    }
    .has-event:hover {
        background-color: #0067d6;
        transition: 0.2s;
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
                            <li class="active"><a href="immobilier.php"><span>Tout Parcourir</span></a></li>
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
    <section id="accueil" class="mt-0">
        <img src="assets/Immobilier.jpg" class="hero-image" alt="Hero Image">
    </section>
<div class="container-fluid text-center" style="width: 60%;">
    <h1 class="my-4 text-center mb-3" style="color: black;">Agenda de <?php echo htmlspecialchars($agentPrenom) . " " . htmlspecialchars($agentNom);?></h1>
    <div class="card p-4">
        <div class="change-month-btns">
            <button id="prevMonthBtn"><i class="fas fa-chevron-left"><</i></button>
            <div class="calendar-header" id="calendarHeader"></div>
            <button id="nextMonthBtn"><i class="fas fa-chevron-right">></i></button>
        </div>
        <div id="calendar" class="mb-4"></div>
        <div id="eventDetails" style="display: none;">
            <h5>Détails du rendez-vous</h5>
            <img id="agentPhoto" src="" alt="Photo de l'agent" style="position: absolute; bottom: 15%; right: 10%; border-radius: 50%; object-fit: cover; width: 50px; height: 50px;">
            <p id="eventDate"></p>
            <p id="eventAdresse"></p>
            <p id="eventDigicode"></p>
            <form action="dropEvent.php" method="post">
                <input type="hidden" name="event_id" id="eventIdInput">
                <button id="cancelEventBtn" class="btn btn-primary" style="font-size: 80%; margin: 10px 0;">Annuler le rendez-vous</button>
            </form>
        </div>
    </div>
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
                    <p>Email : info@omnesimmobilier.com</p>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12 text-center">
                    <p class="mb-0">&copy; <script>document.write(new Date().getFullYear());</script> Omnes Immobilier. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendar = document.getElementById('calendar');
    const events = <?php echo json_encode($events); ?>;
    const calendarHeader = document.getElementById('calendarHeader');
    const prevMonthBtn = document.getElementById('prevMonthBtn');
    const nextMonthBtn = document.getElementById('nextMonthBtn');
    const eventDetails = document.getElementById('eventDetails');
    const eventDate = document.getElementById('eventDate');
    const eventAdresse = document.getElementById('eventAdresse');
    const eventDigicode = document.getElementById('eventDigicode');
    const agentPhoto = document.getElementById('agentPhoto');

    let currentMonth = new Date().getMonth();
    let currentYear = new Date().getFullYear();

    function renderCalendar(year, month) {
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const daysInMonth = lastDay.getDate();
        const startingDay = firstDay.getDay();
        const monthName = firstDay.toLocaleString('default', { month: 'long' });

        calendarHeader.textContent = `${monthName} ${year}`;

        let html = `
            <div class="calendar-days">
                <div class="calendar-day">Sun</div>
                <div class="calendar-day">Mon</div>
                <div class="calendar-day">Tue</div>
                <div class="calendar-day">Wed</div>
                <div class="calendar-day">Thu</div>
                <div class="calendar-day">Fri</div>
                <div class="calendar-day">Sat</div>
            </div>`;

        let day = 1;
        for (let i = 0; i < 42; i++) {
            if (i < startingDay || day > daysInMonth) {
                html += `<div class="calendar-day"></div>`;
            } else {
                const eventKey = `${year}-${month + 1 < 10 ? '0' : ''}${month + 1}-${day < 10 ? '0' : ''}${day}`;
                const event = events[eventKey];
                const isCurrentDay = (day === new Date().getDate() && month === new Date().getMonth() && year === new Date().getFullYear());
                const isPastDay = (day < new Date().getDate() && month === new Date().getMonth() && year === new Date().getFullYear());
                const dayClass = isCurrentDay ? 'current-day' : (isPastDay ? 'past-day' : '');
                const eventClass = event ? 'has-event' : '';
                html += `<div class="calendar-day ${dayClass} ${eventClass}" data-event='${JSON.stringify(event || {})}'>${day}</div>`;
                day++;
            }
        }

        calendar.innerHTML = html;

        const calendarDays = document.querySelectorAll('.calendar-day');
        calendarDays.forEach(dayElement => {
            dayElement.addEventListener('click', function() {
                const event = JSON.parse(this.dataset.event);
                if (event) {
                    eventDate.textContent = `Date: ${event.date}`;
                    eventAdresse.textContent = `Adresse: ${event.adresse}`;
                    eventDigicode.textContent = `Digicode: ${event.digicode}`;
                    agentPhoto.src = event.photoPath;
                    if (typeof event.date === 'undefined') {
                        eventDetails.style.display = 'none';
                    } else {
                        eventDetails.style.display = 'block';
                    }
                } else {
                    eventDetails.style.display = 'none';
                }
            });
        });
    }

    prevMonthBtn.addEventListener('click', function() {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        renderCalendar(currentYear, currentMonth);
    });

    nextMonthBtn.addEventListener('click', function() {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        renderCalendar(currentYear, currentMonth);
    });

    calendar.addEventListener('click', function(event) {
        const clickedDay = event.target;

        // Vérifier si la case cliquée est une journée valide du calendrier
        if (clickedDay.classList.contains('calendar-day') && clickedDay.innerText !== '') {
            const day = clickedDay.innerText.padStart(2, '0'); // Ajouter un zéro devant les jours de 1 à 9
            const month = (currentMonth + 1).toString().padStart(2, '0'); // Ajouter un zéro devant les mois de 1 à 9
            const year = currentYear;
            const eventDate = `${year}-${month}-${day}`;

            console.log(eventDate); // Pour vérifier la date cliquée dans la console

            // Si la case n'a pas d'événement, rediriger vers createEvent.php
            const agentEmail = '<?php echo $agentEmail; ?>';
            const propertyAddress = '<?php echo $propertyAddress; ?>';
            const url = `createEvent.php?date=${eventDate}&agentEmail=${agentEmail}&propertyAddress=${propertyAddress}`;

            window.location.href = url;
        }
    });

    // Initial rendering of the calendar
    renderCalendar(currentYear, currentMonth);
});

</script>



<script>

document.addEventListener('DOMContentLoaded', function() {
    const calendar = document.getElementById('calendar');
    const calendarHeader = document.getElementById('calendarHeader');
    const prevMonthBtn = document.getElementById('prevMonthBtn');
    const nextMonthBtn = document.getElementById('nextMonthBtn');
    const eventDetails = document.getElementById('eventDetails');
    const eventDate = document.getElementById('eventDate');
    const eventAdresse = document.getElementById('eventAdresse');
    const eventDigicode = document.getElementById('eventDigicode');
    const today = new Date();
    let currentMonth = today.getMonth();
    let currentYear = today.getFullYear();

    renderCalendar(currentYear, currentMonth);

    prevMonthBtn.addEventListener('click', function() {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        renderCalendar(currentYear, currentMonth);
    });

    nextMonthBtn.addEventListener('click', function() {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        renderCalendar(currentYear, currentMonth);
    });

    function renderCalendar(year, month) {
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const daysInMonth = lastDay.getDate();
        const startingDay = firstDay.getDay();
        const monthName = firstDay.toLocaleString('default', { month: 'long' });

        calendarHeader.textContent = `${monthName} ${year}`;

        let html = `
      <div class="calendar-days">
        <div class="calendar-day">Sun</div>
        <div class="calendar-day">Mon</div>
        <div class="calendar-day">Tue</div>
        <div class="calendar-day">Wed</div>
        <div class="calendar-day">Thu</div>
        <div class="calendar-day">Fri</div>
        <div class="calendar-day">Sat</div>
    `;

        let day = 1;
        for (let i = 0; i < 42; i++) {
            if (i < startingDay || day > daysInMonth) {
                html += `<div class="calendar-day"></div>`;
            } else {
                const eventKey = `${year}-${month + 1 < 10 ? '0' : ''}${month + 1}-${day < 10 ? '0' : ''}${day}`;
                const eventData = <?php echo json_encode($events); ?>;
                let event = null;
                for (let i = 0; i < eventData.length; i++) {
                    if (eventData[i] === eventKey) {
                        event = eventData[i];
                        break;
                    }
                }
                const isCurrentDay = (day === today.getDate() && month === today.getMonth() && year === today.getFullYear());
                const isPastDay = (day < today.getDate() && month === today.getMonth() && year === today.getFullYear());
                const dayClass = isCurrentDay ? 'current-day' : (isPastDay ? 'past-day' : '');
                const eventClass = event ? 'has-event' : '';
html += `<div class="calendar-day ${dayClass} ${eventClass}" data-event='${JSON.stringify(event || {})}'>${day}</div>`;
                day++;
            }
        }

        html += `</div>`;
        calendar.innerHTML = html;

        // Ajouter un gestionnaire d'événements pour afficher les détails de l'événement lorsqu'une case est cliquée
        const calendarDays = document.querySelectorAll('.calendar-day');
        calendarDays.forEach(dayElement => {
            dayElement.addEventListener('click', function() {
                const event = JSON.parse(this.dataset.event);
                if (event) {
                    eventDate.textContent = `Date: ${event.date}`;
                    eventAdresse.textContent = `Adresse: ${event.adresse}`;
                    eventDigicode.textContent = `Digicode: ${event.digicode}`;
                    agentPhoto.src = event.photoPath;
                    if (typeof event.date === 'undefined') {
                        eventDetails.style.display = 'none';
                    } else {
                        eventDetails.style.display = 'block';
                    }
                } else {
                    eventDetails.style.display = 'none';
                }
            });
        });


        calendarDays.forEach(dayElement => {
    dayElement.addEventListener('click', function() {
        const event = JSON.parse(this.dataset.event);
        if (event) {
            // Mettre à jour la valeur du champ caché avec l'ID de l'événement
            document.getElementById('eventIdInput').value = event.id;
            eventDate.textContent = `Date: ${event.date}`;
            eventAdresse.textContent = `Adresse: ${event.adresse}`;
            eventDigicode.textContent = `Digicode: ${event.digicode}`;
            agentPhoto.src = event.photoPath;
            if (typeof event.date === 'undefined') {
                eventDetails.style.display = 'none';
            } else {
                eventDetails.style.display = 'block';
            }
        } else {
            eventDetails.style.display = 'none';
        }
    });
});
    }
});

</script>
</body>
</html>
