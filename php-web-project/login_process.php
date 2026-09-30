<?php
session_start();
include './db_connect.php';

$user_id = trim(mysqli_real_escape_string($conn, $_POST['user_id']));
$pwd = trim($_POST['pwd']);

if (strpos($user_id, 'student') === 0 && $pwd === '1234') {
    $find_q = "SELECT name FROM users WHERE user_id = '$user_id'";
    $find_res = mysqli_query($conn, $find_q);
    $user_row = mysqli_fetch_assoc($find_res);
    $user_name = $user_row ? $user_row['name'] : '수강생';

    $_SESSION['user_id'] = $user_id;
    $_SESSION['name'] = $user_name;
    $_SESSION['user_level'] = 'student';
    
    echo "<script>
        if (confirm('⚠️ [보안 안내] 현재 안전하지 않은 초기 비밀번호(1234)를 사용 중입니다.\\n\\n수강생 개인정보 보호와 자격증 관리를 위해 지금 바로 비밀번호를 변경하시겠습니까?')) {
            location.href = './member_page.php'; 
        } else {
            location.href = './index.php';
        }
    </script>";
    exit;
} 

else if (($user_id === 'admin' || $user_id === 'admin2') && $pwd === '1234') {
    $_SESSION['user_id'] = $user_id;
    $_SESSION['name'] = ($user_id === 'admin') ? '원장선생님' : '부원장님';
    $_SESSION['user_level'] = 'admin';
    
    echo "<script>
        if (confirm('⚠️ [보안 안내] 현재 시스템 총괄 관리자의 비밀번호가 초기값(1234)으로 설정되어 있습니다.\\n\\n학원 보안 규격 수호를 위해 지금 바로 관리자 비밀번호를 수정하시겠습니까?')) {
            location.href = './admin_page.php'; 
        } else {
            location.href = './index.php';
        }
    </script>";
    exit;
}


$query = "SELECT * FROM users WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);

if ($row = mysqli_fetch_assoc($result)) {
    if (password_verify($pwd, $row['pwd'])) {
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['user_level'] = $row['user_level'];
        
        if ($pwd === '1234') {
            $target = ($row['user_level'] === 'admin') ? './admin_page.php' : './member_page.php';
            echo "<script>
                if (confirm('⚠️ [보안 안내] 현재 안전하지 않은 초기 비밀번호(1234)를 사용 중입니다.\\n\\n지금 바로 안전한 비밀번호로 수정하시겠습니까?')) {
                    location.href = '$target';
                } else {
                    location.href = './index.php';
                }
            </script>";
            exit;
        }
        
        echo "<script>alert('정상적으로 인증되었습니다.'); location.href='./index.php';</script>";
        exit;
    }
}

echo "<script>alert('아이디 또는 비밀번호가 올바르지 않습니다.'); history.back();</script>";
?>