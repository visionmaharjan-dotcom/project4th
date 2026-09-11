<?php
include("../admin_and_user/connection.php");
session_start();
if(!isset($_SESSION['username'])){
    header("Location:../admin_and_user/signin_up.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgroMart</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link rel="stylesheet" href="../css/Style.css">

    <style>
      
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

       
    </style>
</head>
<body>


<header>

    <a href="#" class="logo"><i class="fas fa-seedling"></i>AgroMart</a>

    <nav class="navbar">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="service.php">Service</a></li>
            <li><a href="product_page.php">Product</a></li>
            <li class="dropdown">
                <a href="#" class="dropbtn"><i class="fa fa-user"></i><?php echo $_SESSION['username']; ?></a>
                <div class="dropdown-content">
                    <a href="cart.php"><i class="fa fa-shopping-cart"></i>Cart</a>
                    <a href="account.php"><i class="fa fa-user"></i>Account</a>
                    <a href="../admin_and_user/logout.php"><i class="fa fa-sign-out-alt"></i>Logout</a>
                </div>
            </li>
        </ul>
    </nav>
</header>


</body>
</html>
