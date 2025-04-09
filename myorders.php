<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SESSION['user_role'] !== 'user') {
    header("Location: admin/dashboard.php");
    exit();
}
$user_id = $_SESSION['user_id'];

// Use prepared statements to prevent SQL injection
$sql = "SELECT 
            so.user_id,
            so.product_id,
            so.qty,
            so.total_amount,
            p.id,
            p.name,
            p.price,
            p.image
        FROM single_order so
        JOIN products p ON so.product_id = p.id
        WHERE so.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id); // "i" indicates integer
$stmt->execute();
$result = $stmt->get_result();

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
                <li><a href="myorders.php">My purchases</a></li>
                <li><a href="index.php">Home</a></li>
                <li class="logout" ><a href="logout.php">Logout</a></li>
            </ul>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Product id</th>
                    <th>Product Name</th>
                    <th>Image</th>
                    <th>Qty </th>
                    <th>Price </th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['product_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td class="tableImg" ><img src="../image/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" style="max-width: 100px; max-height: 100px;"></td>
                        <td><?php echo htmlspecialchars($row['qty']); ?></td>
                        <td><?php echo htmlspecialchars($row['price']); ?></td>
                        <td><?php echo htmlspecialchars($row['total_amount']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>

</html>