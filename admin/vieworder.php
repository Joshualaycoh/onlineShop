<?php
session_start();
include "../db.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

// Check if the user is an admin
if ($_SESSION['user_role'] !== 'admin') {
    echo "Go to user dashboard";
    exit();
}

// Fetch products from the database
$sql = "SELECT * FROM single_order";
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if (!$result) {
    die("Error fetching products: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <link rel="stylesheet" href="../public/order.css">
</head>

<body>
<div class="container">
       <div class="dashboard_sidebar">
            <ul>
                <li><a href="addproduct.php">Add Product</a></li>
                <li><a href="displayproduct.php">View Products</a></li>
                <li><a href="vieworder.php">View Orders</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
            </ul>
        </div>
    
    <table>
        <thead>
            <tr>
                <th>User ID</th>
                <th>Product ID</th>
                <th>Quantity</th>
                <th>Total Amount</th>

            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['product_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['qty']); ?></td>
                    <td><?php echo htmlspecialchars($row['total_amount']); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    </div>
</body>

</html>