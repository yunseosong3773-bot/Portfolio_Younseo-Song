<?php
session_start();
include './db_connect.php';

if (!isset($_SESSION['user_id'])) {
    die("인증 세션이 만료되었습니다.");
}

$user_id = $_SESSION['user_id'];
$new_pwd = $_POST['new_pwd'];

$hashed_pwd = password_hash($new_pwd, PASSWORD_BCRYPT);

$update_q = "UPDATE users SET pwd = '$hashed_pwd' WHERE user_id = '$user_id'";

if (mysqli_query($conn, $update_q)) {
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"], $params["secure"], $params["httponly"]
        );
    }
    session_destroy();

    echo "<script>
        alert('🔑 비밀번호 변경이 완료되었습니다! 안전한 시스템 이용을 위해 새로운 비밀번호로 다시 로그인해 주세요.');
        location.href='./login.php';
    </script>";
    exit;
} else {
    echo "<script>alert('시스템 행정 오류로 변경에 실패했습니다.'); history.back();</script>";
}
?>