<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
<html>
<head>
<title>Join Table</title>
</head>
<body>
<center>
  
<BR><BR>

  <h2> Join Table (Roles with actor & movie) </h2>
  <table width= "1200" border="1" cellspacing="0" cellpadding="5">
  <tr align="center">
    <td bgcolor="#cccccc">ActorID</td>
    <td bgcolor="#cccccc">First Name</td>
    <td bgcolor="#cccccc">Last Name</td>
    <td bgcolor="#cccccc">Movie Title</td>
    <td bgcolor="#cccccc">Rank</td>
    <td bgcolor="#cccccc">Role</td>
  </tr>

  <?
  include './dbconn.php';

  $query = "select act.actor_id, act.first_name, act.last_name, mov.name, mov.rank, role from actors act, movies mov, roles where act.actor_id = roles.actor_id and mov.movie_id = roles.movie_id limit 100";

  //echo $query;

  $result = mysqli_query($connect, $query);

  while ($row = mysqli_fetch_array($result)) {
    echo "
    <tr>
      <td><a href='content_actor.php?id=$row[actor_id]'>$row[actor_id]</a></td>
      <td>$row[first_name]</td>
      <td>$row[last_name]</td>
      <td><a href='content_movie.php?id=$row[name]'>$row[name]</td>
      <td>$row[rank]</td>
      <td>$row[role]</td>
    </tr>
    ";
  }

  mysqli_close($connect);
  ?>
</table>


</center>
</body>

</html>
