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
    $table='hotels';
    $db=mysqli_connect($hostname,$username,$password,$dbName) OR DIE("error");
    mysqli_select_db($db,$dbName) or die(mysqli_error("error"));
    mysqli_set_charset( $db,'utf8' );
    $t = $_POST['tour_id'];
    if (isset($_POST['hotel_id']))
    {
        $h = $_POST['hotel_id'];

        $query ="DELETE FROM $table WHERE id='$h'";
        mysqli_query($db,$query) or die(mysqli_error($db));
    }
    exit("<meta http-equiv='refresh' content='0; url= /moderators/mod_hotels.php?tour_id=".$t."'>");
?>