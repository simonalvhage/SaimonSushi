<?php
include "db_config.php";
    
// Skapa anslutning
$conn = new mysqli($servername, $username, $password, $dbname);

// Kontrollera anslutningen
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Förbered SQL-fråga för att hämta menyn
$sql = "SELECT * FROM menu";
$result = $conn->query($sql);

$menu_items = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $menu_items[] = $row;
    }
}

// Stäng anslutningen till databasen
$conn->close();

// Returnera resultatet som JSON
header('Content-Type: application/json');
echo json_encode($menu_items);
?>
