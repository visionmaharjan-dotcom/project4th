<?php

include("../admin_and_user/connection.php");
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['customer_id'])) {
    header("Location: ../admin_and_user/signin_up.php");
    exit();
}

$user_id = $_SESSION['customer_id'];
$total_price = $_POST['total_price'];

/* Get customer's cart */
$sql = "SELECT cart_id FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
$cart = $result->fetch_assoc();

if (!$cart) {
    die("Cart not found.");
}

$cart_id = $cart['cart_id'];

/* Create order */
$sql = "INSERT INTO orders (user_id, total_price) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("id", $user_id, $total_price);
$stmt->execute();

$order_id = $stmt->insert_id;

$sql = "
    SELECT CI.product_id, P.name, CI.product_quantity
    FROM cart_item CI
    JOIN product P ON CI.product_id = P.id
    WHERE CI.cart_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cart_id);
$stmt->execute();

$result = $stmt->get_result();

while ($item = $result->fetch_assoc()) {

    $sql_item = "
        INSERT INTO order_item
        (order_id, product_id, product_name, quantity)
        VALUES (?, ?, ?, ?)
    ";

    $stmt_item = $conn->prepare($sql_item);

    $stmt_item->bind_param(
        "iisi",
        $order_id,
        $item['product_id'],
        $item['name'],
        $item['product_quantity']
    );

    $stmt_item->execute();
}

/* Remove items from cart */
$sql = "DELETE FROM cart_item WHERE cart_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cart_id);
$stmt->execute();

echo "
<script>
    alert('Your order has been placed successfully!');
    window.location.href = 'index.php';
</script>
";

?>



