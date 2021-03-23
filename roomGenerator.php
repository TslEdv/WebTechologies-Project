<?php
require_once("classes.php");
if($_GET['304'] == 303){
    $features = new FeatureSet;
    $features->id = uniqid();
    $features->capacity = $_GET['capacity'];
    $features->whiteboard = $_GET['whiteboard'];
    $features->audio = $_GET['audio'];
    $features->projector = $_GET['projector'];
    $featureString = $features->id . "," . $features->capacity . "," . $features->whiteboard . "," . $features->audio . "," . $features->projector . PHP_EOL;
    file_put_contents("data/featureset.csv", $featureString, FILE_APPEND);
    $room = new Room($features);
    $room->id = uniqid();
    $roomString = $room->id . "," . $room->features->id . PHP_EOL;
    file_put_contents("data/rooms.csv", $roomString, FILE_APPEND);
}
else {
    exit("Invalid password");
}
?>