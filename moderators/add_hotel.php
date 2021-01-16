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
            <li class="right"><a href="../logout.php">Выход</a></li>
        </ul>
    </div>
</div>
<body>
<div id = "wrap">
        <?php
        $tour_id = intval($_POST['tour_id']);
        header( 'Content-Type: text/html; charset=utf-8' );
        $hostname = "localhost";
        $username = "f0498365_r_tourism";
        $dbName = "f0498365_r_tourism";
        $password = "2020Pepega!";
        $table="hotels";
        $db=mysqli_connect($hostname,$username,$password,$dbName) OR DIE("Ошибка подключения");
        mysqli_select_db($db,$dbName) or die(mysqli_error("DB not selected"));
        mysqli_set_charset($db,'utf8');
        echo '<form method="POST"><div id = "content">
                <div id="details">
                        <table>
                            <tr>
                                <td><h3><b>Название</b></h3></td>
                                <td><input type="text" name="name" size="16" minlength = "1" maxlength = "30"></td>
                            </tr>
                            <tr>
                                <td><h3><b>Адрес</b></h3></td>
                                <td><input type="text" name="address" size="16"  minlength = "1"></td>
                            </tr>
                            <tr>
                                <td><h3><b>Стоимость</b></h3></td>
                                <td><input type="number" name="price" size="16" min="1" max="1000000"></td>
                            </tr>
                            <tr>
                                <td><h3><b>Ссылка на фото</b></h3></td>
                                <td><input type="text" name="image" size="16"  minlength = "1" maxlength = "200"></td>
                            </tr>
                            </table>
                            <br><br>
                                <input type="hidden" name="tour_id" value="'.$tour_id.'">
                                <button type="submit" name="upd" id="first" style="margin-left: 100px">Создать</button>
                            </div>
                <div id="details">
                    <h1><b>Описание:</b></h1>
                    <textarea name="description" id="details"  minlength = "1"></textarea>
                </div>';
            if (!empty($row[4]))
                echo '<div id="details">
                        <img src="' . $row[4] . '" height="100%"/>
                    </div></form>';
            $hostname = "localhost";
            $username = "f0498365_r_tourism";
            $dbName = "f0498365_r_tourism";
            $password = "2020Pepega!";
            $table = "hotels";
            $db = mysqli_connect($hostname, $username, $password, $dbName);
            mysqli_select_db($db, $dbName);
            mysqli_query($db, "SET NAMES utf8");
            if ((!empty($_POST['name'])) and (!empty($_POST['address'])) and (!empty($_POST['price'])) and (!empty($_POST['image'])) and (!empty($_POST['description']))) {
                $description = $_POST['description'];
                $hotel_name=$_POST['name'];
                $address =$_POST['address'];
                $price =$_POST['price'];
                $image = $_POST['image'];
                mysqli_query($db, "INSERT INTO $table(tour_id,description,hotel_name,address,price,image) VALUES ('$tour_id','$description','$hotel_name','$address','$price','$image')") or die(mysqli_error($db));
                exit("<meta http-equiv='refresh' content='0; url= /moderators/mod_hotels.php?tour_id=".$_POST['tour_id']."'>");
            }
            ?>

        </div>
    </div>
</body>
</html>