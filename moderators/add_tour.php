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
        header( 'Content-Type: text/html; charset=utf-8' );
            echo '<form method="POST"><div id = "content">
                    <div id="details">
                            <table>
                                <tr>
                                    <td><h3><b>Название</b></h3></td>
                                    <td><input type="text" name="name" size="16"  minlength = "1" maxlength = "30"></td>
                                </tr>
                                <tr>
                                    <td><h3><b>Локация</b></h3></td>
                                    <td><input type="text" name="location" size="16"  minlength = "1" maxlength = "30"></td>
                                </tr>
                                <tr>
                                    <td><h3><b>Стоимость</b></h3></td>
                                    <td><input type="number" name="price" size="16" min="1" max="1000000"></td>
                                </tr>
                                <tr>
                                    <td><h3><b>Дата</b></h3></td>
                                    <td><input type="date" name="date" size="16"></td>
                                    
                                </tr>
                                <tr>
                                    <td><h3><b>Контакты</b></h3></td>
                                    <td><input type="text" name="contacts" size="16"  minlength = "1"  maxlength = "30"></td>
                                </tr>
                                <tr>
                                    <td><h3><b>Ссылка на фото</b></h3></td>
                                    <td><input type="text" name="image" size="16"  minlength = "1"></td>
                                </tr>
                                </table>
                                <br><br>
                                    <input type="hidden" name="tour_id">
                                    <button type="submit" name="upd" id="first" style="margin-left: 100px">Создать</button>
                                </div>
                    <div id="details">
                        <h1><b>Описание:</b></h1> 
                        <textarea name="description" id="details"  minlength = "1"></textarea>
                    </div>
                    </form>';
            $hostname = "localhost";
            $username = "f0498365_r_tourism";
            $dbName = "f0498365_r_tourism";
            $password = "2020Pepega!";
            $table = "tours";
            $db = mysqli_connect($hostname, $username, $password, $dbName);
            mysqli_select_db($db,$dbName) or die(mysqli_error($db));
            mysqli_query($db, "SET NAMES utf8");
            if (!empty($_POST['name']) and !empty($_POST['location']) and !empty($_POST['price']) and !empty($_POST['image']) and !empty($_POST['date']) and !empty($_POST['contacts']) and !empty($_POST['description'])) {
                $description = $_POST['description'];
                $tour_name=$_POST['name'];
                $location =$_POST['location'];
                $price =$_POST['price'];
                $date =  $_POST['date'];
                $image = $_POST['image'];
                $contacts = $_POST['contacts'];
                echo $tour_name;
                echo $tour_name;
                echo $tour_name;
                echo $tour_name;
                echo $tour_name;
                mysqli_query($db, "INSERT INTO $table (tour_name, location, description, price, date, image,
                                                            review_count, rate5, rate4, rate3, rate2, rate1, contacts)  
                                                            VALUES ('$tour_name', '$location','$description', '$price',
                                                             '$date', '$image', 0, 0, 0, 0, 0, 0, '$contacts')") or die(mysqli_error($db));
                exit("<meta http-equiv='refresh' content='0; url= /moderators/mod_tours.php'>");
            }
        ?>

        </div>
    </div>
</body>
</html>