<?php
require_once("classes.php");
if($_GET['304'] == 303){
    $features = new FeatureSet(uniqid(), $_GET['capacity'], $_GET['whiteboard'], $_GET['audio'], $_GET['projector'], $_GET['title'], $_GET['description'], $_GET['image']);
    $featureString = $features->getId() . "," . $features->getCapacity() . "," . $features->getWhiteboard() . "," . $features->getAudio() . "," . $features->getProjector() . "," . $features->getTitle() . "," . $features->getDescription() . "," . $features->getImage() . PHP_EOL;
    file_put_contents("data/featureset.csv", $featureString, FILE_APPEND);
    $room = new Room(uniqid(), $features->getId());
    $roomString = $room->getId() . "," . $room->getFeatures() . PHP_EOL;
    file_put_contents("data/rooms.csv", $roomString, FILE_APPEND);
}
else {
    exit("Invalid password");
}
?>