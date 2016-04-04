<!DOCTYPE html>
<html>
<head>
    <title>Informatie pagina</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="EditURI" type="application/rsd+xml" href="//www.project.cmi.hr.nl/2015_2016/clemob_mt1bd_g/w/api.php?action=rsd" />
    <link href='https://fonts.googleapis.com/css?family=Raleway:500' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body style="background: #e1ffa4; font-family: 'Raleway', sans-serif;">
<div class="name">Interactieve Kinderboerderij</div>


<?php
header("Access-Control-Allow-Origin: *");

$dier = $_GET['dier'];
?>

<a href="index.html" class="back"><img src="img/back.png" /></a>
<div class="title"><?php echo $dier;?><img src="img/<?php echo $dier;?>_img.jpg" style="margin-left:600px;"/></div>
<div id="demo">
</div>
<div id="image"></div>
<script>

    //var playListURL = 'https://en.wikipedia.org/w/api.php?action=query&format=json&prop=extracts&titles=Goat&exintro=1&redirects=1';
    var playListURL = 'http://nl.wikipedia.org/w/api.php?action=opensearch&search=<?= $dier;?>&format=json&callback=wikiCallbackFunction';

    /*$.getJSON(playListURL ,function(data) {
     $.each(data.query.pages, function(i, item) {
     alert(item.extract);

     });
     });*/

    $.ajax(playListURL,{
        dataType: "jsonp",
        success: function( wikiResponse ){
            console.log( wikiResponse[2]);
            //alert( wikiResponse[2]);
            document.getElementById("demo").innerHTML = wikiResponse[2];
        }
    });


</script>
</body>
</html>