<?php
session_start();
if(!((isset($_SESSION['role']) && $_SESSION['role'] == "user"))){
    exit("<meta http-equiv='refresh' content='0; url= /index.php'>");
}
?>
<html>
<head>
	<title>Туризм в России</title>
          <link  rel="stylesheet" href="styles.css">
</head>
  
<body>
    <div id = "wrap">
    <div id = "header">
            <h1>Информационно-справочная система "Туризм в России"</h1>
            <div id = "menu">
                <ul>
                    <li><a href="menu.php">Главная</a></li>
                    <li><a href="tours.php">Туры</a></li>
                    <li><a href="pers_info.php">Профиль</a></li>
                    <li><a href="logout.php">Выход</a></li>
                </ul>
        </div>
    </div>
        
<div id = "content">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="upd" method="POST">
        <?php
        $hostname = "localhost";
        $username = "f0498365_r_tourism";
        $dbName = "f0498365_r_tourism";
        $password = "2020Pepega!";
        $table="users";
        $db=mysqli_connect($hostname,$username,$password,$dbName) OR DIE("Ошибка подключения");
        mysqli_select_db($db,$dbName) or die(mysqli_error("DB not selected"));
        mysqli_set_charset($db,'utf8');
        session_start();
        $id = $_SESSION['id'];
        $query = "SELECT login, name, surname FROM $table WHERE id = $id";
        $result = mysqli_query($db,$query) or die(mysqli_error("Failed query"));
        $array = mysqli_fetch_array($result);
        echo '<h1>Личная информация</h1>
                        <br>
                        <h2>Логин:</h2>
                        <input type="text" name="log" size="16" minlength = "5" maxlength = "20" value="'.$array['login'].'">
                        <h2>Новый пароль:</h2>
                        <input type="password" name="passw" size="16" minlength = "8" maxlength = "20">
                        <h2>Подтвердите пароль:</h2>
                        <input type="password" name="passw_check" size="16" minlength = "8" maxlength = "20">
                        <h2>Имя:</h2>
                        <input type="text" name="name" size="16"  minlength = "1" maxlength = "25" value="'.$array['name'].'">
                         <h2>Фамилия:</h2>
                        <input type="text" name="surname" size="16" value="'.$array['surname'].'" minlength = "1" maxlength = "25">
                        <br><br>
                <input type="submit" name="upd" value="Обновить информацию">'
        ?>
    </form>
       <?php
       $id = $_SESSION['id'];
       $hostname = "localhost";
       $username = "f0498365_r_tourism";
       $dbName = "f0498365_r_tourism";
       $password = "2020Pepega!";
		$table = "users";
		$db=mysqli_connect($hostname,$username,$password,$dbName);
		mysqli_select_db($db, $dbName);
                mysqli_query($db, "SET NAMES utf8");
        if (isset($_POST['log']) or isset($_POST['passw']) or isset($_POST['name']) or isset($_POST['surname']))
            {
                    if (isset($_POST['log']))
                    {
                        $l = $_POST['log'];
                        $res = mysqli_query($db, "UPDATE $table SET login = '$l' WHERE id = '$id' ")or die(mysqli_error($db));

                    }
                    if (isset($_POST['passw']))
                    {
                        if (isset($_POST['passw']) && isset($_POST['passw_check']) && ($_POST['passw'] == $_POST['passw_check'])) {
                            $p = sha1($_POST['passw']);
                            $res = mysqli_query($db, "UPDATE $table SET password = '$p' WHERE id = '$id' ")or die(mysqli_error($db));
                        } else {
                            echo '<p style="color: white; background-color: palevioletred; padding: 5px">Пароли не сопадают или не заполнены до конца!</p>';
                        }
                    }
                    if (isset($_POST['name']))
                    {
                        $n = $_POST['name'];
                        $res = mysqli_query($db, "UPDATE $table SET  name = '$n' WHERE id = '$id' ")or die(mysqli_error($db));
                    }
                    if (isset($_POST['surname']))
                    {
                        $s = $_POST['surname'];
                        $res = mysqli_query($db, "UPDATE $table SET  surname = '$s' WHERE id = '$id' ")or die(mysqli_error($db));
                    }
            if ($res == 'true'){
             echo "<div style=\"font:bold 12px Arial; color:black;\">Информация обновлена!</div>";
                exit("<meta http-equiv='refresh' content='0; url= /pers_info.php'>");
                    }}

	?>
    </div>
    </div>
    </body>
</html>
