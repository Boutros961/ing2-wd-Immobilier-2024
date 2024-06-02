<?php
require_once 'db.php';

// Fonction pour répondre avec un message JSON
function respond($message, $success = false) {
    echo json_encode(['success' => $success, 'message' => $message]);
    exit;
}

// Récupérer les données POST
$clientId = $_POST['clientId'];
$propertyId = $_POST['propertyId'];
$agentId = $_POST['agentId'];
$cardType = $_POST['cardType'];
$cardNumber = $_POST['cardNumber'];
$cardName = $_POST['cardName'];
$cardExpiry = $_POST['cardExpiry'];
$cardCVC = $_POST['cardCVC'];

// Vérifier les informations de la carte de crédit
$cardSql = "SELECT * FROM cartescredit WHERE IDClient = ? AND TypeCarte = ? AND NumeroCarte = ? AND NomAffiche = ? AND DateExpiration = ? AND CodeSecurite = ?";
$stmt = $conn->prepare($cardSql);

if (!$stmt) {
    respond('Erreur de préparation de la requête: ' . $conn->error);
}

$stmt->bind_param("isssss", $clientId, $cardType, $cardNumber, $cardName, $cardExpiry, $cardCVC);
$stmt->execute();
$cardResult = $stmt->get_result();

if (!$cardResult) {
    respond('Erreur d\'exécution de la requête: ' . $stmt->error);
}

if ($cardResult->num_rows > 0) {
    // Récupérer le prix de la propriété
    $propertySql = "SELECT Prix FROM propriete WHERE ID = ?";
    $stmt = $conn->prepare($propertySql);
    
    if (!$stmt) {
        respond('Erreur de préparation de la requête (propriété): ' . $conn->error);
    }

    $stmt->bind_param("i", $propertyId);
    $stmt->execute();
    $propertyResult = $stmt->get_result();

    if (!$propertyResult) {
        respond('Erreur d\'exécution de la requête (propriété): ' . $stmt->error);
    }

    $property = $propertyResult->fetch_assoc();
    $prix = $property['Prix'];

    // Ajout de messages de débogage pour les valeurs des paramètres
    error_log("clientId: $clientId, agentId: $agentId, propertyId: $propertyId, prix: $prix");

    // Enregistrer l'achat
    $purchaseSql = "INSERT INTO achat (ClientID, AgentID, ProprieteID, Prix) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($purchaseSql);

    if (!$stmt) {
        respond('Erreur de préparation de la requête (achat): ' . $conn->error);
    }

    $stmt->bind_param("iiid", $clientId, $agentId, $propertyId, $prix);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        respond('Achat enregistré avec succès!', true);
    } else {
        respond('Erreur lors de l\'enregistrement de l\'achat: ' . $stmt->error);
    }
} else {
    respond('Informations de carte de crédit incorrectes.');
}

$conn->close();
?>
