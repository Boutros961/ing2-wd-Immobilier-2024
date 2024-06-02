<?php
include 'db.php';
$category = isset($_GET['category']) ? $_GET['category'] : '';
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

$sql = "SELECT * FROM propriete WHERE 1";

if (!empty($category)) {
    $sql .= " AND Type='$category'";
}

if (!empty($keyword)) {
    $sql .= " AND (Adresse LIKE '%$keyword%' OR Description LIKE '%$keyword%')";
}

$result = $conn->query($sql);

$properties = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $images = explode(';', $row['Images']);
        $row['Images'] = $images[0]; 
        $properties[] = $row;
    }
}

echo json_encode($properties);

$conn->close();
?>