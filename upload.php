<?php
session_start();

// Vérifie si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

    // Récupère les données du formulaire
    $id_utilisateur = $_SESSION['id'];

    // Vérifie si les champs email, adresse et tel sont vides
    $email = !empty($_POST['email']) ? $_POST['email'] : $_SESSION['email'];
    $adresse = !empty($_POST['adresse']) ? $_POST['adresse'] : $_SESSION['adresse'];
    $tel = !empty($_POST['tel']) ? $_POST['tel'] : $_SESSION['tel'];

    $photo = null;
    // Vérifie si un fichier image a été téléchargé
    if (!empty($_FILES["photo"]["name"])) {
        // Vérifie si le fichier est une image réelle ou une fausse image
        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if ($check !== false) {
            // Lire le fichier image en tant que binaire
            $photo = file_get_contents($_FILES["photo"]["tmp_name"]);
        } else {
            echo "Le fichier n'est pas une image.";
        }
    }

    // Prépare la requête SQL
    if ($photo) {
        $sql = "UPDATE compte SET email=?, adresse=?, tel=?, photo=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $email, $adresse, $tel, $photo, $id_utilisateur);
    } else {
        $sql = "UPDATE compte SET email=?, adresse=?, tel=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $email, $adresse, $tel, $id_utilisateur);
    }

    // Exécute la requête et vérifie le résultat
    if ($stmt->execute()) {
        // Met à jour les valeurs dans la session
        $_SESSION['email'] = $email;
        $_SESSION['adresse'] = $adresse;
        $_SESSION['tel'] = $tel;

        // Redirige vers la page de compte après la mise à jour
        header('Location: myAccount.php');
        exit();
    } else {
        echo "Erreur lors de la mise à jour des informations dans la base de données.";
    }

    // Ferme la connexion à la base de données
    $stmt->close();
    $conn->close();
}
?>
