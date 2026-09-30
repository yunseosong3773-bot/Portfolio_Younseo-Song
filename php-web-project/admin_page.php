<?php
session_start();
include './db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'admin') {
    echo "<script>alert('행정실 관리자 전용 보안 구역입니다.'); location.href='./login.php';</script>";
    exit;
}

if (isset($_POST['action']) && $_POST['action'] === 'add_class') {
    $subject_name = mysqli_real_escape_string($conn, $_POST['subject_name']);
    $class_date = mysqli_real_escape_string($conn, $_POST['class_date']);
    $time_slot = mysqli_real_escape_string($conn, $_POST['time_slot']);
    $max_students = intval($_POST['max_students']);

    $insert_q = "INSERT INTO classes (subject_name, class_date, time_slot, max_students) VALUES ('$subject_name', '$class_date', '$time_slot', $max_students)";
    if (mysqli_query($conn, $insert_q)) {
        echo "<script>alert('🆕 새로운 정규 강의 스케줄이 정상 추가되었습니다.'); location.href='./admin_page.php';</script>";
    }
}


if (isset($_GET['action']) && $_GET['action'] === 'delete_class') {
    $class_id = intval($_GET['class_id']);
    
    $delete_q = "DELETE FROM classes WHERE class_id = $class_id";
    if (mysqli_query($conn, $delete_q)) {
        echo "<script>alert('🗑️ 선택하신 강의 스케줄이 영구 폐강(삭제) 되었습니다.'); location.href='./admin_page.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>행정 관리실 - 강의 스케줄 마스터</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h2>👑 세종건축학원 행정실 - 강의 추가 / 삭제 / 변경</h2>
            <p><a href="./index.php" class="btn">← 메인 종합 관제 보드</a></p>
        </header>

        <h3>📋 현재 학원 개설 강의 관리 명부</h3>
        <table class="styled-table">
            <thead>
                <tr><th>강의 ID</th><th>수강 과목</th><th>수강 일자</th><th>배정 타임</th><th>현재 예약 현황</th><th>개설 행정 관리</th></tr>
            </thead>
            <tbody>
                <?php
                $q = "SELECT c.*, COUNT(r.res_id) AS app_cnt FROM classes c LEFT JOIN reservations r ON c.class_id = r.class_id GROUP BY c.class_id ORDER BY c.class_date ASC";
                $res = mysqli_query($conn, $q);
                while($row = mysqli_fetch_assoc($res)) {
                    echo "<tr>
                        <td>{$row['class_id']}</td>
                        <td><b>{$row['subject_name']}</b></td>
                        <td>{$row['class_date']}</td>
                        <td>{$row['time_slot']}</td>
                        <td><span class='count-highlight'>{$row['app_cnt']}</span> / {$row['max_students']} 명</td>
                        <td>
                            <a href='./admin_page.php?action=delete_class&class_id={$row['class_id']}' class='btn-delete' onclick='return confirm(\"이 강의를 폐강 처리하겠습니까? 관련 예약 내역이 함께 연동 삭제됩니다.\");'>폐강(DELETE)</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="form-box" style="margin-top:40px; background:#f7fafc; border:1px solid #e2e8f0; padding:25px; border-radius:8px;">
            <h3>🏗️ 신규 훈련 강의 스케줄 개설 등록</h3>
            <form action="./admin_page.php" method="POST">
                <input type="hidden" name="action" value="add_class">
                
                <div class="form-group">
                    <label>수강 과목 선택:</label>
                    <select name="subject_name" required class="input-table" style="width:100%;">
                        <option value="건축도장기능사">건축도장기능사</option>
                        <option value="방수기능사">방수기능사</option>
                        <option value="건축목공기능사">건축목공기능사</option>
                        <option value="거푸집기능사">거푸집기능사</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>수강 일자 지정:</label>
                    <input type="date" name="class_date" value="<?php echo date('Y-m-d'); ?>" required class="input-table" style="width:100%;">
                </div>
                
                <div class="form-group">
                    <label>배정 타임 슬롯 선별:</label>
                    <input type="radio" name="time_slot" value="오전반(10시~16시)" checked> 오전반(10시~16시)
                    <input type="radio" name="time_slot" value="오후반(18시~24시)"> 오후반(18시~24시)
                </div>
                
                <div class="form-group">
                    <label>수업 최대 정원 (기본 3명 제한 요건):</label>
                    <input type="number" name="max_students" value="3" min="1" max="10" required class="input-table" style="width:100%;">
                </div>
                
                <button type="submit" class="btn-submit" style="background:#48bb78; margin-top:10px;">새로운 강의 정식 개설 고시</button>
            </form>
        </div>

        <div class="form-box" style="margin-top:40px; background:#fff; border:1px solid #e2e8f0; padding:25px; border-radius:8px; border-top: 4px solid #3182ce;">
            <h3 style="color:#3182ce; margin-bottom:10px;">🔒 관리자 비밀번호 수정</h3>
            <p style="color:#718096; font-size:13px; margin-bottom:15px;">보안 강화를 위해 초기 비밀번호(1234) 대신 통합 관제 권한을 보호할 강력한 마스터 패스워드를 재설정하세요.</p>
            
            <form action="./update_admin_pwd.php" method="POST" style="display: flex; gap: 10px; align-items: center;">
                <div style="flex: 1;">
                    <input type="password" name="new_pwd" placeholder="새로운 관리자 마스터 비밀번호 입력" required class="input-table" style="width:100%; margin-bottom:0;">
                </div>
                <button type="submit" class="btn-update" style="background:#3182ce; height: 42px; white-space: nowrap; color:white; border:none; border-radius:4px; cursor:pointer; padding:0 20px; font-weight:500;">비밀번호 즉시 변경</button>
            </form>
        </div>
    </div>
</body>
</html>