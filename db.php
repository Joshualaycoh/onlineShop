<?php
$host = "sql206.infinityfree.com";
$user = "if0_38706068";
$password = "Col323shepperd";
$dbname = "if0_38706068_onlineshopdb";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully!";
}
