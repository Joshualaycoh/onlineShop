<?php
session_start();
include "db.php";
if (isset($_GET['category_name'])) {
    $category_name = $_GET['category_name'];
    $sql_product_category = "Select * from products where category_name = '$category_name'";
    $result_product_category = mysqli_query($conn, $sql_product_category);
} else {
    $sql_product_category = "Select * from products";
    $result_product_category = mysqli_query($conn, $sql_product_category);
}
$sql_category = "Select * from categories";
$result_category = mysqli_query($conn, $sql_category);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/public/style.css">
</head>

<body>
    <header class="header">
        <a href="index.php">shop</a>
        <ul>
            <?php while ($row_category = mysqli_fetch_assoc($result_category)) { ?>
                <li>
                    <a href="index.php?category_name=<?php echo $row_category['name'] ?>">
                        <?php echo $row_category['name'] ?>
                    </a>
                </li>
            <?php } ?>
        </ul>

        <nav>
            <ul>
                <?php if (!isset($_SESSION['user_id'])) { ?>
                    <li><a href="/login.php">login</a></li>
                    <li><a href="/registration.php">signup</a></li>
                <?php } ?>
                <?php if (isset($_SESSION['user_id'])) { ?>
                    <li style="margin-right: 0;"><a href="/admin/dashboard.php">dashboard</a></li>
                <?php } ?>
            </ul>
        </nav>
    </header>
    <main class="main">

        <?php while ($row_product_category = mysqli_fetch_assoc($result_product_category)) { ?>
            <div class="card">
                <img src="image/<?php echo $row_product_category['image'] ?>" alt="productImg">
                <div class="details">
                    <h2><?php echo $row_product_category['name'] ?></h2>
                    <p><?php echo $row_product_category['description'] ?></p>
                    <p><?php echo $row_product_category['stock'] ?></p>
                    <p class="price">₱<span><?php echo $row_product_category['price'] ?></span></p>
                </div>
                <a href="add-to-card">Buy Now</a>
            </div>
        <?php } ?>

    </main>
    <footer class="footer">
        <p>Copyright 2025 </p>
    </footer>
</body>

</html>