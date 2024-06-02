<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $agent_id = $_POST['agentId'];

    $sql = "DELETE FROM agent WHERE ID = '$agent_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Agent ".$agent_id." deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
