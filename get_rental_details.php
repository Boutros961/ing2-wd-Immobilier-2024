<?php
include 'db.php';

$clientId = $_GET['id'];
$proprieteId = $_GET['proprieteid'];

// Récupération des détails du client
$clientSql = "SELECT * FROM utilisateur WHERE ID = ?";
$stmt = $conn->prepare($clienttSql);
$stmt->bind_param('i', $clientId);
$stmt->execute();
$result = $stmt->get_result();
$client = $result->fetch_assoc();

if (!$client) {
    die(json_encode(['error' => 'Client non trouvé']));
}

// Récupération des détails de la propriété
$propertySql = "SELECT * FROM propriete WHERE ID = ?";
$stmt = $conn->prepare($propertySql);
$stmt->bind_param('i', $proprieteId);
$stmt->execute();
$result = $stmt->get_result();
$propriete = $result->fetch_assoc();

if (!$propriete) {
    die(json_encode(['error' => 'Propriété non trouvée']));
}

// Calcul des frais d'agence
$fraisAgence = $propriete['Prix'];

// Préparation des données de réponse
$response = [
    'client' => [
        'nom' => $client['Nom'],
        'prenom' => $client['Prenom'],
        'adresse' => $client['Adresse'],
        'ville' => $client['Ville'],
        'code_postal' => $client['CodePostal'],
        'pays' => $client['Pays'],
        'telephone' => $client['NumeroDeTelephone']
    ],
    'propriete' => [
        'id' => $propriete['ID'],
        'prix' => $propriete['Prix'],
        'fraisAgence' => $fraisAgence,
    ]
];

echo json_encode($response);

$conn->close();
?>
