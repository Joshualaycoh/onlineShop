<?php
$conn = new mysqli('localhost','root','','onlineshopdb');
if ($conn->connect_error) {
    echo "Error!: {$conn->connect_error}";
}
?>