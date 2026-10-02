```php
<?php

include("../admin/connection.php");
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['customer_id'])) {
    header("Location: ../admin/signin_up.php");
    exit();
}

$user_id = $_SESSION['customer_id'];

if (!isset($_POST['total_price'])) {
    die("Total price is missing.");
}

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

/* Get products from cart */
$sql = "
    SELECT CI.product_id, CI.product_quantity, P.price
    FROM cart_item CI
    JOIN product P ON CI.product_id = P.id
    WHERE CI.cart_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cart_id);
$stmt->execute();

$result = $stmt->get_result();

/* Add products to order_item */
while ($item = $result->fetch_assoc()) {

    $sql_item = "
        INSERT INTO order_item
        (order_id, product_id, product_quantity, price)
        VALUES (?, ?, ?, ?)
    ";

    $stmt_item = $conn->prepare($sql_item);

    $stmt_item->bind_param(
        "iiid",
        $order_id,
        $item['product_id'],
        $item['product_quantity'],
        $item['price']
    );

    $stmt_item->execute();
}

/* Remove items from cart */
$sql = "DELETE FROM cart_item WHERE cart_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cart_id);
$stmt->execute();

/* Order placed successfully */
echo "
<script>
    alert('Your order has been placed successfully!');
    window.location.href = 'index.php';
</script>
";

?>
```
