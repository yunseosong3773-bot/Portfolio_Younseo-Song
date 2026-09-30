<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
<html>
<head>
<title>DB Input/Output Test</title>
<script>
  function checkform() {
    if (!document.review_table.action_id.value) {
      alert(' ID was not entered. ');
      document.review_table.action_id.focus();
      return;
    }
    else if (!document.review_table.first_name.value) {
      alert(' Password was not entered. ');
      document.review_table.first_name.focus();
      return;
    }
    else if (!document.review_table.last_name.value) {
      alert(' Name was not entered. ');
      document.review_table.last_name.focus();
      return;
    }
    else if (!document.review_table.gender.value) {
      alert(' Age was not entered. . ');
      document.review_table.gender.focus();
      return;
    }

    else if (!document.review_table.count.value) {
      alert(' Age was not entered. . ');
      document.review_table.count.focus();
      return;
    }

    document.review_table.submit();
  }

  function goLoginform() {
    location.href='./join_table.php';
  }
</script>
</head>
<body>
<center>
  <form action='./post_actor.php' name='review_table' method='post'>
<br>
<br>
<b>Action Table Input </b></div><br>
  <label> Action ID : </label><input type="text" name="action_id" class="box"/></br>
  <label> FIrst Name : </label><input type="text" name="first_name" class="box"/></br>
  <label> Last Name : </label><input type="text" name="last_name" class="box"/></br>
  <label> Gender : </label><input type="text" name="gender" class="box"/></br>
  <label> Film Count : </label><input type="text" name="count" class="box"/></br>
  
  <input type="button" value="Insert to DB" OnClick="checkform();"/>
  <input type="button" value="Join Table" OnClick="goLoginform();"/><br /> 
</form>
<BR><BR>

  <h2> Actor Table </h2>
  <table width= "1200" border="1" cellspacing="0" cellpadding="5">
  <tr align="center">
    <td bgcolor="#cccccc">ActorID</td>
    <td bgcolor="#cccccc">First Name</td>
    <td bgcolor="#cccccc">Last Name</td>
    <td bgcolor="#cccccc">Gender</td>
    <td bgcolor="#cccccc">Count</td>
  </tr>

  <?
  include './dbconn.php';

  $query="SELECT * from actors limit 10";
  // echo $query;
  $result = mysqli_query($connect, $query);

  while ($row = mysqli_fetch_array($result)) {
    echo "
    <tr>
      <td><a href='content_actor.php?id=$row[actor_ID]'>$row[actor_ID]</a></td>
      <td>$row[first_name]</td>
      <td>$row[last_name]</td>
      <td>$row[gender]</td>
      <td>$row[film_count]</td>
    </tr>
    ";
  }

  mysqli_close($connect);
  ?>
</table>


<BR><BR>

  <h2> Director Table </h2>
  <table width= "1200" border="1" cellspacing="0" cellpadding="5">
  <tr align="center">
    <td bgcolor="#cccccc">DirectorID</td>
    <td bgcolor="#cccccc">First Name</td>
    <td bgcolor="#cccccc">Last Name</td>
  </tr>

  <?
  include './dbconn.php';

  $query="SELECT * from directors limit 10";
  // echo $query;
  $result = mysqli_query($connect, $query);

  while ($row = mysqli_fetch_array($result)) {
    echo "
    <tr>
      <td><a href='content.php?id=$row[director_ID]'>$row[director_ID]</a></td>
      <td>$row[first_name]</td>
      <td>$row[last_name]</td>
    </tr>
    ";
  }

  mysqli_close($connect);
  ?>
</table>




<BR><BR>

  <h2> Movie Table </h2>
  <table width= "1200" border="1" cellspacing="0" cellpadding="5">
  <tr align="center">
    <td bgcolor="#cccccc">MovieID</td>
    <td bgcolor="#cccccc">Movie Title</td>
    <td bgcolor="#cccccc">Year</td>
    <td bgcolor="#cccccc">Rank</td>
  </tr>

  <?
  include './dbconn.php';

  $query="SELECT * from movies limit 10";
  // echo $query;
  $result = mysqli_query($connect, $query);

  while ($row = mysqli_fetch_array($result)) {
    echo "
    <tr>
      <td><a href='content.php?id=$row[movie_ID]'>$row[movie_ID]</a></td>
      <td>$row[name]</td>
      <td>$row[year]</td>
      <td>$row[rank]</td>
    </tr>
    ";
  }

  mysqli_close($connect);
  ?>
</table>

</center>
</body>

</html>
