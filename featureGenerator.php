<?php
require_once("classes.php");
if($_GET['304'] == 303){
    require_once("connect.db.php");
    $mysqli = new mysqli($db_server, $db_user, $db_password, $db_name);
    $query = $mysqli->prepare("INSERT INTO featuresets (title, room_description, image,  capacity, whiteboard, audio, projector) VALUES (?, ?, ?, ?, ? ?);");
    $query->bind_param("ssiiii", $_GET['title'], $_GET['description'],  $_GET['image'], $_GET['capacity'], $_GET['whiteboard'], $_GET['audio'], $_GET['projector']);
    $query->execute();
    $lastId = $mysqli->insert_id;
    $query = $mysqli->prepare("INSERT INTO rooms (feature_ID, room_number) VALUES ?, ?");
    $query->bind_param("is", $lastId, $_GET['roomnumber']);
    $query->close();
    $mysqli->close();
}
else {
    exit("Invalid password");
}
?>