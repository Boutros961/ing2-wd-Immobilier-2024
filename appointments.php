<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $agentId = $_GET['agentId'];
    $creneaux = [];

    // Récupérer les créneaux horaires de l'agent
    $sql = "SELECT ID, Jour, Heure, Disponible FROM CreneauxHoraires WHERE AgentID = $agentId ORDER BY FIELD(Jour, 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'), Heure";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $creneaux[$row['Jour']][] = [
                'id' => $row['ID'],
                'heure' => $row['Heure'],
                'disponible' => (bool)$row['Disponible']
            ];
        }
    }

    // Structurer les créneaux pour le front-end
    $schedule = [];
    $heures = [
        '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00',
        '15:00', '16:00', '17:00', '18:00'
    ];

    foreach ($heures as $heure) {
        $row = ['heure' => $heure, 'creneaux' => []];
        foreach (['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'] as $jour) {
            $creneau = array_filter($creneaux[$jour] ?? [], function ($c) use ($heure) {
                return $c['heure'] === $heure;
            });
            $row['creneaux'][] = reset($creneau) ?: ['disponible' => false];
        }
        $schedule[] = $row;
    }

    echo json_encode($schedule);
    $conn->close();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $creneauId = $_POST['creneauId'];
    $agentId = $_POST['agentId'];
    $clientId = $_POST['clientId'];

    // Mettre à jour le créneau comme pris
    $sql = "UPDATE CreneauxHoraires SET Disponible = 0 WHERE ID = $creneauId";
    if ($conn->query($sql) === TRUE) {
        // Insérer le rendez-vous dans la table RendezVous
        $sql = "INSERT INTO RendezVous (ProprieteID, AgentID, ClientID, DateHeure, Statut) VALUES (1, $agentId, $clientId, NOW(), 'Confirmé')";
        if ($conn->query($sql) === TRUE) {
            echo "Rendez-vous pris avec succès.";
        } else {
            echo "Erreur lors de la prise du rendez-vous: " . $conn->error;
        }
    } else {
        echo "Erreur lors de la mise à jour du créneau: " . $conn->error;
    }

    $conn->close();
    exit;
}
?>
