<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .info-list-group {
            font-size: 1.7rem;
            padding: 20px;
            
        }
        .text-container {
          
            background-color: #f0f8ff; 
        }
        
        .profile-img {
            width: 250px;
            height: 250px;
        }
        .profile-img-container {
           
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            background-color: #f0f8ff; 
            
        }
    </style>
</head>
<style>
        body {
            background-color: #D7E5CA;
        }
       

    </style>
<body>

<title>Setting</title>

<?php 
include 'header.php'; 

$customer_id = $_SESSION["customer_id"];
$sql_select = "SELECT * FROM users WHERE userid = ?";
$stmt = $conn->prepare($sql_select);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    echo "User not found.";
    exit();
}

$full_name = $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname'];
?>
<br><br><br><br><br><br><br><br><br>
<div class="main__content">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <ul class="list-group info-list-group">
                    <li class="list-group-item text-container">
                        <strong>User Name:</strong> <span class="ps-2"><?php echo htmlspecialchars($row['username']); ?></span>
                    </li>
                    <li class="list-group-item">
                        <strong>Full Name:</strong> <span class="ps-2"><?php echo htmlspecialchars($full_name); ?></span>
                    </li>
                    <li class="list-group-item">
                        <strong>Contact Number:</strong> <span class="ps-2"><?php echo htmlspecialchars($row['contact']); ?></span>
                    </li>
                    <li class="list-group-item">
                        <strong>Email:</strong> <span class="ps-2"><?php echo htmlspecialchars($row['email']); ?></span>
                    </li>
                    <li class="list-group-item">
                        <strong>Role:</strong> <span class="ps-2"><?php echo htmlspecialchars($row['role']); ?></span>
                    </li>
                </ul>
            </div>
            <div class="col-md-6">
                <ul class="list-group info-list-group">
                    <li class="list-group-item profile-img-container">
                        <img src="../images/profile.jpg" alt="Profile Image" class="profile-img">
                    </li>
                    <li class="list-group-item text-center">
                        <a href="update_profile.php" class="btn btn-secondary">Edit Profile</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

</body>
</html>
