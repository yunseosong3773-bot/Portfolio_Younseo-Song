<?php
include './db_connect.php';

$user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
$pwd = password_hash($_POST['pwd'], PASSWORD_BCRYPT); 
$name = mysqli_real_escape_string($conn, $_POST['name']);
$user_level = mysqli_real_escape_string($conn, $_POST['user_level']);
$purpose = mysqli_real_escape_string($conn, $_POST['purpose']);
$start_date = mysqli_real_escape_string($conn, $_POST['start_date']);
$memo = mysqli_real_escape_string($conn, $_POST['memo']);
$interests = isset($_POST['interests']) ? implode(', ', $_POST['interests']) : '';

$check = mysqli_query($conn, "SELECT user_id FROM users WHERE user_id='$user_id'");
if(mysqli_num_rows($check) > 0) { die("<script>alert('중복된 ID입니다.'); history.back();</script>"); }

$query = "INSERT INTO users VALUES ('$user_id', '$pwd', '$name', '$user_level', '$interests', '$purpose', '$start_date', '$memo')";
if(mysqli_query($conn, $query)) {
    echo "<script>alert('회원등록 신청 성공! 행정실의 수강권 부여 승인을 기다려주세요.'); location.href='./login.php';</script>";
}
?>