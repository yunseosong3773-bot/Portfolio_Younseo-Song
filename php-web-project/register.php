<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8"><title>세종학원 수강생 가입</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <div class="container">
        <h2>🏗️ 세종건축기술학원 신규 가입 신청서</h2>
        <p>인적사항과 희망 사항을 기재해 주시면, 로그인 후 학원 행정실의 수강권 최종 승인 완료 후 수업 예약이 가능합니다.</p>
        <form action="./register_process.php" method="POST" class="form-box">
            
            <div class="form-group">
                <label>희망 아이디 및 패스워드 설정:</label>
                <input type="text" name="user_id" placeholder="아이디 입력" required style="width:49%; display:inline-block;">
                <input type="password" name="pwd" placeholder="비밀번호 설정" required style="width:49%; display:inline-block;">
            </div>
            <div class="form-group"><label>수강생 본명:</label><input type="text" name="name" required></div>

            <div class="form-group">
                <label>가입 계정 권한 구분:</label>
                <input type="radio" name="user_level" value="student" checked> 일반 수강생 회원
                <input type="radio" name="user_level" value="admin"> 학원 행정 관리자
            </div>

            <div class="form-group">
                <label>수강 희망 자격증 종목 (중복 선택 가능):</label><br>
                <input type="checkbox" name="interests[]" value="건축도장기능사"> 건축도장기능사
                <input type="checkbox" name="interests[]" value="방수기능사"> 방수기능사
                <input type="checkbox" name="interests[]" value="건축목공기능사"> 건축목공기능사
                <input type="checkbox" name="interests[]" value="거푸집기능사"> 거푸집기능사
            </div>

            <div class="form-group">
                <label>자격 취득 목적 고지:</label>
                <select name="purpose">
                    <option value="F4 비자 변경 및 자격 유지">F4 비자 변경 및 자격 유지</option>
                    <option value="현장 인력 취업 및 창업">현장 인력 취업 및 창업</option>
                    <option value="기술인협회 경력수첩 발급">기술인협회 경력수첩 발급 및 승급</option>
                </select>
            </div>

            <div class="form-group"><label>📆 수강 개시 희망일:</label><input type="date" name="start_date" value="<?php echo date('Y-m-d'); ?>" required></div>

            <div class="form-group"><label>학원 행정 상담 및 사전 건의사항:</label><br><textarea name="memo" rows="4" placeholder="기타 상담 메모를 기재하세요."></textarea></div>

            <button type="submit" class="btn-submit">학원 가입서 최종 전송</button>
        </form>
    </div>
</body>
</html>