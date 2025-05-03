<?php
session_start();
include "../db.php";

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid product ID!");
}

$product_id = intval($_GET['id']);

// Fetch categories
$categories_result = mysqli_query($conn, "SELECT * FROM categories");

// Fetch existing product details
$product_stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$product_stmt->bind_param("i", $product_id);
$product_stmt->execute();
$product_result = $product_stmt->get_result();
$product = $product_result->fetch_assoc();
$product_stmt->close();

if (!$product) {
    die("Product not found!");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $description = htmlspecialchars(trim($_POST['description']));
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $category_id = intval($_POST['category_id']);

    $image = $product['image']; // Default to old image

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($_FILES['image']['type'], $allowed_types)) {
            die("Invalid image type.");
        }

        $upload_dir = "../image/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $new_image = basename($_FILES['image']['name']);
        $temp_location = $_FILES['image']['tmp_name'];
        $image_path = $upload_dir . $new_image;

        if (move_uploaded_file($temp_location, $image_path)) {
            $image = $new_image;
        } else {
            die("Image upload failed.");
        }
    }

    // Update product
    $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, stock = ?, image = ?, category_id = ? WHERE id = ?");
    $stmt->bind_param("ssdisii", $name, $description, $price, $stock, $image, $category_id, $product_id);

    if ($stmt->execute()) {
        header("Location: displayproduct.php");
        exit();
    } else {
        echo "Error updating product: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Product</title>
    <link rel="stylesheet" href="../public/dashboard.css">
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
    </div>
    <div class="dashboard_add">
        <div class="card">
            <form action="updateproduct.php?id=<?php echo $product_id; ?>" method="post" enctype="multipart/form-data">
                <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                <textarea name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>
                <input type="number" name="price" step="0.01" value="<?php echo $product['price']; ?>" required>
                <input type="number" name="stock" value="<?php echo $product['stock']; ?>" required>
                
                <h3>Current Image:</h3>
                <img src="../image/<?php echo htmlspecialchars($product['image']); ?>" alt="product" style="width:100px;"><br>
                <input type="file" name="image" accept="image/*">

                <select name="category_id" required>
                    <option value="">Select Category</option>
                    <?php while ($cat = mysqli_fetch_assoc($categories_result)) { ?>
                        <option value="<?php echo $cat['id']; ?>" <?php if ($cat['id'] == $product['category_id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($cat['name']); ?>
                        </option>
                    <?php } ?>
                </select>

                <input class="btn" type="submit" value="Update Product">
            </form>
        </div>
    </div>
</div>
</body>
</html>
