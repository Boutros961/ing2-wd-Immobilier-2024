<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adresse = $_POST['adresse'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $agentid = $_POST['agentId'];
    $images = $_POST['images'];
echo "agentid".$agentid;
    $sql = "INSERT INTO propriete (Adresse, Type, Description, Prix, AgentID, Images) 
            VALUES ('$adresse', '$type', '$description', '$prix', '$agentid', '$images')";

    if ($conn->query($sql) === TRUE) {
        echo "New property added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
