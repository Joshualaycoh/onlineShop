<?php
session_start();
include "../db.php";

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_role'] == 'admin') {
        if (isset($_GET['id'])) {
            $product_id = $_GET['id'];
            $sql = "DELETE FROM products WHERE id = '$product_id'";
            $result = mysqli_query($conn, $sql);

            if (!$result) {
                echo "Error!: (" . $conn->error . ")";
            } else {
                // Success, show modal and redirect after 3 seconds
                echo '<div id="successModal" style="display:block; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; padding: 20px; border: 1px solid #ccc; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); z-index: 1000;">';
                echo 'Deleted successfully!';
                echo '</div>';
                echo '<script>
                    setTimeout(function() {
                        document.getElementById("successModal").style.display = "none";
                        window.location.href = "displayproduct.php";
                    }, 400); 
                </script>';
            }
        }
    } else {
        echo "Go to dashboard";
    }
} else {
    header("Location: ../index.php");
}
