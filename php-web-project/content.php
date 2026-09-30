
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
<?php

//    error_reporting(E_ALL);
//    ini_set("display_errors", 1);

    include './dbconn.php';

    $cid=$_GET['id'];

    $query="SELECT * FROM info where id = '$cid'";
    //echo $query;
    $result = mysqli_query($connect, $query);
    $row = mysqli_fetch_array($result)

?>

<script>
  function deldata() {
    location.href='./delete.php?id=<? echo $cid ?>';
  }
</script>

    <center><h2> Entered Data </h2></center>
    <form name="frm_content" method="post" action="update.php?uid=<? echo $cid; ?>">
      <table align="center" width= "300" border="1" cellspacing="0" cellpadding="5">
      <tr align="center">
        <td bgcolor="#cccccc"> ID </td>
        <td><input type="text" name="custid" value="<? echo $row['id']; ?>"></td>
      </tr>
      <tr align="center">
        <td bgcolor="#cccccc"> Password </td>
        <td><input type="text" name="custpwd" value="<? echo $row['pwd']; ?>"></td>
      </tr>
      <tr align="center">
        <td bgcolor="#cccccc"> Name </td>
        <td><input type="text" name="custname" value="<? echo $row['name']; ?>"></td>
      </tr>
      <tr align="center">
        <td bgcolor="#cccccc"> Age </td>
        <td><input type="text" name="custage" value="<? echo $row['age']; ?>"></td>
      </tr>
      <tr align="center">
        <td colspan="2" bgcolor="#cccccc">
            <input type="submit" value=" Modify ">
            <input type="button" value=" Delete " OnClick="deldata();">
        </td>
      </tr>
    </form>
