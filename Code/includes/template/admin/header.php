<?php
session_start();
require_once('../includes/config.php');

$query = mysqli_query($db,"SELECT * FROM `users` WHERE `email` = '".$_SESSION['username']."' LIMIT 1");
$user = mysqli_fetch_assoc($query);
if (($user['admin'] == 0) || empty($user['admin']))
{
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Interactieve kinderboerderij - Beheerderspaneel</title>

    <meta name="description" content="">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IT=edge,chrome=IE8">
    <meta charset='utf-8'>
</head>

<body>