<?php
require_once 'db.php';

if (isset($_GET['agentId'])) {
    $agentId = intval($_GET['agentId']);
    $sql = "SELECT CV FROM agent WHERE ID = $agentId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $cv = $row['CV'];
    } else {
        $cv = "CV non trouvé.";
    }
} else {
    $cv = "Aucun identifiant d'agent fourni.";
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV de l'agent</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h1>CV de l'agent</h1>
        <pre><?php echo htmlspecialchars($cv); ?></pre>
        <a href="agent_profile.html?id=<?php echo $agentId; ?>" class="btn btn-primary">Retour au profil</a>
    </div>
</body>
</html>
