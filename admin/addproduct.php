<?php
session_start();
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_role'] == 'admin') {
    } else {
        echo "go to user dashboard";
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
    <title>Document</title>
    <link rel="stylesheet" href="dashboard.css">
</head>

<body>
    <div class="container">
        <div class="dashboard_sidebar">
            <ul>
                <li><a href="addproduct.php">Add Product</a></li>
                <li><a href="">View Order</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </div>
        <div class="dashboard_add">
        <div class="card">
           <form action="" method="post" 
           enctype="multipart/form-data">
                <input type="text" name="name"
                placeholder="Enter Product Name!">
                <textarea name="description" placeholder="Enter Product Description!"></textarea>
                <input type="number" name="price"
                placeholder="Enter Price here!">
                <input type="number" name="stock"
                placeholder="Enter Stock here!">
                <h3>Upload Image here!</h3>
                <input type="file" name="image">
                <select name="">
                    <option value="category_id">
                        Category Id
                    </option>
                </select>
                <select name="">
                    <option value="category_name">
                        Category Name
                    </option>
                </select>
                <input class="btn" type="submit" name="submit"
                value="add product">
           </form>
        </div>
        </div>
    </div>
</body>

</html>