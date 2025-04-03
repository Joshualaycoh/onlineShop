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
        <a href="index.php"><img src="" alt=""></a>

        <nav>
            <ul>
                <li><a href="/login.php">login</a></li>
                <li><a href="/registration.php">signup</a></li>
                <li style="margin-right: 0;"><a href="">dashboard</a></li>
            </ul>
        </nav>
    </header>
    <main class="main">
        <?php for ($i = 1; $i < 8; $i++) { ?>
            <div class="card">
                <img src="productimg/shoe<?php echo $i; ?>.webp" alt="productImg">
                <div class="details">
                    <h2>product title</h2>
                    <p>product-description</p>
                    <p>product-quantity</p>
                    <p class="price">₱<span>8500</span></p>
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