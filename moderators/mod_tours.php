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
            <form action="add_tour.php" method="post">
                <div id="tour" style="box-shadow: 0 0 0 0 rgba(0, 0, 0, 0);">

                <button type="submit">Добавить Тур</button>
                </div>
            </form>
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

            $query = "SELECT `id`, `tour_name`, `location`, `price`, `date`, `image` FROM $table";
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
           while (($row = mysqli_fetch_array($result)) && $i > 0)
            {
                $day = explode("-", $row[4])[2];
                $month = intval(explode("-", $row[4])[1]);
                $year = explode("-", $row[4])[0];
                $err_image = "'../images/bg.jpg'";
                echo '<div id="tour">
                        <div>
                            <h1>'.$row[1].'</h1>
                            <p><b>Локация:</b> '.$row[2].'</p>
                            <p><b>Стоимость:</b> '.$row[3].' рублей</p>
                            <p><b>Дата:</b> '.$day." ".$months[$month]." ".$year.'</p>
                            <form action="tour_info.php" method="post">  
                                                <input type="hidden" name="tour_id" value="'.$row[0].'"/>
                                                <button type="submit">Изменить</button>
                            </form>
                            <form action="delete_tour.php" method="post">  
                                                <input type="hidden" name="tour_id" value="'.$row[0].'"/>
                                                <button type="submit">Удалить</button>
                            </form>
                        </div>
                        <img src="' . $row[5] . '" onerror="this.onerror=null;this.src='.$err_image.';" />
                    </div>';
                $i--;
            }
           echo '<table id="page_nav">
                <tr>';
           for ($j = 1; ($j <= (($pages-1)/10+1)); $j++) {
                   echo '<td><a href="mod_tours.php?page=' . $j . '">' . $j . '</a></td>';
           }
           echo '</tr>';
            ?>
	</div>	
	</body>
</html>