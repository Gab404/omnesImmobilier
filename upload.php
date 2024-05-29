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

    // Vérifie si un fichier image a été téléchargé
    if (!empty($_FILES["photo"]["name"])) {
        // Dossier de destination pour les téléchargements
        $target_dir = "uploads/";

        // Assurez-vous que le dossier de destination existe, sinon créez-le
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        // Chemin complet du fichier de destination
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Vérifie si le fichier est une image réelle ou une fausse image
        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }

        // Vérifie la taille du fichier (optionnel, par exemple, limite de 5MB)
        if ($_FILES["photo"]["size"] > 5000000) {
            $uploadOk = 0;
        }

        // Autorise certains formats de fichiers
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $uploadOk = 0;
        }

        // Si tout est correct, essayez de télécharger le fichier
        if ($uploadOk == 1 && move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            // Met à jour le chemin de la photo dans la session
            $_SESSION['photo'] = $target_file;
        }
    }
    $sql = "UPDATE compte SET email=?, adresse=?, tel=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $email, $adresse, $tel, $id_utilisateur);

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