<?php
session_start();
include './db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'student') {
    echo "<script>alert('로그인 후 접근 가능한 수강생 전용 메뉴입니다.'); location.href='./login.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];

$query = "SELECT u.*, t.months, t.total_count, t.remaining_count, t.expiry_date 
          FROM users u 
          JOIN tickets t ON u.user_id = t.user_id 
          WHERE u.user_id = '$user_id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

$today = new DateTime();
$expiry = new DateTime($row['expiry_date']);
$interval = $today->diff($expiry);
$days_left = $interval->format('%r%a');
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>마이페이지 - 내 계정 및 수강권 종합 정보</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container" style="max-width: 800px;">
        <header>
            <h2>👤 내 계정 프로필 및 수강권</h2>
            <p style="margin-top:10px;">
                <a href="./index.php" class="btn active" style="background:#1a365d; color:white;">← 메인 스케줄러 보드로 이동</a>
                <a href="./logout.php" class="btn" style="background:#e53e3e; color:white;">로그아웃</a>
            </p>
        </header>

        <div class="profile-card" style="border-left-color: #319795; background: #e6fffa; margin-bottom: 30px;">
            <h3 style="color:#2c7a7b; margin-bottom:10px;">🎫 수강권 정보</h3>
            <table style="width:100%; font-size:15px; line-height:2;">
                <tr><td style="width:30%; font-weight:bold;">• 수강권 종류:</td><td><b><?php echo $row['months']; ?>개월</b> 정규 과정</td></tr>
                <tr><td style="font-weight:bold;">• 총 수강 횟수:</td><td><?php echo $row['total_count']; ?>회 제공</td></tr>
                <tr><td style="font-weight:bold;">• 현재 잔여 수강 횟수:</td><td><span style="color:#e53e3e; font-weight:bold; font-size:17px;"><?php echo $row['remaining_count']; ?>회</span> 남음</td></tr>
                <tr><td style="font-weight:bold;">• 수강권 유효 기한:</td><td><?php echo $row['start_date']; ?> ~ <b><?php echo $row['expiry_date']; ?></b></td></tr>
                <tr><td style="font-weight:bold;">• 유효 마감 디데이(D-Day):</td><td><b style="color:#3182ce;">수강 마감까지 현재 <?php echo $days_left; ?>일 남았습니다.</b></td></tr>
            </table>
        </div>

        <h3>📋 내 가입 원적 및 계정 정보</h3>
        <table class="styled-table" style="margin-bottom: 40px;">
            <thead>
                <tr><th style="width:35%;">행정 관리 구분 항목</th><th>내 등록 데이터 원본 내용</th></tr>
            </thead>
            <tbody>
                <tr><td><b>수강생 고유 식별 ID</b></td><td><span class="count-highlight"><?php echo htmlspecialchars($row['user_id']); ?></span></td></tr>
                <tr><td><b>수강생 등록 본명</b></td><td><b><?php echo htmlspecialchars($row['name']); ?></b></td></tr>
                <tr><td><b>수강 희망 자격증 종류</b></td><td><span class="badge ing" style="font-size:13px;"><?php echo htmlspecialchars($row['interests']); ?></span></td></tr>
                <tr><td><b>자격 자격증 취득 목적</b></td><td><?php echo htmlspecialchars($row['purpose']); ?></td></tr>
                <tr><td><b>수강 개시일</b></td><td><span class="date-highlight"><?php echo $row['start_date']; ?></span> 부 개강 승인 완료</td></tr>
                <tr><td><b>사전 상담 및 건의 메모</b></td><td><div style="background:#f7fafc; padding:12px; border:1px solid #edf2f7; border-radius:4px; font-style:italic; color:#4a5568;"><?php echo nl2br(htmlspecialchars($row['memo'] ? $row['memo'] : '제출된 사전 건의 메모 사항이 없습니다.')); ?></div></td></tr>
            </tbody>
        </table>

        <div class="form-box" style="background:#fff; border:1px solid #e2e8f0; padding:25px; border-radius:8px; border-top: 4px solid #e53e3e;">
            <h3 style="color:#e53e3e; margin-bottom:10px;">🔒 비밀번호 수정 </h3>
            <p style="color:#718096; font-size:13px; margin-bottom:15px;">초기 비밀번호(1234)를 사용 중이시거나 변경이 필요하시면 새로운 비밀번호를 설정하세요.</p>
            
            <form action="./update_pwd.php" method="POST" style="display: flex; gap: 10px; align-items: center;">
                <div style="flex: 1;">
                    <input type="password" name="new_pwd" placeholder="새로운 비밀번호 입력" required class="input-table" style="width:100%; margin-bottom:0;">
                </div>
                <button type="submit" class="btn-update" style="background:#e53e3e; height: 42px; white-space: nowrap;">비밀번호 즉시 변경</button>
            </form>
        </div>
    </div>
</body>
</html>