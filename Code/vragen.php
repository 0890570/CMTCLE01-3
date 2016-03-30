<?
session_start();
require_once('includes/template/header.php');

$query = "SELECT *
            FROM `vragen`
            INNER JOIN `dier`
            ON `dier`.`id` = `vragen`.`diersoort`
            ";


if (isset ($_POST['diersoort'])) {
    $diersoort = $_POST['diersoort'];
    $query .= "WHERE naam = '$diersoort'
    ";
    echo $diersoort;
}


//if (isset($_POST['diersoort'])) {
//    if ($_POST['diersoort'] == 'geit') {
//        // query to get all white records
//        $query .= "WHERE diersoort='1'";
//        $keuze = "geit";
//    } elseif ($_POST['diersoort'] == 'kip') {
//        // query to get all black records
//        $query .= "WHERE diersoort='2'";
//        $keuze = "kip";
//    } elseif ($_POST['diersoort'] == 'koe') {
//        // query to get all black records
//        $query .= "WHERE diersoort='3'";
//        $keuze = "koe";
//    } elseif ($_POST['diersoort'] == 'schaap') {
//        // query to get all black records
//        $query .= "WHERE diersoort='4";
//        $keuze = "schaap";
//    } elseif ($_POST['diersoort'] == 'varken') {
//        // query to get all black records
//        $query .= "WHERE diersoort='5'";
//        $keuze = "varken";
//    } elseif ($_POST['diersoort'] == 'konijn') {
//        // query to get all black records
//        $query .="WHERE diersoort='6'";
//        $keuze = "konijn";
//    }
//}

$query .= "ORDER BY RAND()
            LIMIT 10";

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

$get_animals = mysqli_query($db, "SELECT * FROM `dier` ORDER BY `id` ASC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Quiz</title>

    <link rel="stylesheet" href="/home/project/2015_2016/clemob_mt1bd_g/css/style.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
</head>



<body>
<script>
    document.getElementByClassName('quiz').style.display='show';
</script>
<p>Klik op de knop om je locatie op te halen</p>

<button onclick="getLocation()">Haal locatie op</button>

<p id="demo"></p>
<p id="error"></p>

Quiz vragen<br />
<div class="quiz" style="display: none; background-image: url(http://bs1.imghost.nu/images/1/98646.jpg); color: white;">
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
<script>

    
        var x = document.getElementById("demo");

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }

    function showPosition(position) {

        voteable = (position.coords.latitude > 50.4047864 && position.coords.latitude < 52.9054003 && position.coords.longitude > 4.4606291 && position.coords.longitude < 8.4918951) ? "WELKOM":"De quiz is niet beschikbaar. U moet zich naar de St.Jobshaven in Rotterdam begeven om de quiz te spelen.";
        console.log(voteable);
        document.getElementById("error").innerHTML = voteable;

        x.innerHTML = "Latitude: " + position.coords.latitude +
            "<br>Longitude: " + position.coords.longitude;

        var str = "U mag door naar de website :)";
        var result = str.link("http://planetcoasterclub.nl/");
        if(voteable == "WELKOM") {
            $(".quiz").show();
            document.getElementByClassName('quiz').style.display='show';
        }
    }

    function showError(error) {
        switch(error.code) {
            case error.PERMISSION_DENIED:
                x.innerHTML = "User denied the request for Geolocation."
                break;
            case error.POSITION_UNAVAILABLE:
                x.innerHTML = "Location information is unavailable."
                break;
            case error.TIMEOUT:
                x.innerHTML = "The request to get user location timed out."
                break;
            case error.UNKNOWN_ERROR:
                x.innerHTML = "An unknown error occurred."
                break;
        }
    }
</script>
<script async defer
        src="https://www.googleapis.com/geolocation/v1/geolocate?key=">
</script>
</body>