<?php
include "db_config.php";

// Skapa anslutning
$conn = new mysqli($servername, $username, $password, $dbname);

// Kontrollera anslutningen
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kontrollera om order_id har skickats via URL-parametrar
if(isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Förbered SQL-fråga för att ta bort beställningsdetaljer från order_items-tabellen
    $sql_delete_order_items = "DELETE FROM order_items WHERE order_id = $order_id";
    echo "SQL-fråga för att ta bort beställningsdetaljer: $sql_delete_order_items <br>";

    // Kör SQL-frågan för att ta bort beställningsdetaljer
    if ($conn->query($sql_delete_order_items) === TRUE) {
        echo "Beställningsdetaljer borttagna från order_items-tabellen <br>";

        // Förbered SQL-fråga för att ta bort beställningen från orders-tabellen
        $sql_delete_order = "DELETE FROM orders WHERE order_id = $order_id";
        echo "SQL-fråga för att ta bort beställning: $sql_delete_order <br>";

        // Kör SQL-frågan för att ta bort beställningen
        if ($conn->query($sql_delete_order) === TRUE) {
            echo "Beställning borttagen från orders-tabellen <br>";
            // Skicka ett lyckat svar till klienten
            http_response_code(200); // OK
        } else {
            echo "Fel: " . $conn->error . "<br>";
            // Skicka ett felmeddelande till klienten
            http_response_code(500); // Internal Server Error
        }
    } else {
        echo "Fel: " . $conn->error . "<br>";
        // Skicka ett felmeddelande till klienten
        http_response_code(500); // Internal Server Error
    }
} else {
    // Skicka ett felmeddelande om order_id inte har skickats via URL-parametrar
    echo "Fel: order_id saknas i URL-parametrar <br>";
    http_response_code(400); // Bad Request
}

// Stäng anslutningen till databasen
$conn->close();
?>
