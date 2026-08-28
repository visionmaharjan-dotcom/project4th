<?php

include('header.php');

if (isset($_POST['add_to_cart'])) {
  
    if ($conn->connect_error) {
        echo "<script>alert('Error connecting to database: " . $conn->connect_error . "')</script>";
        exit();
    }

    if (!isset($_SESSION['username'])) {
        header("Location:../user/sign_in_up.php");
        exit();
    } else {
        $user_id = $_SESSION['customer_id'];
        echo "User ID: $user_id<br>";

        $product_id = $_POST['product_id'];
        echo "Product ID: $product_id<br>";
        $product_name = $_POST['product_name'];
        echo "Product Name: $product_name<br>";
        $product_price = $_POST['product_price'];
        echo "Product Price: $product_price<br>";
        $product_image = $_POST['product_image'];
        echo "Product Image: $product_image<br>";
        $quantity = 1; 


        $query = "SELECT cart_id FROM cart WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $user_id);

        echo "Executing query to get cart ID...<br>";

        if (!$stmt->execute()) {
            echo "<script>alert('Error executing query: " . $stmt->error . "')</script>";
            exit();
        }

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if (!$row) {
            echo "Cart not found for user. Creating a new cart...<br>";
            // Create a new cart for the user
            $query_new_cart = "INSERT INTO cart (user_id) VALUES (?)";
            $stmt_new_cart = $conn->prepare($query_new_cart);
            $stmt_new_cart->bind_param('i', $user_id);

            if (!$stmt_new_cart->execute()) {
                echo "<script>alert('Error creating new cart: " . $stmt_new_cart->error . "')</script>";
                exit();
            }
            $cart_id = $stmt_new_cart->insert_id;
            echo "New Cart ID: $cart_id<br>";
        } else {
            $cart_id = $row['cart_id'];
            echo "Cart ID: $cart_id<br>";
        }

        // Check if the product is already in the cart
        $query1 = "SELECT product_id FROM cart_item WHERE cart_id = ? AND product_id = ?";
        $stmt1 = $conn->prepare($query1);
        $stmt1->bind_param('ii', $cart_id, $product_id);

        echo "Executing query to check if product is already in the cart...<br>";

        if (!$stmt1->execute()) {
            echo "<script>alert('Error executing query: " . $stmt1->error . "')</script>";
            exit();
        }

        $result1 = $stmt1->get_result();
        if ($result1->fetch_assoc()) {
            echo "<script>alert('Product already in Cart!')</script>";
        } else {
            // Insert the new item into the cart
            $query2 = "INSERT INTO cart_item (cart_id, product_id, product_quantity) VALUES (?, ?, ?)";
            $stmt2 = $conn->prepare($query2);
            $stmt2->bind_param('iii', $cart_id, $product_id, $quantity);

            if ($stmt2->execute()) {
                $_SESSION['cart_product_added'] = true;
                header("Location: cart.php?product_id=$product_id");
                exit();
            } else {
                echo "<script>alert('Failed to add product to cart: " . $stmt2->error . "')</script>";
            }
        }
    }
    $conn->close();
}

?>
