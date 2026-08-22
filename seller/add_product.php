<?php
session_start();
include("../admin_and_user/connection.php");

if (!isset($_SESSION['seller_id'])) {
    header("Location: ../admin_and_user/signin_up.php");
    exit();
}

$seller_id = $_SESSION['seller_id'];
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/seller.css"></head>
<body>

<title>Add Product</title>
<style>
    body {
        background-color: #D7E5CA;
    }
</style>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    $image = "";

    if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {

        $image = "../images/" . basename($_FILES['image']['name']);

        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            $image
        );
    }

    $sql_insert = "INSERT INTO product
                   (name, price, image, description, seller_id)
                   VALUES (?, ?, ?, ?, ?)";

    $stmt_insert = $conn->prepare($sql_insert);

    if (!$stmt_insert) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt_insert->bind_param(
        "sdssi",
        $name,
        $price,
        $image,
        $description,
        $seller_id
    );

    if ($stmt_insert->execute()) {

        echo "<script>
                alert('Product added successfully');
                window.location.href = 'manage_product.php';
              </script>";
        exit();

    } else {

        echo "Error adding product: " . $stmt_insert->error;
    }
}
?>
<br><br><br><br>

<div class="main__content">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        Add New Product
                    </div>
                    <div class="card-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Product Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Price</label>
                                <input type="number" name="price" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="4" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Product Image</label>
                                <input type="file" name="image" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-success">Add Product</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>


