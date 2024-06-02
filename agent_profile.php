<?php
include 'db.php';

$agentId = $_GET['id'];

$sql = "SELECT u.Nom, u.Prenom, u.Email, a.Specialite, a.CV, u.NumeroDeTelephone as Telephone, a.Photo, 
        a.Lundi_AM, a.Lundi_PM, a.Mardi_AM, a.Mardi_PM, a.Mercredi_AM, a.Mercredi_PM, a.Jeudi_AM, a.Jeudi_PM, a.Vendredi_AM, a.Vendredi_PM, a.Samedi_AM, a.Samedi_PM 
        FROM Agent a
        JOIN Utilisateur u ON a.UtilisateurID = u.ID
        WHERE a.ID = $agentId";

$result = $conn->query($sql);

$agent = null;

if ($result->num_rows > 0) {
    $agent = $result->fetch_assoc();


    $agent['Lundi_AM'] = (bool)$agent['Lundi_AM'];
    $agent['Lundi_PM'] = (bool)$agent['Lundi_PM'];
    $agent['Mardi_AM'] = (bool)$agent['Mardi_AM'];
    $agent['Mardi_PM'] = (bool)$agent['Mardi_PM'];
    $agent['Mercredi_AM'] = (bool)$agent['Mercredi_AM'];
    $agent['Mercredi_PM'] = (bool)$agent['Mercredi_PM'];
    $agent['Jeudi_AM'] = (bool)$agent['Jeudi_AM'];
    $agent['Jeudi_PM'] = (bool)$agent['Jeudi_PM'];
    $agent['Vendredi_AM'] = (bool)$agent['Vendredi_AM'];
    $agent['Vendredi_PM'] = (bool)$agent['Vendredi_PM'];
    $agent['Samedi_AM'] = (bool)$agent['Samedi_AM'];
    $agent['Samedi_PM'] = (bool)$agent['Samedi_PM'];
}

echo json_encode($agent);

$conn->close();
?>
