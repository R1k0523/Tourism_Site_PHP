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

        session_start();
        $months = array( 1 => 'Января' , 'Февраля' , 'Маря' , 'Апреля' , 'Мая' , 'Июня' , 'Июля' , 'Августа' , 'Сентября' , 'Октября' , 'Ноября' , 'Декабря' );

        $db=mysqli_connect($hostname,$username,$password,$dbName) OR DIE("Ошибка подключения");
        mysqli_select_db($db,$dbName) or die(mysqli_error("DB not selected"));
        mysqli_set_charset($db,'utf8');
        if (isset($_GET['tour'])) {
            $id = $_GET['tour'];
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
        $err_image = "'images/bg.jpg'";
        $is_empty = true;
        while (($row = mysqli_fetch_array($result)) && $i > 0)
        {
            echo '<div id="hotel">
                        <div><br>
                            <h1>' . $row[1] . '</h1>
                            <br><br>
                            <h2><b>Адрес:</b> ' . $row[2] . '</h2>
                            <h2><b>Стоимость:</b> ' . $row[3] . ' рублей/сутки</h2>
                        </div>
                        <img src="' . $row[4] . '" onerror="this.onerror=null;this.src='.$err_image.';" />
                        <p><b>Описание:</b></p>
                        <p>' . $row[5] . '</p>
                    </div>';
            $i--;
            $is_empty = false;
        }
        if ($is_empty) {
            echo '<h1>Ни один отель еще не сотрудничает с этим туром. Заходите позднее.</h1>';
        }
        echo '<table id="page_nav">
                <tr>';
        for ($j = 1; ($j <= (($pages-1)/10+1)); $j++) {
                if (isset($_GET['tour'])) {
                    echo '<td><a href="http://f0498365.xsph.ru/hotels.php?tour=' . $_GET['tour'] . '&page=' . $j . '">' . $j . '</a></td>';
                } else {
                    echo '<td><a href="http://f0498365.xsph.ru/hotels.php?page=' . $j . '">' . $j . '</a></td>';
                }
                if (($j%10) == 0)
                    echo '</tr><tr>';
            }
        ?>
    </div>
</body>
</html>