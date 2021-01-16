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
        $hotel_id = $_POST['tour_id'];
        header( 'Content-Type: text/html; charset=utf-8' );
        $hostname = "localhost";
        $username = "f0498365_r_tourism";
        $dbName = "f0498365_r_tourism";
        $password = "2020Pepega!";
        $table="hotels";
        $db=mysqli_connect($hostname,$username,$password,$dbName) OR DIE("Ошибка подключения");
        mysqli_select_db($db,$dbName) or die(mysqli_error("DB not selected"));
        mysqli_set_charset($db,'utf8');

        $query = "SELECT `description`,`hotel_name`, `address`, `price`, `image`, `tour_id` FROM $table WHERE id = $hotel_id";
        $result = mysqli_query($db,$query) or die(mysqli_error("Failed query"));
        if ($row = mysqli_fetch_array($result)) {
            echo '<form method="POST"><div id = "content">
                    <div id="details">
                            <table>
                                <tr>
                                    <td><h3><b>Название</b></h3></td>
                                    <td><input type="text" name="name" size="16" value="' . $row[1] . '" minlength = "1" maxlength = "30"></td>
                                </tr>
                                <tr>
                                    <td><h3><b>Адрес</b></h3></td>
                                    <td><input type="text" name="address" size="16" value="' . $row[2] . '" minlength = "1" maxlength = "30"></td>
                                </tr>
                                <tr>
                                    <td><h3><b>Стоимость</b></h3></td>
                                    <td><input type="number" name="price" size="16" value="' . $row[3] . '" min="1" max="1000000"></td>
                                </tr>
                                <tr>
                                    <td><h3><b>Ссылка на фото</b></h3></td>
                                    <td><input type="text" name="image" size="16" value="' . $row[4] . '"  minlength = "1" maxlength = "200"></td>
                                </tr>
                                </table>
                                <br><br>
                                    <input type="hidden" name="tour_id" value="' . $hotel_id . '">
                                    <button type="submit" name="upd" id="first" style="margin-left: 100px">Обновить</button>
                                </div>
                    <div id="details">
                        <h1><b>Описание:</b></h1>
                        <textarea name="description" id="details"  minlength = "1">' . $row[0] . '</textarea>
                    </div>';
            $err_image = "'../images/bg.jpg'";
            if (!empty($row[4]))
                echo '
                    <div id="details">
                        <img src="' . $row[4] . '" height="100%"  onerror="this.onerror=null;this.src='.$err_image.';" />
                    </div>';
            echo '
                    </form>';
            $hostname = "localhost";
            $username = "f0498365_r_tourism";
            $dbName = "f0498365_r_tourism";
            $password = "2020Pepega!";
            $table = "hotels";
            $db = mysqli_connect($hostname, $username, $password, $dbName);
            mysqli_select_db($db, $dbName);
            mysqli_query($db, "SET NAMES utf8");
            if (!empty($_POST['name']) and !empty($_POST['address']) and !empty($_POST['price']) and !empty($_POST['image']) and !empty($_POST['description'])) {
                if ($_POST['name'] != $row[1]) {
                    $l = $_POST['name'];
                    $res = mysqli_query($db, "UPDATE $table SET hotel_name = '$l' WHERE id = '$hotel_id' ") or die(mysqli_error($db));
                }
                if ($_POST['address'] != $row[2]) {
                    $l = $_POST['address'];
                    $res = mysqli_query($db, "UPDATE $table SET address = '$l' WHERE id = '$hotel_id' ") or die(mysqli_error($db));
                }
                if ($_POST['price'] != $row[3]) {
                    $l = $_POST['price'];
                    $res = mysqli_query($db, "UPDATE $table SET price = '$l' WHERE id = '$hotel_id' ") or die(mysqli_error($db));
                }
                if ($_POST['image'] != $row[5]) {
                    $l = $_POST['image'];
                    $res = mysqli_query($db, "UPDATE $table SET image = '$l' WHERE id = '$hotel_id' ") or die(mysqli_error($db));
                }
                if ($_POST['description'] != $row[0]) {
                    $l = $_POST['description'];
                    $res = mysqli_query($db, "UPDATE $table SET description = '$l' WHERE id = '$hotel_id' ") or die(mysqli_error($db));
                }
                if ($res == 'true') {
                    echo "<div style=\"font:bold 12px Arial; color:black;\">Информация обновлена!</div>";
                    exit("<meta http-equiv='refresh' content='0; url= /moderators/mod_hotels.php?tour_id=".$row[5]."'>");
                    //header('Location: mod_hotels.php?tour_id='.$row[5]);
                }
            } else {
                echo '<p style="color: white; background-color: palevioletred; padding: 5px">Не все данные заполнены!</p>';
            }
        }
            ?>

        </div>
    </div>
</body>
</html>