<?php
include 'seller_header.php';

if (isset($_POST['update_status'])) {

    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    $sql_update = "UPDATE orders SET status = ? WHERE order_id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("si", $status, $order_id);
    $stmt_update->execute();

    header("Location: orders.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
   <link rel="stylesheet" href="../css/seller.css"></head>
<body>
<br><br><br><br>
<title>Order Requests</title>
<style>
    body {
        background-color: #D7E5CA;
    }
</style>

<?php
$sql_select = "
    SELECT O.order_id, O.total_price, O.status, O.order_date, U.username, U.email, U.contact
    FROM orders O
    JOIN users U ON O.user_id = U.userid
    ORDER BY O.order_date DESC";
$result = $conn->query($sql_select);
?>

<br><br><br><br>

<div class="main__content">
    <div class="container">
        <h3 class="mb-3">Order Requests</h3>
        <table class="table table-bordered bg-white">
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Items</th>
                <th>Total (NRs)</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) {
                $order_id = $row['order_id'];

                $sql_items = "SELECT product_name, quantity FROM order_item WHERE order_id = ?";
                $stmt_items = $conn->prepare($sql_items);
                $stmt_items->bind_param("i", $order_id);
                $stmt_items->execute();
                $items_result = $stmt_items->get_result();
            ?>
            <tr>
                <td><?php echo $order_id; ?></td>
                <td>
                    <?php echo htmlspecialchars($row['username']); ?><br>
                    <small><?php echo htmlspecialchars($row['email']); ?></small><br>
                    <small><?php echo htmlspecialchars($row['contact']); ?></small>
                </td>
                <td>
                    <?php while ($item = $items_result->fetch_assoc()) {
                        echo htmlspecialchars($item['product_name']) . " x" . $item['quantity'] . "<br>";
                    } ?>
                </td>
                <td><?php echo number_format($row['total_price'], 2); ?></td>
                <td><?php echo $row['order_date']; ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                        <select name="status" class="form-select form-select-sm mb-1">
                            <option value="pending" <?php if ($row['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                            <option value="approved" <?php if ($row['status'] == 'approved') echo 'selected'; ?>>Approved</option>
                            <option value="shipped" <?php if ($row['status'] == 'shipped') echo 'selected'; ?>>Shipped</option>
                            <option value="completed" <?php if ($row['status'] == 'completed') echo 'selected'; ?>>Completed</option>
                            <option value="rejected" <?php if ($row['status'] == 'rejected') echo 'selected'; ?>>Rejected</option>
                        </select>
                        <button type="submit" name="update_status" class="btn btn-primary btn-sm">Update</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>

</body>
</html>


