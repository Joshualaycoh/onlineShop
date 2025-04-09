<?php
session_start();
include "db.php";
if (isset($_GET['category_name'])) {
    $category_name = $_GET['category_name'];
    $sql_product_category = "SELECT * FROM products WHERE category_name = '$category_name' AND stock > 0";
    $result_product_category = mysqli_query($conn, $sql_product_category);
} else {
    $sql_product_category = "SELECT * FROM products WHERE stock > 0";
    $result_product_category = mysqli_query($conn, $sql_product_category);
}
$sql_category = "SELECT * FROM categories";
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
        <select onchange="window.location.href=this.value;">
            <option value="">Categories</option>
            <?php while ($row_category = mysqli_fetch_assoc($result_category)) { ?>
                <option value="index.php?category_name=<?php echo $row_category['name']; ?>">
                    <?php echo $row_category['name']; ?>
                </option>
            <?php } ?>
        </select>
        <nav>
            <ul>
                <?php if (!isset($_SESSION['user_id'])) { ?>
                    <li><a href="/login.php">login</a></li>
                    <li><a href="/registration.php">signup</a></li>
                <?php } ?>
                <?php if (isset($_SESSION['user_id'])) { ?>
                    <li style="margin-right: 0;">
                        <?php if ($_SESSION['user_role'] === 'admin') { ?>
                            <a href="/admin/dashboard.php">dashboard</a>
                        <?php } else { ?>
                            <a href="/dashboard.php">dashboard</a>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>
        </nav>
    </header>
    <main class="main">
        <?php while ($row_product_category = mysqli_fetch_assoc($result_product_category)) { ?>
            <div class="card">
                <img src="image/<?php echo $row_product_category['image']; ?>" alt="productImg">
                <div class="details">
                    <h2><?php echo $row_product_category['name']; ?></h2>
                    <p>description: <?php echo $row_product_category['description']; ?></p>
                    <p>stock: <?php echo $row_product_category['stock']; ?></p>
                    <p class="price">₱<span><?php echo $row_product_category['price']; ?></span></p>
                </div>
                <?php if (!isset($_SESSION['user_id'])) { ?>
                    <a href="login.php">Buy Now</a>
                <?php } else { ?>
                    <form action="singleorder.php" method="get" class="buy-form">
                        <input type="number" name="user_id" value="<?php echo $_SESSION['user_id']; ?>" hidden>
                        <input type="number" name="product_id" value="<?php echo $row_product_category['id']; ?>" hidden>
                        <input type="number" name="product_price" value="<?php echo $row_product_category['price']; ?>" hidden>
                        <div class="quantity-selector">
                            <button type="button" onclick="changeQuantity(this.parentElement, -1)">-</button>
                            <input type="number" name="product_quantity" min="1" max="<?php echo $row_product_category['stock']; ?>" value="1">
                            <button type="button" onclick="changeQuantity(this.parentElement, 1)">+</button>
                        </div>
                        <input type="submit" name="submit" value="Buy now">
                    </form>
                <?php } ?>
            </div>
        <?php } ?>
    </main>
    <footer class="footer">
        <p>Copyright 2025 </p>
    </footer>
    <script>
        function changeQuantity(parent, change) {
            const input = parent.querySelector('input[type="number"]');
            let value = parseInt(input.value);
            const min = parseInt(input.min);
            const max = parseInt(input.max);
            value += change;
            if (value < min) {
                value = min;
            } else if (value > max) {
                value = max;
            }
            input.value = value;
        }
    </script>
</body>

</html>