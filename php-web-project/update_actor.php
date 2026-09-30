<?php

//    error_reporting(E_ALL);
//    ini_set("display_errors", 1); 

    include './dbconn.php';

    $aid=$_GET['uid'];
    $actid=$_POST['actorid'];
    $actfname=$_POST['f_name'];
    $actlname=$_POST['l_name'];
    $actgender=$_POST['gender'];
    $filmcount=$_POST['f_count'];

    $query="UPDATE actors SET actor_ID = '$actid', first_name = '$actfname', last_name = '$actlname', gender = '$actgender', film_count = '$filmcount' where actor_ID = '$aid'";
    echo $query;
    mysqli_query($connect, $query);

    echo"
    <script>
    location.href='./main.php';
    </script>
    ";

 ?>
