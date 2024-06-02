<?php
include 'db.php';

$category = $_GET['category'];
$keyword = $_GET['keyword'];

$sql = "SELECT * FROM Propriete WHERE 1=1";

if (!empty($category)) {
    $sql .= " AND Type='$category'";
}

if (!empty($keyword)) {
    $sql .= " AND (Adresse LIKE '%$keyword%' OR Description LIKE '%$keyword%')";
}

$result = $conn->query($sql);

$properties = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $properties[] = $row;
    }
}

echo json_encode($properties);

$conn->close();
?>
