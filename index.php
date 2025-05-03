<?php
session_start();
include "db.php";

// Enable error reporting for debugging (you can remove this on production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fetch categories
$sql_category = "SELECT * FROM categories";
$result_category = mysqli_query($conn, $sql_category);

// Fetch products (filter by category if set)
if (isset($_GET['category_name'])) {
    $category_name = mysqli_real_escape_string($conn, $_GET['category_name']);

    $sql_product_category = "
        SELECT products.* FROM products
        INNER JOIN categories ON products.category_id = categories.id
        WHERE categories.name = '$category_name' AND products.stock > 0
    ";
} else {
    $sql_product_category = "SELECT * FROM products WHERE stock > 0";
}

$result_product_category = mysqli_query($conn, $sql_product_category);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Shop</title>
    <link rel="stylesheet" href="/public/style.css">
</head>

<body>
    <header class="header">
        <a href="index.php">Shop</a>
        <select onchange="window.location.href=this.value;">
            <option value="">Categories</option>
            <?php while ($row_category = mysqli_fetch_assoc($result_category)) { ?>
                <option value="index.php?category_name=<?php echo urlencode($row_category['name']); ?>">
                    <?php echo htmlspecialchars($row_category['name']); ?>
                </option>
            <?php } ?>
        </select>
        <nav>
            <ul>
                <?php if (!isset($_SESSION['user_id'])) { ?>
                    <li><a href="/login.php">Login</a></li>
                    <li><a href="/registration.php">Signup</a></li>
                <?php } else { ?>
                    <li style="margin-right: 0;">
                        <?php if ($_SESSION['user_role'] === 'admin') { ?>
                            <a href="/admin/dashboard.php">Dashboard</a>
                        <?php } else { ?>
                            <a href="/dashboard.php">Dashboard</a>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>
        </nav>
    </header>

    <main class="main">
        <?php if (mysqli_num_rows($result_product_category) > 0): ?>
            <?php while ($row_product_category = mysqli_fetch_assoc($result_product_category)) { ?>
                <div class="card">
                    <img src="image/<?php echo htmlspecialchars($row_product_category['image']); ?>" alt="productImg">
                    <div class="details">
                        <h2><?php echo htmlspecialchars($row_product_category['name']); ?></h2>
                        <p>Description: <?php echo htmlspecialchars($row_product_category['description']); ?></p>
                        <p>Stock: <?php echo $row_product_category['stock']; ?></p>
                        <p class="price">₱<span><?php echo $row_product_category['price']; ?></span></p>
                    </div>

                    <?php if (!isset($_SESSION['user_id'])) { ?>
                        <a href="login.php">Buy Now</a>
                    <?php } else { ?>
                        <form action="singleorder.php" method="get" class="buy-form">
                            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                            <input type="hidden" name="product_id" value="<?php echo $row_product_category['id']; ?>">
                            <input type="hidden" name="product_price" value="<?php echo $row_product_category['price']; ?>">

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
        <?php else: ?>
            <p>No products found in this category.</p>
        <?php endif; ?>
    </main>

    <footer class="footer">
        <p>&copy; 2025 Online Shop</p>
    </footer>

    <script>
        function changeQuantity(parent, change) {
            const input = parent.querySelector('input[type="number"]');
            let value = parseInt(input.value);
            const min = parseInt(input.min);
            const max = parseInt(input.max);
            value += change;
            if (value < min) value = min;
            if (value > max) value = max;
            input.value = value;
        }
    </script>
</body>
</html>
