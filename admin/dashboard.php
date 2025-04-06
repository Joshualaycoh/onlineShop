<?php
session_start();
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_role'] == 'admin') {
    } else {
        echo "go to user dashboard";
    }
} else {
    header("Location: ../dashboard.php");
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
                <li><a href="displayproduct.php">View Order</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </div>
        <div class="dashboard_main">
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quisquam, facere! Nobis
                 necessitatibus iste nemo dolor ducimus ipsa, quidem laboriosam recusandae tenetur 
                 rem repellat, nam sapiente quo quaerat. Eveniet iste magnam est ipsam incidunt 
                 blanditiis iusto laudantium nam? Blanditiis,  nisi minus, quae non voluptatem,
                 nulla fugit excepturi sit illo iste consequatur?</p>
            <!-- <?php for ($i = 1; $i < 8; $i++) { ?>
                <div class="card">
                    <img src="../productimg/shoe<?php echo $i; ?>.webp" alt="productImg">
                    <div class="details">
                        <h2>product title</h2>
                        <p>product-description</p>
                        <p>product-quantity</p>
                        <p class="price">₱<span>8500</span></p>
                    </div>

                </div>
            <?php } ?> -->

        </div>
    </div>
</body>

</html>