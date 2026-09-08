<?php
include('../admin_and_user/connection.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
if (!isset($_SESSION['username'])) {
    die("Not logged in");
}

$user_id = $_SESSION['customer_id'];
$product_id = $_POST['product_id'];

// Get the user's cart ID
$query = "SELECT cart_id FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
if (!$row) {
    error_log("Cart ID not found for user ID: $user_id");
    die("Cart ID not found");
}
$cart_id = $row['cart_id'];

// Delete the cart item
$query = "DELETE FROM cart_item WHERE cart_id = ? AND product_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ii', $cart_id, $product_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Cart item deleted successfully";
} else {
    echo "Failed to delete cart item";
}

$stmt->close();
$conn->close();
?>
