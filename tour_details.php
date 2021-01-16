<?php
    session_start();
    if(!((isset($_SESSION['role']) && $_SESSION['role'] == "user"))){
        exit("<meta http-equiv='refresh' content='0; url= /index.php'>");
}
?>
<html>
<?php
if(isset($_GET['tour_id'])) {
    $this_tour = $_GET['tour_id'];
}
?>
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
        $table="tours";
        $id="id";
        $months = array( 1 => 'Января' , 'Февраля' , 'Маря' , 'Апреля' , 'Мая' , 'Июня' , 'Июля' , 'Августа' , 'Сентября' , 'Октября' , 'Ноября' , 'Декабря' );

        $db=mysqli_connect($hostname,$username,$password,$dbName) OR DIE("Ошибка подключения");
        mysqli_select_db($db,$dbName) or die(mysqli_error("DB not selected"));
        mysqli_set_charset($db,'utf8');

        $query = "SELECT `description`,`tour_name`, `location`, `price`, `date`, `image`,`review_count`, `rate5`, `rate4`, `rate3`, `rate2`, `rate1`,`contacts` FROM $table WHERE id = $this_tour";
        $result = mysqli_query($db,$query) or die(mysqli_error("Failed query"));
        if ($row = mysqli_fetch_array($result)) {
            $day = explode("-", $row[4])[2];
            $month = intval(explode("-", $row[4])[1]);
            $year = explode("-", $row[4])[0];
            if ($row[6] != 0) {
                $rate = round(($row[7] * 5 + $row[8] * 4 + $row[9] * 3 + $row[10] * 2 + $row[11]) / $row[6], 2, PHP_ROUND_HALF_UP);
            } else $rate = 0;
            $err_image = "'../images/noimage.png'";
            echo '<div id="details">
                            <div class="row">
                                <div class="column">
                                    <h1>' . $row[1] .'</h1>
                                    <h3><b>Локация:</b></h3>
                                    <h3>' . $row[2] . '</h3>
                                    <h3><b>Стоимость:</b> ' . $row[3] . ' рублей</h3>
                                    <h3><b>Дата:</b> ' . $day . " " . $months[$month] . " " . $year . '</h3>
                                    <h3><b>Контакты:</b></h3>
                                    <h3>' . $row[12] . '</h3>
                                </div>
                                
                                <div class="column">
                                    <h2 id="details"><b>Оценка:</b> ' . $rate . '</h2>
                                    <div class="reviews">';
                                        for ($i = 5; $i >= 1; $i--) {
                                            echo '<input type="radio" id="star'.$i.'" name="rate" value="'.$i.'" '.(round($rate, 0, PHP_ROUND_HALF_UP) == $i ? "checked" : "").' disabled readonly/>
                                        <label for="star'.$i.'"">'.$i.' stars</label>';
                                        }

                    echo '</div></div>
                                <div class="row">
                                    <div class="column">
                                        <a href="hotels.php?tour='.$this_tour.'">Отели города</a>
                                    </div>
                                    <div class="row">
                                        <div class="column">
                                            <a href="send_review.php?tour='.$this_tour.'">Оставить отзыв</a>
                                        </div>
                                        <div class="column">
                                            <a href="#reviews">Отзывы</a>
                                        </div>
                                    </div>
                                </div>
                                </div></div>
                    <div id="details">
                        <h1><b>Описание:</b></h1>
                        <p>' . $row[0] . '</p>
                    </div>
                    <div id="details">
                        <img src="' . $row[5] . '" onerror="this.onerror=null;this.src='.$err_image.';" />
                    </div>
                    <div id="reviews">
                         <div id="details">
                            <h0><b>Отзывы:</b></h0>
                                <div class="review">
                                    <div class="row">
                                        <div class="column">
                                            <h2 id="details"><b>Оценка:</b> ' . $rate . '</h2>
                                            <div class="reviews">';
                                            for ($i = 5; $i >= 1; $i--) {
                                                echo '<input type="radio" id="star'.$i.'" name="rate1" value="'.$i.'" '.(round($rate, 0, PHP_ROUND_HALF_UP) == $i ? "checked" : "").' disabled readonly/>
                                                                        <label for="star'.$i.'"">'.$i.' stars</label>';
                                            }
                        echo '</div></div><div class="column">
                                <h1><b>Количество оценок:</b></h1>
                                <h3><b>5 звезд:</b>.'.$row[7].'</h3>
                                <h3><b>4 звезды:</b>.'.$row[8].'</h3>
                                <h3><b>3 звезды:</b>.'.$row[9].'</h3>
                                <h3><b>2 звезды:</b>.'.$row[10].'</h3>
                                <h3><b>1 звезда:</b>.'.$row[11].'</h3>
                                </div></div></div>';
                        $table="reviews";
                        $id="id";
                        $months = array( 1 => 'Января' , 'Февраля' , 'Маря' , 'Апреля' , 'Мая' , 'Июня' , 'Июля' , 'Августа' , 'Сентября' , 'Октября' , 'Ноября' , 'Декабря' );

                        $query = "SELECT tour_id,rating, author, text_review, date FROM $table WHERE tour_id = $this_tour ORDER by date";
                        $result = mysqli_query($db,$query) or die(mysqli_error("Failed query"));
                        while ($row = mysqli_fetch_array($result))
                         {
                             $day = explode("-", $row[4])[2];
                             $month = intval(explode("-", $row[4])[1]);
                             $year = explode("-", $row[4])[0];
                             echo '<div class="review">
                                    <div>
                                        <div>
                                            <p><b>Автор:</b> '.$row[2].'</p>
                                            <p><b>Оценка:</b> '.$row[1].'</p>
                                            <p><b>Дата:</b> '.$day." ".$months[$month]." ".$year.'</p>
                                        </div>
                                        <p>'.$row[3].'</p>
                                    </div>
                                </div>';
                         }
                         echo'</div>
                    </div>';
        } else
            exit("<meta http-equiv='refresh' content='0; url= /error404.php'>");
        ?>

        </div>
    </div>
</body>
</html>