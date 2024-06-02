<?php
require_once 'db.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $motdepasse = password_hash($_POST['motdepasse'], PASSWORD_DEFAULT);
    $telephone = $_POST['telephone'];
    $adresse = $_POST['adresse'];

    $sql_user = "INSERT INTO utilisateur (Nom, Prenom, Email, MotDePasse, NumeroDeTelephone, Adresse, Type) 
                 VALUES ('$nom', '$prenom', '$email', '$motdepasse', '$telephone', '$adresse', 'Agent')";

    if ($conn->query($sql_user) === TRUE) {
        $user_id = $conn->insert_id;
        $specialite = $_POST['specialite'];
        $sql_agent = "INSERT INTO agent (UtilisateurID, Specialite) VALUES ('$user_id', '$specialite')";
        if ($conn->query($sql_agent) === TRUE) {
            echo "New agent added successfully";
        } else {
            echo "Error: " . $sql_agent . "<br>" . $conn->error;
        }
    } else {
        echo "Error: " . $sql_user . "<br>" . $conn->error;
    }

    $conn->close();
}
