<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
<html>
<head>
<title>Log in (Sign in)</title>
<script>
  function checkform() {
    if (!document.login_form.user_id.value) {
      alert(' ID was not entered. ');
      document.login_form.user_id.focus();
      return;
    }
    else if (!document.login_form.user_password.value) {
      alert(' Password was not entered. ');
      document.login_form.user_password.focus();
      return;
    }

    document.login_form.submit();
  }
</script>
</head>
<body>
  <form action='./login.php' name='login_form' method='post'>
<br>
<br>
<CENTER> Log in (Sign in) </b></div><br>
<label> ID : </label><input type="text" name="user_id" class="box"/><br>
<label> Password : </label><input type="text" name="user_password" class="box"/></br>

<center><input type="button" value="Log(Sign) in" OnClick="checkform();"/><br />

</form> 
