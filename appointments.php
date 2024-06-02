<?php
require_once 'db.php';

$action = $_GET['action'] ?? $_POST['action'] ?? '';

if ($action == 'list') {
    $sql = "SELECT ID, ProprieteID, AgentID, ClientID, Statut, heure_rendezvous, date_rendezvous
            FROM rendezvous
            WHERE Statut = 'Confirmé'";
    $result = $conn->query($sql);
    $appointments = [];

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $appointments[] = $row;
        }
    }

    echo json_encode($appointments);
}

if ($action == 'cancel') {
    $appointmentId = $_POST['appointmentId'];
    
    // Récupérer les informations du rendez-vous pour libérer le créneau horaire correspondant
    $sql = "SELECT AgentID, date_rendezvous, heure_rendezvous FROM rendezvous WHERE ID = $appointmentId";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $appointment = $result->fetch_assoc();
        $agentId = $appointment['AgentID'];
        $jour = $appointment['date_rendezvous'];
        $heure = $appointment['heure_rendezvous'];
        
        // Annuler le rendez-vous
        $sql = "UPDATE rendezvous SET Statut = 'Annulé' WHERE ID = $appointmentId";
        if ($conn->query($sql) === TRUE) {
            // Rendre le créneau horaire disponible
            $sql = "UPDATE creneauxhoraires SET Disponible = 1 WHERE AgentID = $agentId AND Jour = '$jour' AND Heure = '$heure'";
            if ($conn->query($sql) === TRUE) {
                echo "Rendez-vous annulé avec succès et créneau horaire rendu disponible";
            } else {
                echo "Erreur lors de la mise à jour du créneau horaire: " . $conn->error;
            }
        } else {
            echo "Erreur lors de l'annulation du rendez-vous: " . $conn->error;
        }
    } else {
        echo "Rendez-vous non trouvé";
    }
}

$conn->close();
?>
