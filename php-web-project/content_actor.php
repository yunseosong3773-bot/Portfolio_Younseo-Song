
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
<?php

//    error_reporting(E_ALL);
//    ini_set("display_errors", 1);

    include './dbconn.php';

    $act_id=$_GET['id'];

    $query="SELECT * FROM actors where actor_id = '$act_id'";
    //echo $query;
    $result = mysqli_query($connect, $query);
    $row = mysqli_fetch_array($result)

?>

<script>
  function deldata() {
    location.href='./delete_actor.php?id=<? echo $act_id ?>';
  }
</script>

    <center><h2> Actor Data </h2></center>
    <form name="frm_content" method="post" action="update_actor.php?uid=<? echo $act_id; ?>">
      <table align="center" width= "300" border="1" cellspacing="0" cellpadding="5">
      <tr align="center">
        <td bgcolor="#cccccc"> Actor ID </td>
        <td><input type="text" name="actorid" value="<? echo $row['actor_ID']; ?>"></td>
      </tr>
      <tr align="center">
        <td bgcolor="#cccccc"> Password </td>
        <td><input type="text" name="f_name" value="<? echo $row['first_name']; ?>"></td>
      </tr>
      <tr align="center">
        <td bgcolor="#cccccc"> Name </td>
        <td><input type="text" name="l_name" value="<? echo $row['last_name']; ?>"></td>
      </tr>
      <tr align="center">
        <td bgcolor="#cccccc"> Age </td>
        <td><input type="text" name="gender" value="<? echo $row['gender']; ?>"></td>
      </tr>
      <tr align="center">
        <td bgcolor="#cccccc"> Count </td>
        <td><input type="text" name="f_count" value="<? echo $row['film_count']; ?>"></td>
      </tr>
      <tr align="center">
        <td colspan="2" bgcolor="#cccccc">
            <input type="submit" value=" Modify ">
            <input type="button" value=" Delete " OnClick="deldata();">
        </td>
      </tr>
    </form>
