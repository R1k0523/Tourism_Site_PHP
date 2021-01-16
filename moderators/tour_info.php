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
    <h1>Информационно-справочная система "Туризм в России"а</h1>
    <div id = "menu">
        <ul>
            <li><a href="mod_tours.php">Туры</a></li>
            <li class="right"><a href="../logout.php">Выход</a></li>
        </ul>
    </div>
</div>

<body>
<div id = "wrap">
        <?php
        $this_tour = $_POST['tour_id'];
        header( 'Content-Type: text/html; charset=utf-8' );
        $hostname = "localhost";
        $username = "f0498365_r_tourism";
        $dbName = "f0498365_r_tourism";
        $password = "2020Pepega!";
        $table="tours";
        $db=mysqli_connect($hostname,$username,$password,$dbName) OR DIE("Ошибка подключения");
        mysqli_select_db($db,$dbName) or die(mysqli_error("DB not selected"));
        mysqli_set_charset($db,'utf8');

        $query = "SELECT `description`,`tour_name`, `location`, `price`, `date`, `image`,`review_count`, `rate5`, `rate4`, `rate3`, `rate2`, `rate1`, `contacts` FROM $table WHERE id = $this_tour";
        $result = mysqli_query($db,$query) or die(mysqli_error("Failed query"));
        if ($row = mysqli_fetch_array($result)) {
            if ($row[6] != 0) {
                $rate = round(($row[7] * 5 + $row[8] * 4 + $row[9] * 3 + $row[10] * 2 + $row[11]) / $row[6], 2, PHP_ROUND_HALF_UP);
            } else $rate = 0;
            $err_image = "'../images/noimage.png'";
            echo '<form method="POST"><div id = "content">
                    <div id="details">
                            <table>
                                <tr>
                                    <td><h3><b>Название</b></h3></td>
                                    <td><input type="text" name="name" size="16" value="'. $row[1] .'"  minlength = "1" maxlength = "30"></td>
                                </tr>
                                <tr>
                                    <td><h3><b>Локация</b></h3></td>
                                    <td><input type="text" name="location" size="16" value="'. $row[2] .'"  minlength = "1" maxlength = "30"></td>
                                </tr>
                                <tr>
                                    <td><h3><b>Стоимость</b></h3></td>
                                    <td><input type="number" name="price" size="16" value="'. $row[3] .'" min="1" max="1000000"></td>
                                </tr>
                                <tr>
                                    <td><h3><b>Дата</b></h3></td>
                                    <td><input type="date" name="date" size="16" value="' . $row[4]. '" min="2020-01-01" max="2030-12-31"></td>
                                    
                                </tr>
                                <tr>
                                    <td><h3><b>Контакты</b></h3></td>
                                    <td><input type="text" name="contacts" size="16" value="'. $row[12] .'"  minlength = "1"  maxlength = "30"></td>
                                </tr>
                                <tr>
                                    <td><h3><b>Ссылка на фото</b></h3></td>
                                    <td><input type="text" name="image" size="16" value="'. $row[5] .'"  minlength = "1"></td>
                                </tr>
                                <tr>
                                    <td><h3><b>Оценка</b></h3></td>
                                    <td><h3 style="color: black; padding-bottom: 10px; padding-top: 10px; padding-left: 30px"><b>'. $rate .'</b></h3></td>
                                </tr>
                                </table>
                                <br><br>
                                    <input type="hidden" name="tour_id" value="'.$this_tour.'">
                                    <a href="mod_hotels.php?tour_id='.$this_tour.'">Управление отелями</a>
                                    <button type="submit" name="upd" id="first" style="margin-left: 100px">Обновить</button>
                                </div>
                    <div id="details">
                        <h1><b>Описание:</b></h1>
                        <textarea name="description" id="details"  minlength = "1">' . $row[0] . '</textarea>
                    </div>
                    <div id="details">
                        <img src="' . $row[5] . '" onerror="this.onerror=null;this.src='.$err_image.';" />
                    </div>
                    </form>';
            $hostname = "localhost";
            $username = "f0498365_r_tourism";
            $dbName = "f0498365_r_tourism";
            $password = "2020Pepega!";
            $db = mysqli_connect($hostname, $username, $password, $dbName);
            mysqli_select_db($db, $dbName);
            mysqli_query($db, "SET NAMES utf8");
            if (!empty($_POST['name']) and !empty($_POST['location']) and !empty($_POST['price']) and !empty($_POST['image']) and !empty($_POST['date']) and !empty($_POST['contacts']) and !empty($_POST['description'])) {
                if ($_POST['name'] != $row[1]) {
                    $l = $_POST['name'];
                    $res = mysqli_query($db, "UPDATE $table SET tour_name = '$l' WHERE id = '$this_tour' ") or die(mysqli_error($db));
                }
                if ($_POST['location'] != $row[2]) {
                    $l = $_POST['location'];
                    $res = mysqli_query($db, "UPDATE $table SET location = '$l' WHERE id = '$this_tour' ") or die(mysqli_error($db));
                }
                if ($_POST['price'] != $row[3]) {
                    $l = $_POST['price'];
                    $res = mysqli_query($db, "UPDATE $table SET price = '$l' WHERE id = '$this_tour' ") or die(mysqli_error($db));
                }
                if ($_POST['date'] != $row[4]) {
                    $l = $_POST['date'];
                    $res = mysqli_query($db, "UPDATE $table SET date = '$l' WHERE id = '$this_tour' ") or die(mysqli_error($db));
                }
                if ($_POST['contacts'] != $row[12]) {
                    $l = $_POST['contacts'];
                    $res = mysqli_query($db, "UPDATE $table SET contacts = '$l' WHERE id = '$this_tour' ") or die(mysqli_error($db));
                }
                if ($_POST['image'] != $row[5]) {
                    $l = $_POST['image'];
                    $res = mysqli_query($db, "UPDATE $table SET image = '$l' WHERE id = '$this_tour' ") or die(mysqli_error($db));
                }
                if ($_POST['description'] != $row[0]) {
                    $l = $_POST['description'];
                    $res = mysqli_query($db, "UPDATE $table SET description = '$l' WHERE id = '$this_tour' ") or die(mysqli_error($db));
                }
                if ($res == 'true'){
                    echo "<div style=\"font:bold 12px Arial; color:black;\">Информация обновлена!</div>";
                    exit("<meta http-equiv='refresh' content='0; url= /moderators/mod_tours.php'>");
                    //header('Location: mod_tours.php');
                }
            } 
            echo '<div id="reviews">
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
        } else exit("<meta http-equiv='refresh' content='0; url= /error/404.php'>");
        ?>

        </div>
    </div>
</body>
</html>