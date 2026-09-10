<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
</head>
<body>
<title>Update Shop</title>
<style>
    body {
        background-color: #D7E5CA;
    }
</style>

<?php 
include 'header.php'; 

$customer_id = $_SESSION["customer_id"];
// Select user information
$sql_select = "SELECT * FROM users WHERE userid = ?";
$stmt_select = $conn->prepare($sql_select);
$stmt_select->bind_param("i", $customer_id);
$stmt_select->execute();
$result = $stmt_select->get_result();
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["first_name"];
    $middle_name = $_POST["middle_name"];
    $last_name = $_POST["last_name"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Update profile with new information
    $sql_update = "UPDATE users SET firstname = ?, middlename = ?, lastname = ?, username = ?, email = ?, password = ? WHERE userid = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssssssi", $first_name, $middle_name, $last_name, $username, $email, $password, $customer_id);
    $result_update = $stmt_update->execute();

    if ($result_update) {
        echo "<script>alert('Profile updated successfully'); window.location.href = 'account.php';</script>";
    } else {
        echo "Error updating profile";
    }
}
?>
<br><br><br><br><br><br>

<div class="main__content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="">
                        <a href="account.php" class="btn btn-secondary" name="button">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">First Name <span class="text-danger">*</span> </label>
                                <input type="text" name="first_name" class="form-control" value="<?php echo htmlspecialchars($row['firstname']); ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Middle Name <span class="text-danger">*</span> </label>
                                <input type="text" name="middle_name" class="form-control" value="<?php echo htmlspecialchars($row['middlename']); ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Last Name <span class="text-danger">*</span> </label>
                                <input type="text" name="last_name" class="form-control" value="<?php echo htmlspecialchars($row['lastname']); ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Username <span class="text-danger">*</span> </label>
                                <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($row['username']); ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Email <span class="text-danger">*</span> </label>
                                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($row['email']); ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Password <span class="text-danger">*</span> </label>
                                <input type="password" name="password" class="form-control" value="<?php echo htmlspecialchars($row['password']); ?>">
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success" name="update">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
