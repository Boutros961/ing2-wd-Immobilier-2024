<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['id'];

    $sql = "SELECT * FROM utilisateur WHERE ID = '$id' AND Type = 'Agent'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        $info = "
            <p>Nom: {$user['Nom']}</p>
            <p>Prénom: {$user['Prenom']}</p>
            <p>Email: {$user['Email']}</p>
            <p>Adresse: {$user['Adresse']}</p>
        ";

        $sqlConsultations = "SELECT * FROM rendezvous WHERE AgentID = '$id'";
        $resultConsultations = $conn->query($sqlConsultations);
        $consultations = "";

        if ($resultConsultations->num_rows > 0) {
            while ($row = $resultConsultations->fetch_assoc()) {
                $consultations .= "<li class='list-group-item'>Consultation avec le client ID {$row['ClientID']} - {$row['date_rendezvous']} - {$row['Statut']}</li>";
            }
        } else {
            $consultations .= "<li class='list-group-item'>Aucune consultation trouvée</li>";
        }

        echo json_encode(['info' => $info, 'consultations' => $consultations]);
    } else {
        echo json_encode(['error' => 'Agent non trouvé']);
    }

    $conn->close();
}
?>
