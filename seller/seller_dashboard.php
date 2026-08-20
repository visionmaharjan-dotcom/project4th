<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/seller.css"></head>
<body>

<title>Seller Dashboard</title>
<style>
    body {
        background-image: url("../images/bg2.jpg");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }

    .main__content {
        padding-top: 100px;
    }
</style>

<?php include 'seller_header.php'; ?>

<br><br><br><br>
<br><br><br><br>
<div class="main__content">
    <div class="container text-center">
        <h2 class="mb-4">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
        <a href="add_product.php" class="btn btn-success btn-lg m-2">Add Product</a>
        <a href="manage_product.php" class="btn btn-secondary btn-lg m-2">Manage Products</a>
        <a href="orders.php" class="btn btn-primary btn-lg m-2">Order Requests</a>
    </div>
</div>

</body>
</html>


