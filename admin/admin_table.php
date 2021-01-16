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
            <li><a href="user_table.php">Пользователи</a></li>
            <li><a href="moderator_table.php">Модераторы</a></li>
            <li><a href="admin_table.php">Сис. админы</a></li>
            <li><a href="../logout.php">Выход</a></li>
        </ul>
    </div>
</div>

<body>
<div id = "wrap">

    <content>
        <div id = "content">
            <div id="details">
                <h1>Управление администраторами</h1>
            </div>

            <div id="details">
                <table>

                    <thead>
                    <tr style="background: darkseagreen">
                    <td style="width: 27%">Логин</td>
                    <td style="width: 26%">Имя</td>
                    <td style="width: 26%">Фамилия</td>
                    <td style="width: 20%"></td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $hostname = "localhost";
                    $username = "f0498365_r_tourism";
                    $dbName = "f0498365_r_tourism";
                    $password = "2020Pepega!";
                    $table = "admins";

                    $db = mysqli_connect($hostname,$username,$password,$dbName) or die ("Ошибка подключения 1");
                    mysqli_select_db($db, $dbName) or die ("Ошибка подключения 2");
                    $result=mysqli_query($db, "SELECT id, login, name, surname  FROM $table GROUP BY id") or die (mysqli_error());

                    while($array=mysqli_fetch_array($result)){
                        echo '          <tr>
                                            <td>'.substr($array['login'], 0, 20).'</td>
                                            <td>'.substr($array['name'], 0, 20).'</td>
                                            <td>'.substr($array['surname'], 0, 20).'</td>
                                            <td>
                                            <form action="user_info.php" method="post" id="admin">  
                                                <input type="hidden" name="id" value="'.$array['id'].'"/>
                                                <input type="hidden" name="table" value="admins"/>
                                                <button type="submit" id="table_buttons">Изменить</button>
                                            </form>';

                        if ($array['id'] != $_SESSION['id'])
                            echo '          <form action="delete_user.php" method="post" id="admin">  
                                                <input type="hidden" name="user_id" value="'.$array['id'].'"/>
                                                <input type="hidden" name="table" value="admins"/>
                                                <button type="submit" id="table_buttons">Удалить</button></td>
                                            </form>
                                        </tr>  ';
                    } ;
                    ?>
                    </tbody>
                </table>
            </div>
        </div>

    </content>
</div>
</body>
</html>





