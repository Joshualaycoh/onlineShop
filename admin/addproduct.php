<?php
session_start();
include "../db.php"; // Adjust the path if necessary

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

// Check if the user has admin privileges
if ($_SESSION['user_role'] !== 'admin') {
    header("Location: ../user/dashboard.php");
    exit();
}

// Fetch categories from the database
$sql1 = "SELECT id, name FROM categories";
$result1 = mysqli_query($conn, $sql1);

if (!$result1) {
    error_log("Error fetching categories: " . $conn->error);
    die("Something went wrong. Please try again.");
}

// Handle form submission
if (isset($_POST['submit'])) {


    // Validate and sanitize inputs
    $name = htmlspecialchars(trim($_POST['name']));
    $description = htmlspecialchars(trim($_POST['description']));
    $price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);
    $stock = filter_var($_POST['stock'], FILTER_VALIDATE_INT);
    $category_name = $_POST['category_name']; // Get the category name

    // Validate file upload
    $image = $_FILES['image']['name'];
    $temp_location = $_FILES['image']['tmp_name'];
    $upload_location = "../image/";
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];

    if (!in_array($_FILES['image']['type'], $allowed_types)) {
        die("Invalid file type! Only JPG, PNG, and GIF are allowed.");
    }

    // Move uploaded file
    $image_path = $upload_location . basename($image);
    if (!move_uploaded_file($temp_location, $image_path)) {
        die("Failed to upload the image. Please try again.");
    }

    // Insert product into the database using prepared statements
    $stmt = $conn->prepare("INSERT INTO products (name, description, price, stock, image, category_name) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $description, $price, $stock, $image, $category_name); // Corrected bind_param

    if ($stmt->execute()) {
        echo "<div id='success-message' class='message'>Product added successfully!</div>";
    } else {
        error_log("Error inserting product: " . $stmt->error);
        echo "<div id='error-message' class='message'>Something went wrong. Please try again.</div>";
    }

    $stmt->close();
}
$conn->close();

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
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="text" name="name" placeholder="Enter Product Name!" required>
                    <textarea name="description" placeholder="Enter Product Description!" required></textarea>
                    <input type="number" name="price" placeholder="Enter Price here!" step="0.01" required>
                    <input type="number" name="stock" placeholder="Enter Stock here!" required>
                    <h3>Upload Image here!</h3>
                    <input type="file" name="image" required>

                    <select name="category_name">
                        <option>Select Category</option>
                        <?php
                        if ($result1) {
                            while ($row = mysqli_fetch_assoc($result1)) { ?>
                                <option value="<?php echo $row['name']; ?>">
                                    <?php echo $row['name']; ?>
                                </option>
                        <?php }
                        }
                        ?>
                    </select>

                    <input class="btn" type="submit" name="submit" value="Add Product">
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const message = document.querySelector('.message');
            if (message) {
                setTimeout(() => {
                    message.style.display = 'none';
                }, 5000);
            }
        });
    </script>
</body>

</html>