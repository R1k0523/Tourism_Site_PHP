<html>
<head>
    <title>Туризм в России</title>
    <link  rel="stylesheet" href="styles.css">
</head>

<body>
<div id = "wrap">

    <div id = "content">
        <div><center><h1>Информационно-справочная система "Туризм в России"</h1>
            <h1>Регистрация</h1>
            <br><br>
        </center></div>
        <form method="POST">
            <center>
                <table id="form">
                    <tr><td><p>Логин:</td></tr>
                    <tr><td><input type="text" name = "login" size = "30" minlength = "5" maxlength = "20"></td></tr>
                    <tr><td><p>Пароль:</p></td></tr>
                    <tr><td><input type="password" name = "password" size = "30" minlength = "8" maxlength = "20"></td></tr>
                    <tr><td><p>Подтвердите пароль:</p></td></tr>
                    <tr><td><input type="password" name = "password_check" size = "30" minlength = "8" maxlength = "20"></td></tr>
            </center>
            <center><p>
                    <tr><td><br><br><button type="submit"  id="first" name = "Submit">Подтвердить</button></td></tr>
                </p></center>
        </form>
        <tr><td>
        <form action ="index.php" method = "post">
            <center>
                <button type="submit" name = "index"  id="first">К странице входа</button>
            </center>
        </form>
        
            </td></tr>
        <?php

        if (!empty($_POST['login']) && !empty($_POST['password']) && ($_POST['password'] == $_POST['password_check']))
        {
            $login = $_POST['login'];
            $pass = sha1 ($_POST['password']);
            $hostname = "localhost";
            $username = "f0498365_r_tourism";
            $dbName = "f0498365_r_tourism";
            $password = "2020Pepega!";
            $table = "users";

            $db = mysqli_connect($hostname,$username,$password,$dbName) or die("Ошибка подключения");
            mysqli_select_db($db, $dbName) or die (mysqli_error($db));
            mysqli_query($db, "INSERT INTO $table(login, password)  VALUES ('$login','$pass')") or die ('<p style="color: white; background-color: palevioletred; padding: 5px">Пользователь с таким именем уже существует!</p>');
            echo "<i>Пользователь добавлен</i>";
            exit("<meta http-equiv='refresh' content='0; url= /index.php'>");
        }
        ?>
        </table>
    </div>
</body>
</html>