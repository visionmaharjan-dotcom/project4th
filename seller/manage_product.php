<?php
session_start();
include("../admin_and_user/connection.php");

$seller_id = $_SESSION['seller_id'];

if (isset($_POST['delete_product'])) {
    $product_id = $_POST['product_id'];

    $sql_delete = "DELETE FROM product WHERE id = ? AND seller_id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("ii", $product_id, $seller_id);
    $stmt_delete->execute();
}

$sql_select = "SELECT * FROM product WHERE seller_id = ? ORDER BY id DESC";
$stmt = $conn->prepare($sql_select);
$stmt->bind_param("i", $seller_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<title>Manage Products</title>
<style>
    body {
        background-color: #D7E5CA;
    }
</style>

<?php
include 'seller_header.php';
?>
<br><br><br><br>

<div class="main__content">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Manage Products</h3>
            <a href="add_product.php" class="btn btn-success">Add New Product</a>
        </div>
        <table class="table table-bordered bg-white">
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><img src="<?php echo $row['image']; ?>" width="60"></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['price']); ?></td>
                <td><?php echo htmlspecialchars($row['description']); ?></td>
                <td>
                    <form method="POST" onsubmit="return confirm('Delete this product?');">
                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="delete_product" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>

</body>
</html>