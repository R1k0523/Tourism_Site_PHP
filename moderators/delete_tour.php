<?php
session_start();
if(!((isset($_SESSION['role']) && $_SESSION['role'] == "moderator"))){
    exit("<meta http-equiv='refresh' content='0; url= ../menu.php'>");
}
?>

<?php
    header( 'Content-Type: text/html; charset=utf-8' );
    $hostname = "localhost";
    $username = "f0498365_r_tourism";
    $dbName = "f0498365_r_tourism";
    $password = "2020Pepega!";
    $table='tours';
    $table2='hotels';
    $db=mysqli_connect($hostname,$username,$password,$dbName) OR DIE("CON ERROR ");
    mysqli_select_db($db,$dbName) or die(mysqli_error("error"));
    mysqli_set_charset( $db,'utf8' );
    if (isset($_POST['tour_id']))
    {
        $t = $_POST['tour_id'];

        $query ="DELETE FROM $table WHERE id='$t'";
        mysqli_query($db,$query) or die(mysqli_error($db));
        $query ="DELETE FROM $table2 WHERE tour_id='$t'";
        mysqli_query($db,$query) or die(mysqli_error($db));
    }
    exit("<meta http-equiv='refresh' content='0; url= /moderators/mod_tours.php'>");
?>