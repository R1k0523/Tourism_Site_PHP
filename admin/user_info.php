<?php
session_start();
if(!((isset($_SESSION['role']) && $_SESSION['role'] == "admin"))){
    exit("<meta http-equiv='refresh' content='0; url= ../menu.php'>");
}
?>
<html>
<head>
    <title>Туризм в России</title>
    <link  rel="stylesheet" href="../styles.css">
</head>

<div id = "header">
    <h1>Информационно-справочная система "Туризм в России"</h1>
    <div id = "menu" >
        <ul>
            <li><a href="user_table.php">Главная</a></li>
            <li><a href="moderator_table.php">Модераторы</a></li>
            <li><a href="admin_table.php">Пользователи</a></li>
            <li><a href="logout.php">Выход</a></li>
        </ul>
    </div>
</div>


<div id = "content">
    <form name="upd" method="POST">
        <?php

        $hostname = "localhost";
        $username = "f0498365_r_tourism";
        $dbName = "f0498365_r_tourism";
        $password = "2020Pepega!";
        $table=$_POST['table'];
        $db=mysqli_connect($hostname,$username,$password,$dbName) OR DIE("Ошибка подключения");
        mysqli_select_db($db,$dbName) or die(mysqli_error("DB not selected"));
        mysqli_set_charset($db,'utf8');
        session_start();
        $id = $_POST['id'];
        $query = "SELECT login, name, surname FROM $table WHERE id = $id";
        $result = mysqli_query($db,$query) or die(mysqli_error("Failed query"));
        $array = mysqli_fetch_array($result);
        echo '<h1>Личная информация</h1>
                        <br>
                        <h2>Логин:</h2>
                        <input type="text" name="log" size="16" value="'.$array['login'].'" minlength = "5" maxlength = "20">
                        <h2>Пароль:</h2>
                        <input type="password" name="passw" size="16"  minlength = "8" maxlength = "20">
                        <h2>Подтвердите пароль:</h2>
                        <input type="password" name="passw_check" size="16"  minlength = "8" maxlength = "20">
                        <h2>Имя:</h2>
                        <input type="text" name="name" size="16" value="'.$array['name'].'"  minlength = "1" maxlength = "25">
                         <h2>Фамилия:</h2>
                        <input type="text" name="surname" size="16" value="'.$array['surname'].'"  minlength = "1" maxlength = "25">
                        <input type="hidden" name="id" value="'.$id.'">
                        <input type="hidden" name="table" value="'.$table.'">
                        <br><br>
                <input type="submit" name="upd" value="Обновить информацию">'
        ?>
    </form>
       <?php
       $id = $_POST['id'];

       $hostname = "localhost";
        $username = "f0498365_r_tourism";
        $dbName = "f0498365_r_tourism";
        $password = "2020Pepega!";
       $table=$_POST['table'];
		$db=mysqli_connect($hostname,$username,$password,$dbName);
		mysqli_select_db($db, $dbName);
            mysqli_query($db, "SET NAMES utf8");
        if (!empty($_POST['log']) or !empty($_POST['passw']) or !empty($_POST['name']) or !empty($_POST['surname']))
            {
                if (!empty($_POST['log']))
                {
                    $l = $_POST['log'];
                    $res = mysqli_query($db, "UPDATE $table SET login = '$l' WHERE id = '$id' ")or die(mysqli_error($db));
                    

                } else {
                    echo '<p style="color: white; background-color: palevioletred; padding: 5px">Логин пуст!</p>';
                }
                if (!empty($_POST['passw']))
                {
                     if  (($_POST['passw'] == $_POST['passw_check']) && (strlen($_POST['passw']) > 7)) {
                        $p = sha1($_POST['passw']);
                        $res = mysqli_query($db, "UPDATE $table SET password = '$p' WHERE id = '$id' ")or die(mysqli_error($db));
                     }else {
                        echo '<p style="color: white; background-color: palevioletred; padding: 5px">Пароли не сопадают или длина пароля меньше 8 символов!</p>';
                    }
                } 
                if (!empty($_POST['name']))
                {
                    $n = $_POST['name'];
                    $res = mysqli_query($db, "UPDATE $table SET  name = '$n' WHERE id = '$id' ")or die(mysqli_error($db));
                }
                if (!empty($_POST['surname']))
                {
                    $s = $_POST['surname'];
                    $res = mysqli_query($db, "UPDATE $table SET  surname = '$s' WHERE id = '$id' ")or die(mysqli_error($db));
                }
                if ($res == 'true'){
                        echo "<div style=\"font:bold 12px Arial; color:black;\">Информация обновлена!".$id."</div>";
                        exit("<meta http-equiv='refresh' content='0; url= /admin/".(substr($table, 0, -1))."_table.php'>");
                        //header('Location: '.(substr($table, 0, -1)).'_table.php');
                }
                    
            }

	?>
    </div>
    </div>
    </body>
</html>
