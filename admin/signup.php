
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/signin_up.css" rel="stylesheet" type="text/css"/>
    <title>Register</title>
</head>
<body style="background-image: url('../images/bg2.jpg'); background-repeat: no-repeat; background-size: cover;">
<div class="container">
      <div class="signup-container">
            <h1>Create Account!</h1>
            <form class="form-signup" method="POST" action="">
                <div class="role-selection">
                    <label>
                        <input type="radio" name="role" value="Customer" checked>Customer
                        <input type="radio" name="role" value="Admin">Admin
                        <input type="radio" name="role" value="Seller">Seller
                    </label>
                </div>
                <input type="text" placeholder="First name" name="firstname">
                <input type="text" placeholder="Middle name" name="middlename">
                <input type="text" placeholder="Last name" name="lastname">
                <input type="date" placeholder="DOB" name="dob">
                <div class="contact-field">
                    <select id="countryCode" name="countryCode">
                        <option value="+977">Nepal (+977)</option>
                        <option value="+91">India (+91)</option>
                    </select>
                    <input type="text" name="phone" placeholder="Contact number">
                </div>
                <input type="email" placeholder="Email" name="email">
                <input type="text" placeholder="Username" name="username">
                <input type="password" placeholder="Password" name="password">
                <button name="submit" type="submit">Create</button>
            </form>
        </div>
    </div>
    
</body>
</html>
<?php
include("connection.php");

if(isset($_POST["submit"]))
{
    $firstname = $_POST["firstname"];
    $middlename = $_POST["middlename"];
    $lastname = $_POST["lastname"];
    $dob = $_POST["dob"];
    $contact = $_POST["phone"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $role = $_POST["role"];

    if (empty($firstname) || empty($lastname) || empty($contact) || 
        empty($email) || empty($username) || empty($password)) {

        echo "<script>
                alert('All fields must be filled.');
                window.location.href = 'signup.php';
              </script>";
        exit;
    }

    $token = rand(100000, 999999);

    $sql = "INSERT INTO USERS 
            (firstname, middlename, lastname, contact, email, username, password, token, role) 
            VALUES 
            ('$firstname','$middlename','$lastname','$contact','$email','$username','$password','$token','$role')";

    $qry = mysqli_query($conn, $sql);

if ($qry) {
    echo "Registration successful! User ID: " . mysqli_insert_id($conn);
    exit();
} else {
    die("Registration failed: " . mysqli_error($conn));
}
}
?>
