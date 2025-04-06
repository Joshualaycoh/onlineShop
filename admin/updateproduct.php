<?php
session_start();
include "../db.php";

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['id'])) {
    $product_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Fetch categories
    $sql = "SELECT * FROM categories";
    $result = mysqli_query($conn, $sql);

    // Fetch product details
    $sql1 = "SELECT * FROM products WHERE id = '$product_id'";
    $result1 = mysqli_query($conn, $sql1);
    $row1 = mysqli_fetch_assoc($result1);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $price = mysqli_real_escape_string($conn, $_POST['price']);
        $stock = mysqli_real_escape_string($conn, $_POST['stock']);
        $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);

        if ($category_name === "Select Category") {
            echo "<script>alert('Please select a valid category.');</script>";
        } else {

            $image = $_FILES['image']['name'];
            if ($image) {
                $temp_location = $_FILES['image']['tmp_name'];
                $upload_location = '../image/';
                move_uploaded_file($temp_location, $upload_location . $image);

                $sql = "UPDATE products SET 
                            name = '$name', 
                            description = '$description', 
                            price = '$price', 
                            stock = '$stock', 
                            image = '$image', 
                            category_name = '$category_name' 
                            WHERE id = '$product_id'";
            } else {
                $sql = "UPDATE products SET 
                            name = '$name', 
                            description = '$description', 
                            price = '$price', 
                            stock = '$stock', 
                            category_name = '$category_name' 
                            WHERE id = '$product_id'";
            }

            $result = mysqli_query($conn, $sql);
            if ($result) {
                header("Location: displayproduct.php");
                exit();
            } else {
                echo "Error updating product: {$conn->error}";
            }
        }
    }
} else {
    echo "Product ID not provided!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
        <div class="dashboard_add">
            <div class="card">
                <form action="updateproduct.php?id=<?php echo $product_id; ?>" method="post" enctype="multipart/form-data">
                    <input type="text" name="name" value="<?php echo $row1['name']; ?>">
                    <textarea name="description"><?php echo $row1['description']; ?></textarea>
                    <input type="number" name="price" value="<?php echo $row1['price']; ?>">
                    <input type="number" name="stock" value="<?php echo $row1['stock']; ?>">
                    <h3>Upload Image here!</h3>
                    <img class="prodImg" src="../image/<?php echo $row1['image']; ?>" alt="product-image">
                    <input type="file" name="image" value="">
                    <h4>Category:<?php echo $row1['category_name']; ?></h4>

                    <select name="category_name">
                        <option>Select Category</option>
                        <?php
                        if ($result) {
                            while ($row = mysqli_fetch_assoc($result)) { ?>
                                <option value="<?php echo $row['name']; ?>">
                                    <?php echo $row['name']; ?>
                                </option>
                        <?php }
                        }
                        ?>
                    </select>

                    <input class="btn" type="submit" name="submit" value="Update Product">
                </form>
            </div>
        </div>
    </div>
</body>

</html>