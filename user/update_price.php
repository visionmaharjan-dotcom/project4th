<?php
include('connection.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
if (!isset($_SESSION['username'])) {
    die("Not logged in");
}

$user_id = $_SESSION['customer_id'];
$total_price = $_POST['total_price'];

// Get the user's cart ID
$query = "SELECT cart_id FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$cart_id = $row['cart_id'];

// Update the cart total price (if needed, for your business logic)
$query = "UPDATE cart SET total_price = ? WHERE cart_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('di', $total_price, $cart_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Cart total price updated successfully";
} else {
    echo "Failed to update cart total price";
}

$stmt->close();
$conn->close();
?>
