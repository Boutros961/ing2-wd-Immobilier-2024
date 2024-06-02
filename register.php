<?php
require_once 'db.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $motdepasse = $_POST['password']; // Pas de hachage
    $telephone = $_POST['telephone'];
    $adresse = $_POST['adresse'];
    $ville = $_POST['ville'];
    $codepostal = $_['codepostal'];
    $pays = $_['pays'];

    // Vérifiez si l'email existe déjà
    $checkEmailSql = "SELECT * FROM utilisateur WHERE Email = '$email'";
    $checkEmailResult = $conn->query($checkEmailSql);

    if ($checkEmailResult->num_rows > 0) {
        echo json_encode(['error' => 'Cet email est déjà utilisé']);
        $conn->close();
        exit();
    }

    $sql = "INSERT INTO utilisateur (Nom, Prenom, Email, MotDePasse, NumeroDeTelephone, Adresse, Ville, CodePostal, Pays, Type) 
            VALUES ('$nom', '$prenom', '$email', '$motdepasse', '$telephone', '$adresse', '$ville, $codepostal, $pays, 'Client')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'Compte créé avec succès']);
    } else {
        echo json_encode(['error' => 'Erreur lors de la création du compte : ' . $conn->error]);
    }

    $conn->close();
}
?>
