<?php

//    error_reporting(E_ALL);
//    ini_set("display_errors", 1); 

    include './dbconn.php';

    $actid=$_POST['action_id'];
    $actfname=$_POST['first_name'];
    $actlname=$_POST['last_name'];
    $actgender=$_POST['gender'];
    $filmcount=$_POST['count'];

    $query="INSERT into actors values($actid,'$actfname','$actlname','$actgender',$filmcount)";
    echo $query;
    mysqli_query($connect, $query);

    echo"
    <script>
    location.href='./main.php';
    </script>
    ";

 ?>
