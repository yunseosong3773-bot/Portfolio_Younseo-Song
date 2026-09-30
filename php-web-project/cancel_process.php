<?php
session_start(); include './db_connect.php';
$res_id = mysqli_real_escape_string($conn, $_GET['res_id']);
$user_id = $_SESSION['user_id'];

$chk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT c.class_date, DATEDIFF(c.class_date, NOW()) AS d_diff FROM reservations r JOIN classes c ON r.class_id=c.class_id WHERE r.res_id='$res_id'"));
if($chk['d_diff'] < 2) { die("<script>alert('수업일 기준 최소 2일 전까지만 무료 취소가 보장됩니다. 패널티 유효.'); history.back();</script>"); }

mysqli_query($conn, "DELETE FROM reservations WHERE res_id = '$res_id'");
mysqli_query($conn, "UPDATE tickets SET remaining_count = remaining_count + 1 WHERE user_id = '$user_id'");
echo "<script>alert('정상 예약 취소 및 수강권 1회 분 복구 완료.'); location.href='./member_page.php';</script>";
?>