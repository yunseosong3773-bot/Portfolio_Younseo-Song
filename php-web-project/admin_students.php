<?php
session_start();
include './db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'admin') {
    echo "<script>alert('행정실 관리자 전용 보안 구역입니다.'); location.href='./login.php';</script>";
    exit;
}

if (isset($_POST['action']) && $_POST['action'] === 'issue_ticket') {
    $target_user = mysqli_real_escape_string($conn, $_POST['user_id']);
    $months = intval($_POST['months']);
    $total_count = intval($_POST['total_count']);
    $custom_start = mysqli_real_escape_string($conn, $_POST['custom_start_date']);
    
    $expiry_date = date('Y-m-d', strtotime($custom_start . " + $months months"));

    mysqli_query($conn, "UPDATE users SET start_date = '$custom_start' WHERE user_id = '$target_user'");
    $ticket_ins = "INSERT INTO tickets (user_id, months, total_count, remaining_count, expiry_date) VALUES ('$target_user', $months, $total_count, $total_count, '$expiry_date')";
    
    if (mysqli_query($conn, $ticket_ins)) {
        echo "<script>alert('🎉 선택하신 가입 회원에게 정식 수강권 승인 발급이 완료되었습니다.'); location.href='./admin_students.php';</script>";
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'delete_user') {
    $del_id = mysqli_real_escape_string($conn, $_GET['user_id']);
    mysqli_query($conn, "DELETE FROM users WHERE user_id = '$del_id'");
    echo "<script>alert('해당 회원 원적 영구 제명 및 수강권 자동 소멸 완료.'); location.href='./admin_students.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>행정 관리실 - 수강생 명부</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h2>👑 세종건축학원 행정실 - 수강생 및 수강권 관리</h2>
            <!-- 💡 중복 동선 배제: 오직 메인 관제 보드 단일 링크만 포설 -->
            <p><a href="./index.php" class="btn">← 메인 종합 관제 보드</a></p>
        </header>

        <!-- 요구사항: 서브쿼리를 이용해 아직 수강권 승인이 안 떨어진 신규 가입 대기 유저 격리 표출 -->
        <div class="profile-card" style="border-left-color: #dd6b20; background: #fffaf0; padding:20px; border-radius:8px; margin-bottom:35px;">
            <h3 style="color:#dd6b20; margin-bottom:12px;">🆕 신규 수강 승인 대기 회원 명단</h3>
            <table class="styled-table">
                <thead>
                    <tr><th>가입 신청자 정보</th><th>희망 종목 및 가입 목적</th><th>수강 개시일 지정</th><th>배정 개월 코스</th><th>승인 행정 처리</th></tr>
                </thead>
                <tbody>
                    <?php
                    $sub_filter_q = "SELECT * FROM users WHERE user_level='student' AND user_id NOT IN (SELECT user_id FROM tickets)";
                    $sub_res = mysqli_query($conn, $sub_filter_q);
                    
                    if(mysqli_num_rows($sub_res) == 0) { 
                        echo "<tr><td colspan='5' style='text-align:center; color:#718096; padding:15px;'>현재 행정실 서브쿼리에 포착된 신규 대기 회원이 존재하지 않습니다.</td></tr>"; 
                    }
                    while($new_user = mysqli_fetch_assoc($sub_res)) {
                        echo "<tr><form action='./admin_students.php' method='POST'>
                                <input type='hidden' name='action' value='issue_ticket'>
                                <input type='hidden' name='user_id' value='{$new_user['user_id']}'>
                                <td><b>{$new_user['name']}</b><br><small>({$new_user['user_id']})</small></td>
                                <td><small>{$new_user['interests']}<br><b>목적:</b> {$new_user['purpose']}</small></td>
                                <td><input type='date' name='custom_start_date' value='{$new_user['start_date']}' class='input-table' style='width:140px;'></td>
                                <td>
                                    <select name='months' class='input-table'>
                                        <option value='1'>1개월 코스 (10회)</option>
                                        <option value='3' selected>3개월 코스 (30회)</option>
                                        <option value='6'>6개월 코스 (60회)</option>
                                    </select>
                                    <input type='hidden' name='total_count' value='30'>
                                </td>
                                <td><button type='submit' class='btn-apply' style='background:#dd6b20; border:none; padding:6px 12px; color:#fff; border-radius:4px; cursor:pointer;'>정식 수강권 발급</button></td>
                            </form></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- 파트 4: 현재 정식 계약이 체결된 재적 수강생 전체 훈련일수 및 마감 기간 관리 -->
        <h3>👥 정식 재적 수강생 수강일수 및 원적 통합 제어 명부</h3>
        <table class="styled-table">
            <thead>
                <tr><th>수강생 정보</th><th>수강 개시일</th><th>수강 만료일</th><th>잔여 수강권 횟수</th><th>기간 변경(UPDATE)</th><th>원적 제명</th></tr>
            </thead>
            <tbody>
                <?php
                $join_list_q = "SELECT u.*, t.ticket_id, t.expiry_date, t.remaining_count FROM users u JOIN tickets t ON u.user_id = t.user_id WHERE u.user_level = 'student' ORDER BY t.expiry_date ASC";
                $result = mysqli_query($conn, $join_list_q);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr><form action='./update_student_date.php' method='POST'>
                        <input type='hidden' name='user_id' value='{$row['user_id']}'>
                        <input type='hidden' name='ticket_id' value='{$row['ticket_id']}'>
                        <td><b>{$row['name']}</b><br><small>({$row['user_id']})</small></td>
                        <td><input type='date' name='start_date' value='{$row['start_date']}' class='input-table' style='width:130px;'></td>
                        <td><input type='date' name='expiry_date' value='{$row['expiry_date']}' class='input-table' style='width:130px;'></td>
                        <td><b>{$row['remaining_count']} 회</b> 분</td>
                        <td><button type='submit' class='btn-update' style='padding:5px 10px;'>변경 적용</button></td>
                        <td><a href='./admin_students.php?action=delete_user&user_id={$row['user_id']}' class='btn-delete' onclick='return confirm(\"해당 수강생을 학원 명부에서 영구 제명합니까?\");'>제명(DELETE)</a></td>
                    </form></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>