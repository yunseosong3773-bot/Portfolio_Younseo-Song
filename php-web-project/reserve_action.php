<?php
session_start();
include './db_connect.php';

if (!isset($_SESSION['user_id'])) { die("로그인 세션 만료"); }

$user_id = $_SESSION['user_id'];
$class_id = intval($_GET['class_id']);

$count_q = "SELECT COUNT(res_id) AS current_cnt FROM reservations WHERE class_id = $class_id";
$count_res = mysqli_query($conn, $count_q);
$count_row = mysqli_fetch_assoc($count_res);

if ($count_row['current_cnt'] >= 3) {
    echo "<script>alert('🚫 [예약 실패] 해당 강의의 예약 정원(3명)이 이미 초과 완료되어 신청이 불가능합니다.'); history.back();</script>";
    exit;
}

$ticket_q = "SELECT remaining_count FROM tickets WHERE user_id = '$user_id'";
$ticket_res = mysqli_query($conn, $ticket_q);
$ticket_row = mysqli_fetch_assoc($ticket_res);

if (!$ticket_row || $ticket_row['remaining_count'] <= 0) {
    echo "<script>alert('🚫 [예약 실패] 잔여 수강 횟수가 부족합니다. 행정실에 문의하세요.'); history.back();</script>";
    exit;
}

$dup_q = "SELECT res_id FROM reservations WHERE user_id='$user_id' AND class_id=$class_id";
$dup_res = mysqli_query($conn, $dup_q);
if(mysqli_num_rows($dup_res) > 0) {
    echo "<script>alert('이미 수강 신청이 완료된 강의입니다.'); history.back();</script>";
    exit;
}

mysqli_query($conn, "INSERT INTO reservations (user_id, class_id) VALUES ('$user_id', $class_id)");
mysqli_query($conn, "UPDATE tickets SET remaining_count = remaining_count - 1 WHERE user_id = '$user_id'");

echo "<script>alert('🎉 실시간 수강신청이 성공적으로 확정되었습니다! 잔여 횟수가 1회 차감됩니다.'); location.href='./member_page.php?search_date=" . $_GET['search_date'] . "';</script>";
?>