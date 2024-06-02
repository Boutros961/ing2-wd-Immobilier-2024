<?php
include 'db.php';

$propertyId = $_GET['id'];

$sql = "SELECT p.*, u.Nom AS AgentNom, u.Prenom AS AgentPrenom, a.ID AS AgentID 
        FROM Propriete p
        JOIN Agent a ON p.AgentID = a.ID
        JOIN Utilisateur u ON a.UtilisateurID = u.ID
        WHERE p.ID = $propertyId";

$result = $conn->query($sql);

$property = null;

if ($result->num_rows > 0) {
    $property = $result->fetch_assoc();
}

echo json_encode($property);

$conn->close();
?>
