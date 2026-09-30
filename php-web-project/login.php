<?
// error_reporting(E_ALL); 
// ini_set("display_errors", 1);

  include './dbconn.php';

  $id = $_POST['user_id'];
  $pwd = $_POST['user_password'];

  $query="SELECT * from info where id = '$id'";
  //echo $query;
  $result = mysqli_query($connect, $query);

  $num = mysqli_num_rows($result);

  if (!$num) {
?>
  <script>
    alert('There is no such ID.\nPlease sign up first..');
    location.href='./post.php';
  </script>
<?
  } else {
    echo (" Welcome <H1>Mr./Ms. $id. </H1>");
  }

mysqli_close($connect);
?>
