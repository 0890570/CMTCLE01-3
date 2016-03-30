<?php
$host = 'localhost';
$user = 'prj_2015_2016_clemob_mt1bd_g';
$password = 'eifieruv';
$database = 'prj_2015_2016_clemob_mt1bd_g';

//Create connection
$db = mysqli_connect($host, $user, $password, $database) or die("Error: " . mysqli_connect_error());

//Close connection
//mysqli_close($db);
?>