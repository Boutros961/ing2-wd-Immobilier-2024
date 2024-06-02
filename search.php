<?php
include 'db.php';

$agentName = $_POST['agentName'];
$propertyNumber = $_POST['propertyNumber'];
$cityName = $_POST['cityName'];

$sql = "SELECT * FROM Propriete WHERE 1=1";

if (!empty($agentName)) {
    $sql .= " AND AgentID IN (SELECT ID FROM Agent WHERE UtilisateurID IN (SELECT ID FROM Utilisateur WHERE Nom LIKE '%$agentName%' OR Prenom LIKE '%$agentName%'))";
}

if (!empty($propertyNumber)) {
    $sql .= " AND ID = '$propertyNumber'";
}

if (!empty($cityName)) {
    $sql .= " AND Adresse LIKE '%$cityName%'";
}

$result = $conn->query($sql);

$searchResults = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $searchResults[] = $row;
    }
}

echo json_encode($searchResults);

$conn->close();
?>
