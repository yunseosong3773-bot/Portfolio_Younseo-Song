<?php
$conn = mysqli_connect("localhost", "root", "root", "assign_db");
if (!$conn) { die("DB Connection Error: " . mysqli_connect_error()); }
mysqli_set_charset($conn, "utf8mb4");
?>