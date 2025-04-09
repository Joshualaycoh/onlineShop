<?php
session_start();
include "db.php";

if (isset($_GET['submit'])) {
    $user_id = filter_input(INPUT_GET, 'user_id', FILTER_VALIDATE_INT);
    $product_id = filter_input(INPUT_GET, 'product_id', FILTER_VALIDATE_INT);
    $product_quantity = filter_input(INPUT_GET, 'product_quantity', FILTER_VALIDATE_INT);
    $price = filter_input(INPUT_GET, 'product_price', FILTER_VALIDATE_FLOAT);

    if ($user_id && $product_id && $product_quantity && $price) {
        $total_amount = $product_quantity * $price;
        $stmt = $conn->prepare("INSERT INTO single_order (user_id, product_id, qty, total_amount) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $user_id, $product_id, $product_quantity, $total_amount);

        if ($stmt->execute()) {
            $stmt_stock = $conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
            $stmt_stock->bind_param("ii", $product_quantity, $product_id);
            if($stmt_stock->execute()){
                echo "Order added successfully! <a href='index.php'>Buy more</a>";
            } else {
                echo "Error updating stock: " . $stmt_stock->error;
            }
            $stmt_stock->close();
        } else {
            echo "Error adding order: " . $stmt->error;
        }
        $stmt->close();
    }else{
        echo "Invalid input parameters.";
    }
} else {
    header("Location: index.php");
    exit();
}
?>