<?php
include "db.php";

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $role = 'user';

    // Hash the password for secure storage
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if the name or email already exists
    $checkQuery = "SELECT * FROM users WHERE name='$name' OR email='$email'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        echo "Name or email already exists!";
    } else {
        // Insert data only if the name and email are unique
        $sql = "INSERT INTO users (name, email, password, phone, address, role) 
                VALUES ('$name', '$email', '$hashedPassword', '$phone', '$address', '$role')";

        $result = mysqli_query($conn, $sql);

        if (!$result) {
            echo "Error: {$conn->error}";
        } else {
            echo "Registered Successfully";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/public/register.css">
</head>

<body>
    <div class="container">
        <a href="/index.php">Shopping</a>
        <div class="register">
            <form action="registration.php" method="post">
                <input type="text" name="name" placeholder="Enter your name">
                <input type="email" name="email" placeholder="Enter your email">
                <input type="password" name="password" placeholder="Enter your password">
                <input type="text" name="phone" placeholder="Enter phone number">
                <textarea type="text" name="address" placeholder="Enter your address"></textarea>
                <input class="button" type="submit" name="submit" value="sign-up">
                <p>Already have an account?<a class="login" href="/login.php">login</a></p>
            </form>
        </div>
    </div>
</body>

</html>