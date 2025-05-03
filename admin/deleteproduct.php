<?php
session_start();
include "../db.php";

// Check if admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid product ID!");
}

$product_id = intval($_GET['id']);

// Use prepared statement
$stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);

if ($stmt->execute()) {
    echo '<div id="successModal" style="display:block; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; padding: 20px; border: 1px solid #ccc; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); z-index: 1000;">';
    echo 'Deleted successfully!';
    echo '</div>';
    echo '<script>
        setTimeout(function() {
            document.getElementById("successModal").style.display = "none";
            window.location.href = "displayproduct.php";
        }, 1000); 
    </script>';
} else {
    echo "Error deleting product: " . $stmt->error;
}
$stmt->close();
?>
