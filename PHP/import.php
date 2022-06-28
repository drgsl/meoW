<?php

$db = mysqli_connect('localhost', 'root', '', 'tw');

$file = $_GET["myfile"];
$ext = pathinfo($file, PATHINFO_EXTENSION);
if ($ext == 'json') //json
{
    $jsondata = file_get_contents('../import/' . $file);
    $data = json_decode($jsondata, true);
    $name = $data['name'];
    $animal_check_query = "SELECT name FROM animals WHERE name='$name' LIMIT 1";
    $result = mysqli_query($db, $animal_check_query);
    $animal = mysqli_fetch_assoc($result);
    if (!$animal) {
        $region = $data['region'];
        $habitat= $data['habitat'];
        $tip = $data['tip'];
        $conservation = $data['conservation'];
        $image = $data['image'];
        $description = $data['description'];

        $inj = $db->prepare("INSERT INTO animals (name, region, habitat, tip, conservation, image, description)  VALUES (?, ?, ?, ?, ?, ?, ?)");
        $inj->bind_param("sssssss", $name, $region, $habitat, $tip, $conservation, $image, $description);
        $inj->execute();
        header("location:search.php");

      
    } else echo "Animal already exists";
} 

else //xml
{
    $data = simplexml_load_file('../import/' . $file) or die("Error: Cannot create XML object");

    $name = $data->name;
    $animal_check_query = "SELECT name FROM animals WHERE name='$name' LIMIT 1";
    $result = mysqli_query($db, $animal_check_query);
    $animal = mysqli_fetch_assoc($result);
    if (!$animal) {
        $region = $data->region;
        $habitat = $data->habitat;
        $tip = $data->tip;
        $conservation = $data->conservation;
        $description = $data->description;
        $image = $data->image;

        $inj = $db->prepare("INSERT INTO animals (name, region, habitat, tip, conservation, image, description)  VALUES (?, ?, ?, ?, ?, ?, ?");
        $inj->bind_param("sssssss", $name, $region, $habitat, $tip, $conservation, $image, $description);
        $inj->execute();
        header("location:animals.php");
    } else echo "Animal already exists";

}