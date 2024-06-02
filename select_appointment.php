
<?php
require_once 'db.php';

$action = $_GET['action'] ?? $_POST['action'] ?? '';

if ($action == 'list') {
    $agentId = $_GET['agentId'];
    
    // Récupérer les disponibilités de l'agent
    $sql = "SELECT * FROM agent WHERE ID = $agentId";
    $result = $conn->query($sql);
    $agent = $result->fetch_assoc();
    
    // Définir les créneaux horaires indisponibles
    $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];
    $dispo = [];
    
    foreach ($jours as $jour) {
        $dispo[$jour . '_AM'] = $agent[$jour . '_AM'];
        $dispo[$jour . '_PM'] = $agent[$jour . '_PM'];
    }

    $sql = "SELECT * FROM creneauxhoraires WHERE AgentID = $agentId";
    $result = $conn->query($sql);
    $slots = [];

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $jour = $row['Jour'];
            $heure = $row['Heure'];
            $period = (strtotime($heure) < strtotime('13:00:00')) ? 'AM' : 'PM';
            
            if (!$dispo[$jour . '_' . $period]) {
                $row['Disponible'] = 'indisponible';
            }
            
            $slots[$jour][] = $row;
        }
    }

    echo json_encode($slots);
}

if ($action == 'take') {
    $creneauId = $_POST['creneauId'];
    $agentId = $_POST['agentId'];
    $clientId = $_POST['clientId'];
    $date_rendezvous = $_POST['date_rendezvous'];
    $heure_rendezvous = $_POST['heure_rendezvous'];
    $proprieteid = $_POST['proprieteid'];

    $sql = "INSERT INTO rendezvous (ProprieteID, AgentID, ClientID, Statut, heure_rendezvous, date_rendezvous)
            VALUES ($proprieteid, $agentId, $clientId, 'Confirmé', '$heure_rendezvous', '$date_rendezvous')";
    
    if ($conn->query($sql) === TRUE) {
        $sql = "UPDATE creneauxhoraires SET Disponible = 0 WHERE ID = $creneauId";
        if ($conn->query($sql) === TRUE) {
            echo "Rendez-vous pris avec succès";
        } else {
            echo "Erreur lors de la mise à jour du créneau horaire: " . $conn->error;
        }
    } else {
        echo "Erreur lors de la prise du rendez-vous: " . $conn->error;
    }
}

$conn->close();
?>
