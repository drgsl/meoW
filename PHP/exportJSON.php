<?php

$db = mysqli_connect('localhost', 'root', '', 'tw');
$animal_name = $_GET['name'];
echo $animal_name;
$user_check_query = "SELECT name ,description FROM animals where name='$animal_name'";
$result = mysqli_query($db, $user_check_query);
$animal = mysqli_fetch_assoc($result);
echo "da";
$a = '../XML_JSON/' . $animal['name'] . 'Exp.json';

file_put_contents($a, json_encode($animal, JSON_PRETTY_PRINT));

header('Content-Type: application/json');
header('Content-Disposition: attachment; filename="'.$animal['name'].'Exp.json"');
header('Content-Length: '. filesize($a));
readfile($a);
