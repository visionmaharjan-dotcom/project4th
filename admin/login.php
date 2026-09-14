<?php
session_start();
include("connection.php");
if(isset($_POST["login"]))
{
    $username = $_POST["username"];
    $password = $_POST["password"];
    $role = $_POST["role"];


$sql = "SELECT * FROM users WHERE username  = '$username' AND password ='$password' AND role = '$role'";
$qry = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$row = mysqli_fetch_assoc($qry);

if ($row) {
                
    if ($role == 'Customer') 
    {
        $_SESSION["username"] = $username;
        $_SESSION["customer_id"] = $row['userid'];
        echo "<script>window.location.href = '../user/index.php';</script>";
        exit();
    } 
    elseif ($role == 'Admin') 
    {
        $_SESSION["adminname"]= $username;
        $_SESSION["admin_id"] = $row['userid'];
       echo "<script>window.location.href = '../admin/admin.php';</script>";
        exit();
    }

    elseif ($role == 'Seller')  
{ 
    $_SESSION["username"] = $username; 
    $_SESSION["seller_id"] = $row['userid']; 
    
    echo "<script>window.location.href = '../seller/seller_dashboard.php';</script>"; 
    exit(); 
}
} 
    
} else {
    echo '<script>
    alert("Login failed");
    window.location.href = "signin_up.php";
</script>';
}

