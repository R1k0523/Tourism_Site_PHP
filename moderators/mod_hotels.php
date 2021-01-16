<?php
session_start();
if(!((isset($_SESSION['role']) && $_SESSION['role'] == "moderator"))){
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
    <div id = "menu">
        <ul>
            <li><a href="mod_tours.php">Туры</a></li>
            <li class="right"><a href="../logout.php" >Выход</a></li>
        </ul>
    </div>
</div>

<body>
<div id = "wrap">

    <div id = "content">
        <?php

        header( 'Content-Type: text/html; charset=utf-8' );
        $hostname = "localhost";
        $username = "f0498365_r_tourism";
        $dbName = "f0498365_r_tourism";
        $password = "2020Pepega!";
        $table="hotels";
        $months = array( 1 => 'Января' , 'Февраля' , 'Маря' , 'Апреля' , 'Мая' , 'Июня' , 'Июля' , 'Августа' , 'Сентября' , 'Октября' , 'Ноября' , 'Декабря' );

        $db=mysqli_connect($hostname,$username,$password,$dbName) OR DIE("Ошибка подключения");
        mysqli_select_db($db,$dbName) or die(mysqli_error("DB not selected"));
        mysqli_set_charset($db,'utf8');
        if (isset($_GET['tour_id'])) {
            $id = $_GET['tour_id'];
            $query = "SELECT `id`, `hotel_name`, `address`, `price`, `image`, `description` FROM $table WHERE `tour_id`=$id";
        } else {
            $query = "SELECT `id`, `hotel_name`, `address`, `price`, `image`, `description` FROM $table";
        }

        $result = mysqli_query($db,$query) or die(mysqli_error("Failed query"));
        $pages = $result->num_rows;
        $i = 10;
        if (isset($_GET['page'])) {
            for ($j = 0; ($j < ($_GET['page']-1)*10); $j++) {
                if (! ($row = mysqli_fetch_array($result))) {
                    break;
                }
            }
        }

        echo '
        <form action="add_hotel.php" method="post" >
        <div id="tour" style="box-shadow: 0 0 0 0 rgba(0, 0, 0, 0);">
            <input type="hidden" name="tour_id" value="'.$id.'"/>
            <button type="submit">Добавить отель</button>
        </div>
        </form>';
        while (($row = mysqli_fetch_array($result)) && $i > 0)
        {
            $err_image = "'../images/bg.jpg'";
            echo '
                        <div id="hotel">
                            <div><br>
                                <h1>' . $row[1] . '</h1>
                                <br><br>
                                <h2><b>Адрес:</b> ' . $row[2] . '</h2>
                                <h2><b>Стоимость:</b> ' . $row[3] . ' рублей/сутки</h2>
                            </div>
                            <img src="' . $row[4] . '" onerror="this.onerror=null;this.src='.$err_image.';" />
                            <p><b>Описание:</b></p>
                            <p>' . $row[5] . '</p>
                            <div id="tour" style="box-shadow: 0 0 0 0 rgba(0, 0, 0, 0);">
                            <form action="hotel_info.php" method="post">  
                                                <input type="hidden" name="tour_id" value="'.$row[0].'"/>
                                                <button type="submit">Изменить</button>
                            </form>
                            <form action="delete_hotel.php" method="post">  
                                                <input type="hidden" name="hotel_id" value="'.$row[0].'"/>
                                                <input type="hidden" name="tour_id" value="'.$id.'"/>
                                                <button type="submit">Удалить</button>
                            </form>
                            </div>
                        </div>
                    ';
            $i--;
        }
        echo '<table id="page_nav">
                <tr>';
        for ($j = 1; ($j <= (($pages-1)/10+1)); $j++) {
            if (isset($_GET['tour'])) {
                echo '<td><a href="mod_hotels.php?tour=' . $_GET['tour'] . '&page=' . $j . '">' . $j . '</a></td>';
            } else {
                echo '<td><a href="mod_hotels.php?page=' . $j . '">' . $j . '</a></td>';
            }
            if (($j%10) == 0)
                echo '</tr><tr>';
        }
        ?>
    </div>
</body>
</html>