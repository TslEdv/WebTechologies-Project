<?php
require_once("classes.php");
if($_GET['304'] == 303){
    require_once("connect.db.php");
    $mysqli = new mysqli($db_server, $db_user, $db_password, $db_name);
    $features = new FeatureSet(uniqid(), $_GET['capacity'], $_GET['whiteboard'], $_GET['audio'], $_GET['projector'], $_GET['title'], $_GET['description'], $_GET['image']);
    $query = $mysqli->prepare("INSERT INTO featuresets (title, room_description, capacity, whiteboard, audio, projector) VALUES ?, ?, ?, ?, ? ?;");
    $query->bind_param()
    file_put_contents("data/featureset.csv", $featureString, FILE_APPEND);
    $room = new Room(uniqid(), $features->getId());
    $roomString = $room->getId() . "," . $room->getFeatures() . PHP_EOL;
    file_put_contents("data/rooms.csv", $roomString, FILE_APPEND);
}
else {
    exit("Invalid password");
}
?>