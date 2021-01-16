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
if (isset($_POST['table']) and isset($_POST['login']) and isset($_POST['password']) and isset($_POST['name']) and isset($_POST['surname'])) {
    $table=$_POST['table'];
    $login=$_POST['login'];
    $pass=$_POST['password'];
    $name=$_POST['name'];
    $surname=$_POST['surname'];
    $db=mysqli_connect($hostname,$username,$password,$dbName) OR DIE("CON ERROR");
    mysqli_select_db($db,$dbName) or die(mysqli_error("error"));
    mysqli_set_charset( $db,'utf8' );

    $query = "SELECT login FROM $table";
    $result = mysqli_query($db,$query) or die(mysqli_error("error"));

    if (isset($login) && isset($pass) && isset($name) && isset($surname))
    {

        $query ="INSERT INTO $table(login, password, name, surname)  VALUES ('$login','$pass','$name','$surname')";
        mysqli_query($db,$query) or die(mysqli_error($db));
        exit("<meta http-equiv='refresh' content='0; url= /admin/".(substr($table, 0, -1))."_table.php'>");
        //header('Location: '.(substr($table, 0, -1)).'_table.php');
    }
} else
?>