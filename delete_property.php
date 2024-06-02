<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $property_id = $_POST['propertyId'];

    $sql = "DELETE FROM propriete WHERE ID = '$property_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Property deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
