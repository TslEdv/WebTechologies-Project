<?php
require_once("classes.php");
if($_GET['304'] == 303){
    $features = array_fill_keys(array("whiteboard", "audio", "projector"));
    $features->whiteboard = $_GET['whiteboard'];
    $features->audio = $_GET['audio'];
    $features->projector = $_GET['projector'];
    $room = new Room($_GET['type'], $_GET['capacity'], $features);
    $roomString = $room->id . "," . $room->type . "," . $room->capacity . "," . $features->whiteboard . "," . $features->audio . "," . $features->projector . PHP_EOL;
    file_put_contents("data/rooms.csv", $roomString, FILE_APPEND);
}
else {
    exit("Invalid password");
}
?>