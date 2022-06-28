<?php

$db = mysqli_connect('localhost', 'root', '', 'tw');
$animal_name = $_GET['name'];
$user_check_query = "DELETE from animals where `name`='$animal_name' ";
mysqli_query($db, $user_check_query);

header('location:../PHP/search.php');
