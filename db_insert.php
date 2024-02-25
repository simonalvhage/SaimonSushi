<?php
include "db_config.php";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kontrollera anslutningen
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Hämta bordnummer och beställningar från POST-data
$data = json_decode(file_get_contents("php://input"), true);
$tableNumber = $data["tableNumber"];
$dishes = $data["dishes"];

// Skapa en ny order och hämta det genererade order_id
$sql = "INSERT INTO orders (table_id) VALUES ('$tableNumber')";
if ($conn->query($sql) === true) {
    $orderId = $conn->insert_id;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Loopa igenom varje beställning och sätt in den i order_items-tabellen
foreach ($dishes as $dish) {
    $dishId = $dish["id"];
    $quantity = $dish["quantity"];

    // Hämta dishname och price från menutabellen
    $menuSql = "SELECT heading, price FROM menu WHERE id='$dishId'";
    $result = $conn->query($menuSql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $dishName = $row["heading"];
            $price = $row["price"];

            // Sätt in data i order_items-tabellen
            $orderItemSql = "INSERT INTO order_items (order_id, dish_name, quantity, price) VALUES ('$orderId', '$dishName', '$quantity', '$price')";
            if ($conn->query($orderItemSql) !== true) {
                echo "Error: " . $orderItemSql . "<br>" . $conn->error;
            }
        }
    } else {
        echo "0 results";
    }
}

// Stäng anslutningen
$conn->close();
?>
        