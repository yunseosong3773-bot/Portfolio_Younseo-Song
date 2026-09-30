<?php
session_start();
include './db_connect.php';

$is_logged = isset($_SESSION['user_id']);
$level = $is_logged ? $_SESSION['user_level'] : 'guest';
$user_id = $is_logged ? $_SESSION['user_id'] : '';

$user_info = null;
$days_left = 0;

if ($is_logged && $level === 'student') {
    $user_q = "SELECT u.name, u.interests, t.months, t.total_count, t.remaining_count, t.expiry_date 
               FROM users u 
               JOIN tickets t ON u.user_id = t.user_id 
               WHERE u.user_id = '$user_id'";
    $user_res = mysqli_query($conn, $user_q);
    $user_info = mysqli_fetch_assoc($user_res);

    if ($user_info) {
        $today = new DateTime();
        $expiry = new DateTime($user_info['expiry_date']);
        $interval = $today->diff($expiry);
        $days_left = $interval->format('%r%a');
    }
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>세종건축기술학원 통합 관제 보드</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>🏗️ 세종건축기술학원 </h1>
            <div class="auth-bar">
                <?php if($is_logged): ?>
                    <p>안녕하세요, <strong><?php echo htmlspecialchars($_SESSION['name']); ?></strong>님</p>
                    
                    <?php if($level === 'student'): ?>
                        <a href="./member_page.php" class="btn active" style="background:#319795; color:white;">👤 마이페이지 </a>
                    <?php endif; ?>
                    
                    <?php if($level === 'admin'): ?>
                        <a href="./admin_page.php" class="btn btn-admin">강의실</a>
                        <a href="./admin_students.php" class="btn btn-admin">행정실</a>
                    <?php endif; ?>
                    <a href="./logout.php" class="btn" style="background:#e53e3e; color:white;">로그아웃</a>
                <?php else: ?>
                    <p class="guest-alert">📢 [비회원] 상태입니다. 달력 기반 전체 시간표 열람만 가능하며, 예약은 로그인 후 활성화됩니다.</p>
                    <a href="./login.php" class="btn">로그인</a> | <a href="./register.php" class="btn">수강생 가입신청</a>
                <?php endif; ?>
            </div>
        </header>

        <?php if ($is_logged && $level === 'student' && $user_info): ?>
            <div class="profile-card" style="background: #f7fafc; padding: 20px; border-radius: 8px; margin-bottom: 30px; border-left: 5px solid #3182ce;">
                <h3>💳 내 수강권 및 잔여 현황</h3>
                <p>• <b>수강 과목:</b> <?php echo htmlspecialchars($user_info['interests']); ?> | • <b>잔여 수강권:</b> <span style="color:#e53e3e; font-weight:bold; font-size:18px;"><?php echo $user_info['remaining_count']; ?>회</span> 남음</p>
                <p>• <b>수강 유효기간:</b> <?php echo $user_info['expiry_date']; ?>까지 
                    (<span style="font-weight:bold; color:#3182ce;">
                        <?php echo ($days_left >= 0) ? "수강 만료까지 " . $days_left . "일 남았습니다" : "수강권이 만료되었습니다"; ?>
                    </span>)
                </p>
            </div>
        <?php endif; ?>

        <div class="booking-section" style="background:#fff; border:1px solid #e2e8f0; padding:25px; border-radius:8px; margin-bottom: 40px;">
            <h3>📆 강의 스케줄러</h3>
            <p style="color:#718096; font-size:14px; margin-bottom:15px;">원하시는 날짜를 달력에서 선택하신 후 [조회 및 수강신청] 버튼을 눌러주세요.</p>
            
            <form action="./index.php" method="GET" style="margin-bottom: 25px; background:#edf2f7; padding:15px; border-radius:6px;">
                <label style="font-weight:bold;">🗓️ 수강 일자 선택: </label>
                <input type="date" name="search_date" value="<?php echo isset($_GET['search_date']) ? $_GET['search_date'] : date('Y-m-d'); ?>" required class="input-table" style="width:200px; display:inline-block; margin-right:10px;">
                <button type="submit" class="btn-update" style="background:#3182ce;">날짜별 강의 스케줄 조회</button>
            </form>

            <?php
            if (isset($_GET['search_date'])):
                $search_date = mysqli_real_escape_string($conn, $_GET['search_date']);
                echo "<h4>🔍 " . htmlspecialchars($search_date) . " 개설 강의 및 신청 현황</h4>";
                
                $class_q = "SELECT c.*, COUNT(r.res_id) AS app_cnt 
                            FROM classes c 
                            LEFT JOIN reservations r ON c.class_id = r.class_id 
                            WHERE c.class_date = '$search_date' 
                            GROUP BY c.class_id";
                $class_res = mysqli_query($conn, $class_q);
                
                if (mysqli_num_rows($class_res) == 0) {
                    echo "<p style='color:#e53e3e; padding:10px;'>해당 날짜에는 개설된 학원 강의가 없습니다.</p>";
                } else {
                    echo "<table class='styled-table'>
                            <tr><th>수강 과목</th><th>배정 교시</th><th>신청 현황(정원)</th><th>예약/행정 상태</th></tr>";
                    while ($c_row = mysqli_fetch_assoc($class_res)) {
                        
                        $is_my_booking = false;
                        if ($is_logged && $level === 'student') {
                            $my_res_q = "SELECT res_id FROM reservations WHERE user_id='$user_id' AND class_id='{$c_row['class_id']}'";
                            $my_res_check = mysqli_query($conn, $my_res_q);
                            $is_my_booking = (mysqli_num_rows($my_res_check) > 0);
                        }
                        
                        $is_full = ($c_row['app_cnt'] >= $c_row['max_students']);
                        
                        echo "<tr>
                                <td><b>{$c_row['subject_name']}</b></td>
                                <td>{$c_row['time_slot']}</td>
                                <td>{$c_row['app_cnt']} / {$c_row['max_students']} 명</td>
                                <td>";
                        
                        if (!$is_logged) {
                            echo "<span class='badge end' style='background:#a0aec0;'>🔒 로그인 필요</span>";
                        } 
                        else if ($level === 'admin') {
                            echo "<span class='badge ing' style='background:#4a5568;'>행정 모니터링중</span>";
                        } 
                        else {
                            if ($is_my_booking) {
                                echo "<a href='./cancel_process.php?class_id={$c_row['class_id']}&search_date={$search_date}' class='btn-delete' onclick='return confirm(\"수업 2일 전까지만 무료 취소가 가능합니다. 정말 예약 취소하시겠습니까?\");'>수강 취소하기</a>";
                            } else {
                                if ($is_full) {
                                    echo "<span class='badge end' style='padding:8px 12px;'>🚫 정원 마감</span>";
                                } else {
                                    echo "<a href='./reserve_action.php?class_id={$c_row['class_id']}&search_date={$search_date}' class='btn-apply' style='background:#48bb78; text-decoration:none; display:inline-block; padding:6px 12px; color:#fff; border-radius:4px;'>수강신청</a>";
                                }
                            }
                        }
                        echo "</td></tr>";
                    }
                    echo "</table>";
                }
            else:
                echo "<p style='color:#718096; text-align:center; padding:30px; border:1px dashed #cbd5e0; background:#f7fafc;'>위 달력에서 날짜를 지정하시면 실시간 수강신청 모듈이 활성화됩니다.</p>";
            endif;
            ?>
        </div>

        <?php if ($is_logged && $level === 'student'): ?>
            <div style="margin-top:20px;">
                <h3>📋 예약 내역 </h3>
                <table class="styled-table">
                    <thead>
                        <tr><th>수강 과목</th><th>수강 예정일</th><th>교육 시간</th><th>취소</th></tr>
                    </thead>
                    <tbody>
                        <?php
                        $my_list_q = "SELECT r.res_id, c.class_id, c.subject_name, c.class_date, c.time_slot 
                                      FROM reservations r 
                                      JOIN classes c ON r.class_id = c.class_id 
                                      WHERE r.user_id = '$user_id' 
                                      ORDER BY c.class_date ASC";
                        $my_res = mysqli_query($conn, $my_list_q);
                        if(mysqli_num_rows($my_res) == 0){
                            echo "<tr><td colspan='4' style='text-align:center; color:#a0aec0;'>현재 달력에 등록된 내 예약 내역이 없습니다.</td></tr>";
                        }
                        while($my_row = mysqli_fetch_assoc($my_res)) {
                            echo "<tr>
                                <td>{$my_row['subject_name']}</td>
                                <td><b>{$my_row['class_date']}</b></td>
                                <td>{$my_row['time_slot']}</td>
                                <td><a href='./cancel_process.php?class_id={$my_row['class_id']}&search_date={$my_row['class_date']}' class='btn-delete' onclick='return confirm(\"정말 취소하시겠습니까?\");'>예약 취소</a></td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>