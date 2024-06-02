<?php
require_once 'db.php';

$clientId = $_POST['clientId'];
$propertyId = $_POST['propertyId'];
$agentId = $_POST['agentId'];
$rentalDuration = $_POST['rentalDuration'];
$cardType = $_POST['cardType'];
$cardNumber = $_POST['cardNumber'];
$cardName = $_POST['cardName'];
$cardExpiry = $_POST['cardExpiry'];
$cardCVC = $_POST['cardCVC'];


// Récupération des détails de la propriété
$sql = "SELECT Prix FROM propriete WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $propertyId);
$stmt->execute();
$result = $stmt->get_result();
$propriete = $result->fetch_assoc();
$prix = $propriete['Prix'];
$fraisAgence = $prix;
$montantTotal = $prix * $rentalDuration + $fraisAgence;

// Traitement du paiement (simulation)
$paymentSuccess = true; // Vous devriez intégrer un système de paiement réel ici

if ($paymentSuccess) {
    // Enregistrement de la location dans la base de données
    $sql = "INSERT INTO location (ClientID, AgentID, ProprieteID, Prix, Duree) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iiidi', $clientId, $agentId, $propertyId, $prix, $rentalDuration);
    $stmt->execute();

    echo json_encode(['success' => true, 'message' => 'Paiement effectué avec succès']);
} else {
    echo json_encode(['success' => false, 'message' => 'Échec du paiement']);
}

$conn->close();
?>
