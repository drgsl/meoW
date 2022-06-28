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

        //echo $data['name'];
    } else echo "Species already exists";
} 

else //xml
{
    $animalinfo = simplexml_load_file('../XML_JSON/' . $file) or die("Error: Cannot create XML object");

    $name = $animalinfo->name;
    $animal_check_query = "SELECT name FROM animals WHERE name='$name' LIMIT 1";
    $result = mysqli_query($db, $animal_check_query);
    $animal = mysqli_fetch_assoc($result);
    if (!$animal) {
        $region = $animalinfo->region;
        $habitat = $animalinfo->habitat;
        $tip = $animalinfo->tip;
        $conservation = $animalinfo->conservation;
        $description = $animalinfo->description;
        $image = $animalinfo->image;

        $inj = $db->prepare("INSERT INTO animals (name, region, habitat, tip, conservation, image, description)  VALUES (?, ?, ?, ?, ?, ?, ?");
        $inj->bind_param("sssssssssss", $name, $region, $habitat, $tip, $conservation, $image, $description);
        $inj->execute();
        header("location:animals.php");
    } else echo "Species already exists";

}