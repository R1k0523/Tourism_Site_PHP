<?php
session_start();
if(!((isset($_SESSION['role']) && $_SESSION['role'] == "admin"))){
    exit("<meta http-equiv='refresh' content='0; url= ../menu.php'>");
}
?>

<?php
    header( 'Content-Type: text/html; charset=utf-8' );
    $hostname = "localhost";
    $username = "f0498365_r_tourism";
    $dbName = "f0498365_r_tourism";
    $password = "2020Pepega!";
    $table=$_POST['table'];
    $db=mysqli_connect($hostname,$username,$password,$dbName) OR DIE("CON ERROR ");
    mysqli_select_db($db,$dbName) or die(mysqli_error("error"));
    mysqli_set_charset( $db,'utf8' );

    $query = "SELECT login FROM $table";
    $result = mysqli_query($db,$query) or die(mysqli_error("error"));

    if (isset($_POST['user_id']))
    {
        $u = $_POST['user_id'];

        $query ="DELETE FROM $table WHERE id='$u'";
        mysqli_query($db,$query) or die(mysqli_error($db));
    }
    exit("<meta http-equiv='refresh' content='0; url= /admin/".(substr($table, 0, -1))."_table.php'>");
    //header('Location: '.(substr($table, 0, -1)).'_table.php');
?>