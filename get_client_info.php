<?php
include 'db.php';

// Récupérer l'ID du client depuis l'URL
$clientId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($clientId > 0) {
    // Récupérer les informations du client
    $sqlClientInfo = "SELECT * FROM utilisateur WHERE ID = ?";
    $stmtClientInfo = $conn->prepare($sqlClientInfo);
    $stmtClientInfo->bind_param("i", $clientId);
    $stmtClientInfo->execute();
    $resultClientInfo = $stmtClientInfo->get_result();

    if ($resultClientInfo->num_rows > 0) {
        $clientInfo = $resultClientInfo->fetch_assoc();
    } else {
        echo json_encode(['error' => 'Client not found']);
        exit();
    }

    // Récupérer l'historique des achats
    $sqlAchats = "SELECT * FROM achat WHERE ClientID = ?";
    $stmtAchats = $conn->prepare($sqlAchats);
    $stmtAchats->bind_param("i", $clientId);
    $stmtAchats->execute();
    $resultAchats = $stmtAchats->get_result();

    // Récupérer l'historique des locations
    $sqlLocations = "SELECT * FROM location WHERE ClientID = ?";
    $stmtLocations = $conn->prepare($sqlLocations);
    $stmtLocations->bind_param("i", $clientId);
    $stmtLocations->execute();
    $resultLocations = $stmtLocations->get_result();

    // Construire la réponse
    $response = array();

    // Informations du client
    $response['info'] = "
        <p>Nom: {$clientInfo['nom']}</p>
        <p>Email: {$clientInfo['email']}</p>
    ";

    // Historique des achats
    $response['consultations'] = "<h6>Achats</h6><ul class='list-group'>";
    while ($row = $resultAchats->fetch_assoc()) {
        $response['consultations'] .= "<li class='list-group-item'>Propriété ID: {$row['ProprieteID']} - Prix: {$row['Prix']} €</li>";
    }
    $response['consultations'] .= "</ul>";

    // Historique des locations
    $response['consultations'] .= "<h6>Locations</h6><ul class='list-group'>";
    while ($row = $resultLocations->fetch_assoc()) {
        $response['consultations'] .= "<li class='list-group-item'>Propriété ID: {$row['ProprieteID']} - Prix: {$row['Prix']} € - Durée: {$row['Duree']} mois</li>";
    }
    $response['consultations'] .= "</ul>";

    echo json_encode($response);
} else {
    echo json_encode(['error' => 'Invalid client ID']);
}

// Fermer la connexion
$conn->close();
?>
    