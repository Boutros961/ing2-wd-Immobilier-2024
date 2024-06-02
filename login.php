<?php
session_start();
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

  
    $stmt = $conn->prepare('SELECT * FROM utilisateur WHERE Email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

   
        if  ($password === $row['MotDePasse']) {
            $_SESSION['userid'] = $row['ID'];
            $_SESSION['usertype'] = $row['Type'];
            echo json_encode(['type' => $row['Type'], 'id' => $row['ID']]);
        } else {
            echo json_encode(['error' => 'Mot de passe incorrect']);
        }
    } else {
        echo json_encode(['error' => 'Email non trouvé']);
    }

    $stmt->close();
    $conn->close();
}
?>
