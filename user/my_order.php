<?php
include("../admin/connection.php");
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['customer_id'])) {
    header("Location: ../admin/signin_up.php");
    exit();
}

$user_id = $_SESSION['customer_id'];

$sql = "
    SELECT order_id, total_price, status, order_date
    FROM orders
    WHERE user_id = ?
    ORDER BY order_date DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Orders</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #D7E5CA;
        }
    </style>
</head>

<body>

<br><br><br><br>

<div class="container">

    <h2 class="mb-4">My Orders</h2>

    <?php if ($result->num_rows == 0) { ?>

        <div class="alert alert-info">
            You have not placed any orders yet.
        </div>

    <?php } else { ?>

        <table class="table table-bordered bg-white">

            <tr>
                <th>Order ID</th>
                <th>Total</th>
                <th>Date</th>
                <th>Status</th>
            </tr>

            <?php while ($row = $result->fetch_assoc()) { ?>

                <tr>

                    <td>
                        <?php echo $row['order_id']; ?>
                    </td>

                    <td>
                        NRs <?php echo number_format($row['total_price'], 2); ?>
                    </td>

                    <td>
                        <?php echo $row['order_date']; ?>
                    </td>

                    <td>
                        <?php echo ucfirst($row['status']); ?>
                    </td>

                </tr>

            <?php } ?>

        </table>

    <?php } ?>

</div>

</body>
</html>




