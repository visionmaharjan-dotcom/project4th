<?php
// include('header.php');

include("../admin_and_user/connection.php");
session_start();
if(!isset($_SESSION['username'])){
    header("Location:../admin_and_user/signin_up.php");
    exit();
}

$user_id = $_SESSION['customer_id'];

if ($conn->connect_error) {
    echo "<script>alert('Error connecting to database: " . $conn->connect_error . "')</script>";
    exit();
}

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
    WHERE CI.cart_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $cart_id);

if (!$stmt->execute()) {
    echo "<script>alert('Error executing query: " . $stmt->error . "')</script>";
    exit();
}

$result = $stmt->get_result();

// Get user details
$query_user = "SELECT username, email, contact FROM users WHERE userid = ?";
$stmt_user = $conn->prepare($query_user);
$stmt_user->bind_param('i', $user_id);

if (!$stmt_user->execute()) {
    echo "<script>alert('Error executing query: " . $stmt_user->error . "')</script>";
    exit();
}

$user_result = $stmt_user->get_result();
$user = $user_result->fetch_assoc();

?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css"
    integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css"
    integrity="sha512-PgQMlq+nqFLV4ylk1gwUOgm6CtIIXkKwaIHp/PAIWHzig/lKZSEGKEysh0TCVbHJXCLN7WetD8TFecIky75ZfQ=="
    crossorigin="anonymous" />
<link rel="stylesheet" type="text/css" href="../css/checkout.css">

<div class="contact__section mt-5">
    <h1 class="text-center">Checkout Page</h1>
    <p class="text-center mb-4" style="font-size: 13px">Shipping charges and delivery slots are confirmed at checkout.</p>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-11 mx-auto">
                <!-- Orders and Summary Headers -->
                <div class="row g-5">
                    <!-- Embed fetched data into HTML -->
                    <div class="col-lg-8">
                        <h4 class="product_name mb-3">
                            <i class="fa-regular fa-circle-user"></i>
                            <?php echo htmlspecialchars($user['username']); ?>
                        </h4>
                        <div class="main_cart p-2 mb-lg-0 mb-5 border rounded">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div><strong>USERNAME</strong></div>
                                            <div><?php echo htmlspecialchars($user['username']); ?></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div><strong>EMAIL</strong></div>
                                            <div><?php echo htmlspecialchars($user['email']); ?></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div><strong>Mobile Phone</strong></div>
                                            <div><?php echo htmlspecialchars($user['contact']); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="product_name">Order Summary</h4>
                        <div class="main_cart p-3 mb-lg-0 mb-5 border rounded">
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
                                <div class="card p-4 mb-3" id="product-<?php echo $product_id; ?>">
                                    <div class="row">
                                        <div class="col-md-4 col-11 mx-auto bg-light d-flex justify-content-center align-items-center rounded product_img">
                                            <img src="<?php echo $product_image; ?>" class="img-fluid" alt="cart img">
                                        </div>
                                        <div class="col-md-8 col-11 mx-auto pl-4 pr-0 mt-2">
                                            <div class="row">
                                                <div class="col-8 card-title">
                                                    <div class="mb-0 product_name">
                                                        <?php echo $product_name; ?>
                                                    </div>
                                                    <p class="mb-1">Description: <?php echo $description; ?></p>
                                                </div>
                                                <div class="col-4 d-flex justify-content-end">
                                                    <div class="set_quantity d-flex justify-content-center">
                                                        <input type="number" class="page-link count" value="<?php echo $product_quantity; ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 d-flex justify-content-between align-items-center">
                                                    <div class="price_money">
                                                        <h4>NRs<span><?php echo $item_total_price; ?></span></h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <hr />
                            <div class="text-right">
                                <h4>Total: NRs<span><?php echo $total_price; ?></span></h4>
                            </div>
                            <form action="confirmation.php" method="POST">
                                <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
                                <input type="hidden" name="item_name" value="Order">
                                <input type="hidden" name="item_number" value=".">
                                <input type="hidden" name="quantity" value=".">
                                <button type="submit" class="button">Place Order</button>
                            </form>
                        </div>
                    </div>

                    <!-- Summary section -->
                    <div class="col-lg-4">
                        <h4 class="product_name">Summary</h4>
                        <div class="right_side p-3 bg-white border rounded">
                            <div class="price_indiv d-flex justify-content-between">
                                <p>Items in the cart</p>
                                <p>NRs<span id="product_total_amt"><?php echo $total_price; ?></span></p>
                            </div>
                            <div class="price_indiv d-flex justify-content-between">
                                <p>Shipping Charge</p>
                                <p><span id="shipping_charge">Free Delivery</span></p>
                            </div>
                            <div class="price_indiv d-flex justify-content-between">
                                <p>Discount</p>
                                <p><span id="savings">10%</span></p>
                            </div>
                            <hr />
                            <div class="total-amt d-flex justify-content-between font-weight-bold">
                                <p>Total</p>
                                <p>Nrs<span id="total_cart_amt">
                                        <?php
                                        $shipping_charge = 0; // Example shipping charge, you can adjust this based on your logic
                                        $discount_percentage = 0.10; // 10% discount
                                        $discount = $total_price * $discount_percentage; // Calculate the discount amount
                                        $final_amount = $total_price + $shipping_charge - $discount;
                                        echo number_format($final_amount, 2); // Format the final amount to 2 decimal places
                                        ?>
                                    </span></p>
                            </div>
                            <?php
                            $sql = "INSERT INTO cart (user_id, total_price) VALUES (?, ?)";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param('id', $user_id, $final_amount);

                            if (!$stmt->execute()) {
                                echo "<script>alert('Error inserting data: " . $stmt->error . "')</script>";
                            } else {
                                $cart_id = $stmt->insert_id;
                                $_SESSION['cart_id'] = $cart_id;
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <!-- end of main row -->
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
    integrity="sha512-ZvpUoO8CsapONso6LDeXg7inXOW/3A4/D9Xw/WF2pQwF/5FxHuvLSyZReCfRANefZQCxqjZREl8r9YbyY19i9A=="
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"
    integrity="sha384-pzjw8f+ua7Kw1TIqG6yfF3UI60b9AUSczov1BILqII5TE2swmNz5tovb5GldwBzT"
    crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"
    integrity="sha384-pzjw8f+ua7Kw1TIqG6yfF3UI60b9AUSczov1BILqII5TE2swmNz5tovb5GldwBzT"
    crossorigin="anonymous"></script>
<script src="checkout.js"></script>
</body>
</html>
