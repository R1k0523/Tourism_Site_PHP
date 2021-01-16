<html>
<head>
    <meta charset="utf-8">
    <title>Туризм в России</title>
    <link  rel="stylesheet" href="../styles.css">
</head>
<body>
<div id="content">

    <div><center><h1>Информационно-справочная система "Туризм в России"</h1>
            <h1>Вход для администраторов</h1>
            <br><br>
        </center></div>
    <div>
    <form method = "POST">
        <table id="form">
            <tr> <td><p>Логин:</p></td></tr>
            <tr> <td><input type="text" size = "30" name = "log_form" minlength = "1"/></td></tr>
            <tr> <td><p>Пароль:</p></td></tr>
            <tr> <td><input type="password" size = "30" name = "pass_form" minlength = "1"/></td></tr>
            <br>
            <tr> <td><center><button type="submit" name="pass" id="first">Авторизация</button></center></td></tr>
    </form>
    <?php
    If (isset($_POST['log_form']) && !empty($_POST['log_form']))
    {
        $a_login = $_POST['log_form'];
        $a_password = sha1 ($_POST['pass_form']);
        $hostname = "localhost";
        $username = "f0498365_r_tourism";
        $dbName = "f0498365_r_tourism";
        $password = "2020Pepega!";
        $table = "admins";
        $db = mysqli_connect($hostname,$username,$password,$dbName) or die ("Ошибка подключения 1");
        mysqli_select_db($db, $dbName) or die ("Ошибка подключения 2");
        $result=mysqli_query($db, "SELECT * FROM $table GROUP BY id") or die (mysqli_error());
        $array = mysqli_fetch_array($result);
        $x=True;
        do {
            IF ($a_login == $array['login'] && $a_password == $array['password'])
            {
                session_start();
                $_SESSION['id'] = $array['id'];
                $_SESSION['role'] = 'admin';
                $x=False;
                
                exit("<meta http-equiv='refresh' content='0; url= /admin/user_table.php'>");
                //header("Location: user_table.php");
            }
        }while($array=mysqli_fetch_array($result));
        if ($x) {
            echo '<tr> <td><p style="color: white; background-color: palevioletred; padding: 5px;">Неверный логин или пароль!</p><p>Попробуйте снова</p> </td></tr>';
        }
    } else {
        echo '<tr> <td><p>Введите логин и пароль</p></td></tr>';
    }
    ?>
    <br><tr> <td>
            <form action ="../index.php" method = "post">
                <center><button type="submit" name="menu"  id="first">Вход для пользователя</button></center>
            </form>
        </td> </tr>
    <br>
    <tr> <td>
            <form action ="../moderators/mod_login.php" method = "post">
                <center><button type="submit" name="menu"  id="first">Вход для туроператора</button></center>
            </form>
        </td> </tr>
    </table>
</div>
</div>
</body>
</html>