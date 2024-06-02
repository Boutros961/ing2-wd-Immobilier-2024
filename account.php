<?php
include 'db.php';

$nom = $_POST['nom'];
$email = $_POST['email'];
$adresse = $_POST['adresse'];
$userId = 1; // ID de l'utilisateur actuellement connecté (à remplacer par la gestion de session)

// Mettre à jour les informations de l'utilisateur
$sql = "UPDATE Utilisateur SET Nom='$nom', Email='$email', Adresse='$adresse' WHERE ID=$userId";

if ($conn->query($sql) === TRUE) {
    echo "Les modifications ont été enregistrées avec succès.";
} else {
    echo "Erreur: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
