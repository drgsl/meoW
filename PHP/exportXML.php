<?php

$db = mysqli_connect('localhost', 'root', '', 'tw');
$animal_name = $_GET['name'];
$user_check_query = "SELECT * FROM animals where `name`='$animal_name' ";
$result = mysqli_query($db, $user_check_query);
$animal = mysqli_fetch_assoc($result);

//template-ul pt xml
$xml = '<?xml version="1.0"?> 
<animal>
<name>' . $animal['name'] . '</name>
<description>' . $animal['description'] . '</description>
<conservation>' . $animal['conservation'] . '</conservation>
<path>' . $animal['image'] . '</path>
</animal>';

//creearea xml-ului
$dom = new DOMDocument();
$dom->preserveWhiteSpace = false;
$dom->formatOutput = TRUE;
$dom->loadXML($xml);
$a = '../XML_JSON/' . $animal['name'] . 'Exp.xml'; //exportam in folder-ul XML_JSON
$dom->save($a);

header('Content-Type: application/xml');
header('Content-Disposition: attachment; filename="'.$animal['name'].'Exp.xml"');
header('Content-Length: '. filesize($a));

readfile($a);

//nu uita sa stergi path ul la sfarsit

