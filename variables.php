<?php
session_start();
$str = $_SERVER['QUERY_STRING'];
parse_str($str);

$_SESSION['name'] = $name;
$_SESSION['gender'] = $gender;
$_SESSION['hp'] = $hp;
$_SESSION['gender'] = $gender;
$_SESSION['lat'] = $lat;
$_SESSION['lng'] = $lng;
$_SESSION['beginning'] = $beginning;
$_SESSION['monstersKilled'];

header('Location: https://mapproject-gabekuslansky.c9users.io/'); 

?>