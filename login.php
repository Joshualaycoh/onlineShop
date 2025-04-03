<?php
session_start(); // Start the session
echo "Welcome to your dashboard, " . $_SESSION['name'];
include "db.php";

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Secure the email input
    $email = mysqli_real_escape_string($conn, $email);

    // Query to fetch user details based on the entered email
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Validate the password using password_verify
        if (password_verify($password, $row['password'])) {
            // Set session variables
            $_SESSION['id'] = $row['id'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['user_id'] = $row['email'];
            $_SESSION['role'] = $row['role'];

            // Redirect based on role
            if ($row['role'] == 'admin') {
                echo "Welcome Admin!";
                header("Location: admin_dashboard.php");
            } else {
                echo "Welcome User!";
                header("Location: dashboard.php");
            }
        } else {
            echo "Wrong password!";
        }
    } else {
        echo "No account found with that email!";
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/public/login.css">
</head>

<body>
    <div class="container">
        <a href="/index.php">Shopping</a>
        <div class="login">
            <form action="/login.php" method="post">
                <input type="email" name="email"
                    placeholder="Enter your email">
                <input type="password" name="password"
                    placeholder="Enter your password">
                <input class="button" type="submit"
                    name="submit" value="login">
                <p>Not registered yet?<a class="signup" href="/registration.php">
                        Sign-Up
                    </a></p>
            </form>
        </div>
    </div>
</body>

</html>