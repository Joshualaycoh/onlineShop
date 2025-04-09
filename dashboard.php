<?php
session_start();
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_role'] == 'user') {

    } else {
        header("Location: admin/dashboard.php");
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
    <title>User Dashboard</title>
    <link rel="stylesheet" href="/public/dashboard.css">
</head>

<body>
    <div class="container">
        <div class="dashboard_sidebar">
            <ul>
                <li><a href="myorders.php">My Purchases</a></li>
                <li><a href="index.php">Home</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
        <div class="dashboard_main">
            <div class="dashboard_promos">
                <h2>Product Promos & Sales</h2>
                <div class="promo_cards">
                    <div class="promo_card">
                        <img src="promoImg/promo1.avif" alt="Promo 1">
                        <div class="promo_details">
                            <h3>Summer Sale!</h3>
                            <p>Get 20% off on all summer items.</p>
                            <a href="#">Shop Now</a>
                        </div>
                    </div>
                    <div class="promo_card">
                        <img src="promoImg/promo2.avif" alt="Promo 2">
                        <div class="promo_details">
                            <h3>Flash Deal!</h3>
                            <p>Limited time offer: 50% off selected products.</p>
                            <a href="#">View Deals</a>
                        </div>
                    </div>
                    <div class="promo_card">
                        <img src="promoImg/promo3.avif" alt="Promo 2">
                        <div class="promo_details">
                            <h3>Flash Deal!</h3>
                            <p>Limited time offer: 50% off selected products.</p>
                            <a href="#">View Deals</a>
                        </div>
                    </div>
                    <div class="promo_card">
                        <img src="promoImg/promo4.avif" alt="Promo 2">
                        <div class="promo_details">
                            <h3>Flash Deal!</h3>
                            <p>Limited time offer: 50% off selected products.</p>
                            <a href="#">View Deals</a>
                        </div>
                    </div>
                    </div>
            </div>

            <div class="dashboard_vouchers">
                <h2>Your Vouchers</h2>
                <div class="voucher_cards">
                    <div class="voucher_card">
                        <h3>10% Off Voucher</h3>
                        <p>Code: 10OFFNOW</p>
                        <p>Valid until: 2025-12-31</p>
                        <button class="use_voucher">Use Voucher</button>
                    </div>
                    <div class="voucher_card">
                        <h3>Free Shipping</h3>
                        <p>Code: FREESHIP</p>
                        <p>Valid until: 2025-11-30</p>
                        <button class="use_voucher">Use Voucher</button>
                    </div>
                    <div class="voucher_card">
                        <h3>Free Shipping</h3>
                        <p>Code: FREESHIP</p>
                        <p>Valid until: 2025-11-30</p>
                        <button class="use_voucher">Use Voucher</button>
                    </div>
                    <div class="voucher_card">
                        <h3>Free Shipping</h3>
                        <p>Code: FREESHIP</p>
                        <p>Valid until: 2025-11-30</p>
                        <button class="use_voucher">Use Voucher</button>
                    </div>
                    </div>
            </div>
        </div>
    </div>
</body>

</html>