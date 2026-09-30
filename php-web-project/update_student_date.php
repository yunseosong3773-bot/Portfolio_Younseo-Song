<?php
session_start(); include './db_connect.php';
if ($_SESSION['user_level'] !== 'admin') { die("접근 불허"); }

$user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
$ticket_id = mysqli_real_escape_string($conn, $_POST['ticket_id']);
$start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
$expiry_date = mysqli_real_escape_string($conn, $_POST['expiry_date']);

mysqli_query($conn, "UPDATE users SET start_date = '$start_date' WHERE user_id = '$user_id'");
mysqli_query($conn, "UPDATE tickets SET expiry_date = '$expiry_date' WHERE ticket_id = '$ticket_id'");

echo "<script>alert('해당 수강생의 수강 기간 설정이 완료되었습니다.'); location.href='./admin_students.php';</script>";
?>