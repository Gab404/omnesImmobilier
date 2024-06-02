<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            background-color: #f3f2f1;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .container {
            width: 90%;
            height: 90%;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .video-grid {
            display: flex;
            justify-content: space-between;
            height: 90%;
            padding: 10px;
        }
        .video-tile {
            position: relative;
            background: #c8c8c8;
            border-radius: 10px;
            overflow: hidden;
            flex: 1;
            margin: 0 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .video-tile img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .video-tile .name {
            position: absolute;
            bottom: 10px;
            left: 10px;
            color: white;
            background: rgba(0, 0, 0, 0.5);
            padding: 5px 10px;
            border-radius: 5px;
        }
        .video-controls {
            display: flex;
            justify-content: center;
            gap: 10px;
            padding: 20px;
        }
        .video-controls button {
            background: #0078d4;
            border: none;
            color: white;
            padding: 10px;
            border-radius: 50%;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="video-grid">
            <?php
            $agent = $_GET['agent'];
            $currentPage = $_GET['currentPage'];

            // Database connection
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "omnesImmobilier";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM compte WHERE prenom = '$agent' AND type = 2";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<div class='video-tile'>";
                    echo "<img src='" . $row["photoPath"] . "' alt='Agent image'>";
                    echo "<div class='name'>" . $row["prenom"]. " " . $row["nom"]. "</div>";
                    echo "</div>";
                }
            } else {
                echo "<div class='video-tile'><div class='name'>Agent Not Found</div></div>";
            }
            $conn->close();
            ?>
            <?php
session_start(); // Start the session

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "omnesImmobilier";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['id']; // Get the current user's ID

$sql = "SELECT photoPath FROM compte WHERE id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $photoPath = $row["photoPath"];
        if ($photoPath == "") {
            $photoPath = "assets/default.png"; // Default image if user has no photo
        }
    }
} else {
    $photoPath = "assets/default.png";
}
$conn->close();

// Now you can use $photoPath to display the user's image
echo "<div class='video-tile'>";
echo "<img src='" . $photoPath . "' alt='User image'>";
echo "<div class='name'>You</div>";
echo "</div>";
?>
        </div>
        <div class="video-controls">
            <button>&#128065;</button> <!-- Camera icon -->
            <button>&#128266;</button> <!-- Microphone icon -->
            <button onclick="window.location.href = '<?php echo $currentPage; ?>';">&#128682;</button> <!-- Hang up icon -->
        </div>
    </div>
</body>
</html>