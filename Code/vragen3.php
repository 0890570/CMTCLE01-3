<?
session_start();
require_once('includes/config.php');

//Query voor de server
$query = "SELECT *
            FROM `vragen`
            INNER JOIN `dier`
            ON `dier`.`id` = `vragen`.`diersoort`
            ";

//Als er is gefiltert dan moet er op het specifieke diersoort gefiltert worden
if (isset ($_POST['diersoort'])) {
    $diersoort = $_POST['diersoort'];
    $query .= "WHERE naam = '$diersoort'
    ";
    echo $diersoort;
}

//Random volgorde voor de query
$query .= "ORDER BY RAND()
            LIMIT 10";

//Notificatie of de vraag goed/fout is
if (isset($_POST['quiz-vragen']) && !empty($_POST['quiz-vragen'])) {
    $radio_value = $_POST["radio"];
    if ($radio_value == "correct_antwoord") {
        echo "<p style='color:green; font-weight: bold; '>"."Het antwoord is goed";
    }
    elseif ($radio_value == "fout_antwoord_1") {
        echo "<p style='color:red; font-weight: bold;'>"."Het antwoord is fout";
    }
    elseif ($radio_value == "fout_antwoord_2") {
        echo "<p style='color:red; font-weight: bold;'>"."Het antwoord is fout";
    }
}
$result = mysqli_query($db, $query);

//Query voor de dieren die gebruikt wordt in het filter
$get_animals = mysqli_query($db, "SELECT * FROM `dier` ORDER BY `id` ASC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Quiz</title>
    <link rel="stylesheet" type="text/css" href="css/quiz.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
</head>



<body>

<p id="demo"></p>
<p id="error"></p>

Quiz vragen<br />
<div class="quiz">

    <!--Formulier voor het dieren filter-->
    <form action="vragen.php" method="post" name ='diersoorten'>
        <select name="diersoort">
            <?php
            while($animal = mysqli_fetch_assoc($get_animals)){?>
                <option name="diersoort" value="<?= $animal['naam'];?>"><?= $animal['naam'];?></option>
            <?php }
            ?>
        </select>
        <input type="submit" value="Zoeken">
    </form>

    <!--Quiz vragen formulier-->
    <form action="vragen.php" method="post" name='quiz-vragen'>
        <?php while($row = mysqli_fetch_array($result)) {?>
                <b>Vraag: </b> <?=$row['vraag']?><br />
                <b>Diersoort: </b> <?=$row['naam']?><br />
                <input type="radio" name="radio" value="correct_antwoord">
                <label for="correct_antwoord"><?=$row['correct_antwoord']?></label><br>

                <input type="radio" name="radio" value="fout_antwoord_1">
                <label for="fout_antwoord_1"><?=$row['fout_antwoord_1']?></label><br>

                <input type="radio" name="radio" value="fout_antwoord_2">
                <label for="fout_antwoord_2"><?=$row['fout_antwoord_2']?></label><br>
                <input type="submit" value="Voer in" name="quiz-vragen"><br />
                <hr>
        <?php } ?>
    </form>
</div>

<!--Geolocation API-->
<script src="geolocation.js"></script>
</body>
