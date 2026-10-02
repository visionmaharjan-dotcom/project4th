<?php
include("../admin/connection.php");
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['seller_id'])) {
    header("Location:../admin/signin_up.php");
    exit();
}

$seller_id = $_SESSION['seller_id'];

$sql_role = "SELECT role FROM users WHERE userid = ?";
$stmt_role = $conn->prepare($sql_role);
$stmt_role->bind_param("i", $seller_id);
$stmt_role->execute();

$role_result = $stmt_role->get_result();
$seller_row = $role_result->fetch_assoc();

if (!$seller_row || $seller_row['role'] != 'seller') {
    header("Location:../user/index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgroMart Seller</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link rel="stylesheet" href="../css/Style.css">
</head>
<body>


<header>

    <a href="#" class="logo"><i class="fas fa-seedling"></i>AgroMart Seller</a>

    <nav class="navbar">
        <ul>
            <li><a href="seller_dashboard.php">Dashboard</a></li>
            <li><a href="add_product.php">Add Product</a></li>
            <li><a href="manage_product.php">Manage Products</a></li>
            <li><a href="orders.php">Order Requests</a></li>
            <li><a href="../admin/logout.php"><i class="fa fa-sign-out-alt"></i>Logout</a></li>
        </ul>
    </nav>
</header>


</body>
</html>




