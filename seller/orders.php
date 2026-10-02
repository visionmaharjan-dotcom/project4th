
<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    include 'seller_header.php';
    require '../vendor/autoload.php';
    if (isset($_POST['update_status'])) {
        
        $order_id = $_POST['order_id'];
        $status = $_POST['status'];

        $sql_update = "UPDATE orders SET status = ? WHERE order_id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("si", $status, $order_id);
        $stmt_update->execute();



    try {
        $mail = new PHPMailer(true);
        // SMTP settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'vision777maharjan@gmail.com';
        $mail->Password   = 'cwpuvtxlhrzxhqwm';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Sender
        $email = $_SESSION['email'];
        $mail->setFrom('vision777maharjan@gmail.com', 'AgroMart');

        // Receiver
        $mail->addAddress($email);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'AgroMart Order Update';
        $mail->Body    = '
            <h2>Order Approved</h2>
            <p>Your AgroMart order has been approved by the seller.</p>
        ';

        $mail->send();

        echo "Email sent successfully!";

    } catch (Exception $e) {
        echo "Email could not be sent. Error: {$mail->ErrorInfo}";
    }




        header("Location: orders.php");
        exit();
    }

    $seller_id = $_SESSION['seller_id'];

    /* Get orders containing this seller's products */
    $sql_select = "
        SELECT DISTINCT
            O.order_id,
            O.total_price,
            O.status,
            O.order_date,
            U.username,
            U.email,
            U.contact
        FROM orders O
        JOIN users U ON O.user_id = U.userid
        JOIN order_item OI ON O.order_id = OI.order_id
        JOIN product P ON OI.product_id = P.id
        WHERE P.seller_id = ?
        ORDER BY O.order_date DESC
    ";

    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bind_param("i", $seller_id);
    $stmt_select->execute();
    $result = $stmt_select->get_result();




    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>

        <meta charset="utf-8">

        <title>Order Requests</title>

        <link rel="stylesheet" href="../css/seller.css">

        <style>
            body {
                background-color: #D7E5CA;
            }
        </style>

    </head>

    <body>

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

                    /*
                    * Get products from this seller
                    * that are included in this order
                    */
                    $sql_items = "
                        SELECT
                            P.name,
                            OI.product_quantity
                        FROM order_item OI
                        JOIN product P ON OI.product_id = P.id
                        WHERE OI.order_id = ?
                        AND P.seller_id = ?
                    ";

                    $stmt_items = $conn->prepare($sql_items);
                    $stmt_items->bind_param("ii", $order_id, $seller_id);
                    $stmt_items->execute();

                    $items_result = $stmt_items->get_result();
                ?>

                <tr>

                    <td>
                        <?php echo $order_id; ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['username']); ?><br>

                        <small>
                            <?php $_SESSION['email']=$row['email']?>
                            <?php echo htmlspecialchars($row['email']); ?>
                        </small><br>

                        <small>
                            <?php echo htmlspecialchars($row['contact']); ?>
                        </small>
                    </td>

                    <td>

                        <?php
                        while ($item = $items_result->fetch_assoc()) {

                            echo htmlspecialchars($item['name'])
                                . " x"
                                . $item['product_quantity']
                                . "<br>";
                        }
                        ?>

                    </td>

                    <td>
                        NRs <?php echo number_format($row['total_price'], 2); ?>
                    </td>

                    <td>
                        <?php echo $row['order_date']; ?>
                    </td>

                    <td>

                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">

                            <input
                                type="hidden"
                                name="order_id"
                                value="<?php echo $order_id; ?>"
                            >

                            <select
                                name="status"
                                class="form-select form-select-sm mb-1"
                            >

                                <option value="Pending"
                                    <?php if ($row['status'] == 'Pending') echo 'selected'; ?>>
                                    Pending
                                </option>

                                <option value="Approved"
                                    <?php if ($row['status'] == 'Approved') echo 'selected'; ?>>
                                    Approved
                                </option>

                                <option value="Shipped"
                                    <?php if ($row['status'] == 'Shipped') echo 'selected'; ?>>
                                    Shipped
                                </option>

                                <option value="Completed"
                                    <?php if ($row['status'] == 'Completed') echo 'selected'; ?>>
                                    Completed
                                </option>

                                <option value="Rejected"
                                    <?php if ($row['status'] == 'Rejected') echo 'selected'; ?>>
                                    Rejected
                                </option>

                            </select>

                            <button
                                type="submit"
                                name="update_status"
                                class="btn btn-primary btn-sm"
                            >
                                Update
                            </button>

                        </form>

                    </td>

                </tr>

                <?php } ?>

            </table>

        </div>

    </div>

    </body>

    </html>
    
