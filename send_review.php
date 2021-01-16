<?php
session_start();
if(!((isset($_SESSION['role']) && $_SESSION['role'] == "user"))){
    exit("<meta http-equiv='refresh' content='0; url= /index.php'>");
}
?>

<?php
if(isset($_GET['tour_id'])) {
    $this_tour = $_GET['tour_id'];
    header('Content-Type: text/html; charset=utf-8');
    $hostname = "localhost";
    $username = "f0498365_r_tourism";
    $dbName = "f0498365_r_tourism";
    $password = "2020Pepega!";
    $table = "tours";
    $id = "id";
    $db = mysqli_connect($hostname, $username, $password, $dbName) or die("Ошибка подключения");
    mysqli_select_db($db, $dbName) or die(mysqli_error("DB not selected"));
    mysqli_set_charset($db, 'utf8');

    $query = "SELECT `description` FROM $table WHERE id = $this_tour";
    $result = mysqli_query($db, $query) or die(mysqli_error("Failed query"));
    if ($row = mysqli_fetch_array($result)) {
    }
}
?>
<html>
<head>
    <title>Туризм в России</title>
    <link  rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

    <div id = "content" class="review_form" >
        <form action="" name="addman" class="review_form" method="POST">
            <h2>Имя:</h2> <input type="text" name="name" size="25"  minlength="1" maxlength="20"> <br><br>
            <h2>Отзыв:</h2><textarea type="text" name="review"  minlength="1"></textarea><br><br>
            <h2>Oценка:</h2>
            <div class="reviews">
                <div class="rate">
                    <?php
                    for ($i = 1; $i < 6; $i++) {
                        echo '<input type="radio" id="star'.$i.'" name="rate" value="'.$i.'" title="'.$i.'"/>
                                <label for="star'.$i.'""> </label>';
                    }
                    ?>
                </div>
            </div>
            <br>
            <br>
            <input name="submit"  type="submit" name="Добавить отзыв">
        </form>
        <?php
        session_start();
        if (!empty($_POST['name']) && !empty($_POST['review'])&& !empty($_POST['rate']))
        {

            $hostname = "localhost";
            $username = "f0498365_r_tourism";
            $dbName = "f0498365_r_tourism";
            $password = "2020Pepega!";
            $table = "reviews";

            $rate = abs($_POST['rate']-6);
            $user_id = $_SESSION['id'];
            $tour_id = $_GET['tour'];
            $name = $_POST['name'];
            $text = $_POST['review'];
            $date = date("y-m-d");
            $db = mysqli_connect($hostname,$username,$password,$dbName) or die("Ошибка подключения");
            mysqli_select_db($db, $dbName) or die (mysqli_error($db));
            mysqli_query($db, "INSERT INTO $table(user_id, tour_id, rating, author, text_review, date)  VALUES ('$user_id','$tour_id','$rate','$name','$text', '$date')") or die(mysqli_error($db));
            $table = "tours";
            mysqli_query($db, "UPDATE tours SET review_count = review_count+1, rate".$rate." = rate".$rate."+1  WHERE id = $tour_id") or die (mysqli_error($db));
            //header('Location: tour_details.php?tour_id='.$tour_id);
            exit("<meta http-equiv='refresh' content='0; url= /tour_details.php?tour_id=".$tour_id."'>");

        } else {

        }
        ?>
    </div>
</div>
</body>
</html>