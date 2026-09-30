<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>세종건축기술학원 - 로그인</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <div class="container" style="max-width: 480px; margin: 80px auto;">
        <h2>🔒 학원 통합 행정 로그인 시스템</h2>
        <p>수강생 예약 관리 및 행정 처리를 위해 인증을 진행해 주세요.</p>
        
        <form action="./login_process.php" method="POST" class="form-box">
            <div class="form-group">
                <label>아이디 (ID):</label>
                <input type="text" name="user_id" placeholder="아이디를 입력하세요" required class="input-table" style="width: 100%;">
            </div>
            
            <div class="form-group">
                <label>비밀번호 (Password):</label>
                <div style="position: relative; width: 100%;">
                    <input type="password" id="login_pwd" name="pwd" placeholder="비밀번호를 입력하세요" required 
                           class="input-table" style="width: 100%; padding-right: 45px; box-sizing: border-box;">
                    
                    <span id="toggle_pwd" 
                          style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; font-size: 18px; user-select: none; z-index: 10;">
                        👁️
                    </span>
                </div>
            </div>
            
            <button type="submit" class="btn-submit" style="margin-top: 15px; width: 100%;">로그인</button>
        </form>
        
        <div style="margin-top: 25px; text-align: center; font-size: 14px;">
            <a href="./index.php" style="color: #4a5568; text-decoration: none;">← 메인 시간표로 돌아가기</a>
            <span style="color: #cbd5e0; margin: 0 10px;">|</span>
            <a href="./register.php" style="color: #3182ce; text-decoration: none; font-weight: 500;">신규 수강생 가입신청</a>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('login_pwd');
        const toggleButton = document.getElementById('toggle_pwd');

        toggleButton.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleButton.style.opacity = '0.4'; 
                toggleButton.title = "비밀번호 숨기기";
            } else {
                passwordInput.type = 'password';
                toggleButton.style.opacity = '1.0'; 
                toggleButton.title = "비밀번호 보기";
            }
        });
    });
    </script>
</body>
</html>