<?php
include 'db.php';

$clientId = $_GET['id'];
$proprieteId = $_GET['proprieteid'];

// Récupérer les informations du client
$clientSql = "SELECT * FROM utilisateur WHERE ID = ?";
$stmt = $conn->prepare($clientSql);
$stmt->bind_param("i", $clientId);
$stmt->execute();
$clientResult = $stmt->get_result();
$client = $clientResult->fetch_assoc();

// Récupérer les informations de la propriété
$propertySql = "SELECT * FROM propriete WHERE ID = ?";
$stmt = $conn->prepare($propertySql);
$stmt->bind_param("i", $proprieteId);
$stmt->execute();
$propertyResult = $stmt->get_result();
$propriete = $propertyResult->fetch_assoc();

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
        'frais_agence' => ($propriete['Prix'] * 0.05),
        'total' => ($propriete['Prix'] + ($propriete['Prix'] * 0.05))
    ]
];

echo json_encode($response);

$conn->close();
?>  