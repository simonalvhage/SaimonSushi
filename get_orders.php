<?php
include "db_config.php";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT orders.order_id, tables.table_number, order_items.dishes, order_items.quantities, orders.order_time
        FROM orders 
        INNER JOIN tables ON orders.table_id = tables.table_id 
        INNER JOIN (
            SELECT order_id, GROUP_CONCAT(dish_name SEPARATOR ', ') AS dishes, GROUP_CONCAT(quantity SEPARATOR ', ') AS quantities
            FROM order_items
            GROUP BY order_id
        ) AS order_items ON orders.order_id = order_items.order_id
        ORDER BY orders.order_id ASC";



$result = $conn->query($sql);

$orders = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($orders);
?>