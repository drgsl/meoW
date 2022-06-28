<?php
$db = mysqli_connect('localhost', 'root', '', 'tw');

$firstName= mysqli_real_escape_string($db, $_POST['firstName'] );
$lastName = mysqli_real_escape_string($db, $_POST['lastName']);
$subject = mysqli_real_escape_string($db, $_POST['subject']);


if(mysqli_query($db, "INSERT INTO feedback(firstName, lastName, subject) VALUES('$firstName','$lastName', '$subject')")) {
    echo 'Thank you for your message';
} else {
    echo "Error: ". mysqli_error($db);
}


?>