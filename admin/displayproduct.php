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
$sql = "SELECT * FROM products";
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
    <link rel="stylesheet" href="../public/display.css">
</head>

<body>
    <a class="back" href="dashboard.php">back</a>
    <table>
        <thead>
            <tr>
                <th>Product Title</th>
                <th>Product Description</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Image</th>
                <th>Category</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td><?php echo htmlspecialchars($row['price']); ?></td>
                    <td><?php echo htmlspecialchars($row['stock']); ?></td>
                    <td><img src="../image/<?php echo htmlspecialchars($row['image']); ?>" alt="Product Image" style="width: 50px; height: 50px;"></td>
                    <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                    <td><a class="update" href="updateproduct.php?id=<?php echo $row['id']; ?>">Update</a></td>
                    <td><a class="delete" href="deleteproduct.php?id=<?php echo $row['id']; ?>">Delete</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>