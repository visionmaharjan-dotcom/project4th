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
    <div class="login-container">
        <div class="image-placeholder">
            <img src="../images/Welcome.png" alt="Welcome">
        </div>
        <h1>Welcome!</h1>
        <form class="form-login" method="POST" action="login.php" onsubmit="handleRememberMe()">
            <input type="text" placeholder="Username" name="username" id="username">
            <input type="password" placeholder="Password" name="password" id="password">
            <select name="role">
                <option value="Customer">Customer</option>
                <option value="Admin">Admin</option>
                <option value="Seller">Seller</option>
            </select>
            <div class="flex-container">
                <label class="remember-me">
                    <input type="checkbox" id="rememberMe">
                    Remember Me
                    <a href="forgot_password/email.php" class="forgot-password">Forgot password?</a>
                </label>
                <a href="signup.php">Don't have an account? Sign up</a>
            </div>
            <button type="submit" name="login">Login</button>
        </form>
    </div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Check if cookies exist
        const savedUsername = getCookie("username");
        const savedPassword = getCookie("password");
        if (savedUsername && savedPassword) {
            document.getElementById("username").value = savedUsername;
            document.getElementById("password").value = savedPassword;
            document.getElementById("rememberMe").checked = true;
        }
    });

    function handleRememberMe() {
        const rememberMe = document.getElementById("rememberMe").checked;
        const username = document.getElementById("username").value;
        const password = document.getElementById("password").value;

        if (rememberMe) {
            setCookie("username", username, 30);
            setCookie("password", password, 30);
        } else {
            deleteCookie("username");
            deleteCookie("password");
        }
    }

    function setCookie(name, value, days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        const expires = "expires=" + date.toUTCString();
        document.cookie = name + "=" + value + ";" + expires + ";path=/";
    }

    function getCookie(name) {
        const nameEQ = name + "=";
        const ca = document.cookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    function deleteCookie(name) {
        document.cookie = name + "=; Max-Age=-99999999;";
    }
</script>
