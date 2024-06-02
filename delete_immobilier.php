<?php
    // Database credentials
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

    $idImmobilier = $_POST['idImmobilier'];

    $sql = "DELETE FROM immobilier WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idImmobilier);
    $stmt->execute();

    // Redirect the user to the previous page
    header("Location: " . $_SERVER['HTTP_REFERER']);
?>