<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" integrity="sha512-PgQMlq+nqFLV4ylk1gwUOgm6CtIIXkKwaIHp/PAIWHzig/lKZSEGKEysh0TCVbHJXCLN7WetD8TFecIky75ZfQ==" crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css" href="../css/cart.css">
</head>
<body style="background-image: url('../images/bg2.jpg'); background-repeat: no-repeat; background-size: cover;">
<?php
include('../admin_and_user/connection.php');

if ($conn->connect_error) {
    echo "<script>alert('Error connecting to database: " . $conn->connect_error . "')</script>";
    exit();
}

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../admin_and_user/signin_up.php");
    exit();
}

$user_id = $_SESSION['customer_id'];

// Get the user's cart ID
$query = "SELECT cart_id FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);

if (!$stmt->execute()) {
    echo "<script>alert('Error executing query: " . $stmt->error . "')</script>";
    exit();
}

$result = $stmt->get_result();
$row = $result->fetch_assoc();
if (!$row) {
    echo "<script>alert('No cart found for user.')</script>";
    exit();
}

$cart_id = $row['cart_id'];

// Get the products in the user's cart
$query = "
    SELECT CI.product_id, P.name, P.price, P.description, P.image, CI.product_quantity
    FROM cart_item CI 
    JOIN product P ON CI.product_id = P.id
    WHERE CI.cart_id= ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $cart_id);

if (!$stmt->execute()) {
    echo "<script>alert('Error executing query: " . $stmt->error . "')</script>";
    exit();
}

$result = $stmt->get_result();
?>

<div class="cart-section mt-5">
    <h1 class="text-center">Cart Page</h1>
    <p class="text-center mb-4">Shipping charges and delivery slots are confirmed at checkout.</p>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-11 mx-auto">
                <div class="row">
                    <div class="col-lg-8">
                        <h4 class="mb-3">Your Cart</h4>
                        <div class="main-cart p-3 mb-lg-0 mb-5 border rounded">
                            <?php
                            $total_price = 0;
                            while ($row = $result->fetch_assoc()) {
                                $product_id = $row['product_id'];
                                $product_name = $row['name'];
                                $product_price = $row['price'];
                                $product_image = $row['image'];
                                $description = $row['description'];
                                $product_quantity = $row['product_quantity'];
                                $item_total_price = $product_price * $product_quantity;
                                $total_price += $item_total_price;
                            ?>
                                <div class="card p-4 mb-3 cart-item" id="product-<?php echo $product_id; ?>">
                                    <div class="row">
                                        <div class="col-md-4 col-11 mx-auto d-flex justify-content-center align-items-center product-img">
                                            <img src="<?php echo $product_image; ?>" class="img-fluid" alt="cart img">
                                        </div>
                                        <div class="col-md-8 col-11 mx-auto">
                                            <div class="row">
                                                <div class="col-8">
                                                    <h5><?php echo $product_name; ?></h5>
                                                
                                                    <h5><span id="itemval<?php echo $product_id; ?>"><?php echo number_format($item_total_price, 2); ?></span></h5>
                                                </div>
                                                <div class="col-4 d-flex justify-content-end">
                                                <ul class="pagination justify-content-end set_quantity" style="font-size: 0.875rem; padding: 0; margin: 0;">
                                                <li class="page-item" style="margin: 0 0.1rem;">
                                                    <button class="page-link" style="padding: 0.25rem 0.5rem; border-radius: 0.2rem;" onclick="decreaseNumber('textbox<?php echo $product_id; ?>', 'itemval<?php echo $product_id; ?>', <?php echo $product_price; ?>)">
                                                        <i class="fas fa-minus" style="font-size: 0.875rem;"></i>
                                                    </button>
                                                </li>
                                                <li class="page-item" style="margin: 0 0.1rem;">
                                                    <input type="number" class="page-link" value="<?php echo $product_quantity; ?>" id="textbox<?php echo $product_id; ?>" readonly style="padding: 0.25rem 0.5rem; text-align: center; width: 3rem; border-radius: 0.2rem;">
                                                </li>
                                                <li class="page-item" style="margin: 0 0.1rem;">
                                                    <button class="page-link" style="padding: 0.25rem 0.5rem; border-radius: 0.2rem;" onclick="increaseNumber('textbox<?php echo $product_id; ?>', 'itemval<?php echo $product_id; ?>', <?php echo $product_price; ?>)">
                                                        <i class="fas fa-plus" style="font-size: 0.875rem;"></i>
                                                    </button>
                                                </li>
                                            </ul>

                                                </div>
                                            </div>
                                            <div class="float-right">
                                                <button onclick="deleteCartItem(<?php echo $product_id; ?>)"><i class="fas fa-trash-alt"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="d-flex justify-content-between">
                                <h5>Total Price:</h5>
                                <h5 id="total_price"><?php echo number_format($total_price, 2); ?></h5>
                            </div>
                     
                   
                    
                            <a href="checkout.php" class="btn btn-primary btn-block">Proceed to Checkout</a> </div>    </div>

                            <a href="product_page.php" class="btn btn-primary btn-block">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function updateTotalPrice() {
    var total = 0;
    var itemTotals = document.querySelectorAll('.cart-item h5 span');
    itemTotals.forEach(function(itemTotal) {
        total += parseFloat(itemTotal.textContent);
    });
    document.getElementById('total_price').textContent = total.toFixed(2);
}

function increaseNumber(textboxId, itemvalId, productPrice) {
    var textbox = document.getElementById(textboxId);
    var itemval = document.getElementById(itemvalId);
    var currentValue = parseInt(textbox.value);
    if (currentValue < 10) {
        var newQuantity = currentValue + 1;
        textbox.value = newQuantity;
        itemval.textContent = (newQuantity * productPrice).toFixed(2);
        updateTotalPrice();
        updateCartItemQuantity(textboxId.replace('textbox', ''), newQuantity);
    }
}

function decreaseNumber(textboxId, itemvalId, productPrice) {
    var textbox = document.getElementById(textboxId);
    var itemval = document.getElementById(itemvalId);
    var currentValue = parseInt(textbox.value);
    if (currentValue > 1) {
        var newQuantity = currentValue - 1;
        textbox.value = newQuantity;
        itemval.textContent = (newQuantity * productPrice).toFixed(2);
        updateTotalPrice();
        updateCartItemQuantity(textboxId.replace('textbox', ''), newQuantity);
    }
}

function updateCartItemQuantity(productId, quantity) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "update_cart.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            console.log(xhr.responseText);
            updateTotalPrice();
        }
    };
    xhr.send("product_id=" + productId + "&quantity=" + quantity);
}

function deleteCartItem(productId) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "delete_cart_item.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var productElement = document.getElementById("product-" + productId);
            productElement.parentNode.removeChild(productElement);
            updateTotalPrice();
        }
    };
    xhr.send("product_id=" + productId);
}

</script>