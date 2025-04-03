<?php
session_start();
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_role'] == 'admin') {
    } else {
        echo "go to user dashboard";
    }
} else {
    header("Location: ../index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="dashboard.css">
</head>

<body>
    <div class="container">
        <div class="dashboard_sidebar">
            <ul>
                <li><a href="addproduct.php">Add Product</a></li>
                <li><a href="">View Order</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </div>
        <div class="dashboard_main">
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing
                elit. Ratione, praesentium? Lorem ipsum dolor sit
                amet consectetur adipisicing elit. Fugiat magni nemo
                distinctio totam veritatis consequuntur iste
                similique ut, tempora natus.
            </p>
        </div>
    </div>
</body>

</html>