<?php
$conn = new mysqli('localhost', 'root', '', 'onlineshopdb');
if ($conn->connect_error) {
    echo "$conn->connect_error";
}
          