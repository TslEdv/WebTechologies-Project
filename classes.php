<?php
class FeatureSet {
    private $id;
    private $title;
    private $description;
    private $image;

    function __construct($id, $title, $description, $image)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->image = $image;
    }
    public function getId(){
        return $this->id;
    }
    public function getTitle(){
        return $this->title;
    }
    public function getDescription(){
        return $this->description;
    }
    public function getImage(){
        return $this->image;
    }
}
class DataActions {
    static function sanitiseInput($link, $var){
        $var = stripslashes($var);
        $var = htmlentities($var);
        $var = strip_tags($var);
        $var = mysqli_real_escape_string($link, $var);
        return $var;
    }
    static function readFeatures($mysqli, $capacity, $whiteboard, $audio, $projector, $start, $end){ //returns featureSets with required features
        $capacity = intval(self::sanitiseInput($mysqli, $capacity));
        $whiteboard = intval(self::sanitiseInput($mysqli, $whiteboard));
        $audio = intval(self::sanitiseInput($mysqli, $audio));
        $projector = intval(self::sanitiseInput($mysqli, $projector));
        $query = $mysqli->prepare("SELECT DISTINCT F.ID, F.title, F.feature_description, F.image FROM featuresets AS F INNER JOIN 
        (SELECT R.ID, R.room_number, R.feature_ID FROM rooms AS R 
        LEFT JOIN bookings AS B ON R.ID=B.room_ID 
        AND (B.start_date <= ? AND B.end_date >= ?) WHERE B.ID IS NULL) S 
        ON S.feature_ID=F.ID WHERE F.whiteboard>=? AND F.audio>=? AND F.projector>=? AND F.capacity>=?");
        //query to that first selects rooms that have no overlapping bookings, and then matches them with featuresets that have required features
        $query->bind_param("ssiiii", $end->format("Y-m-d H:i:s"), $start->format("Y-m-d H:i:s"), $whiteboard, $audio, $projector, $capacity);
        $query->execute();
        $query->bind_result($id, $title, $description, $image);
        $featureSetArray = array();
        while ($query->fetch()){
            $feature = new FeatureSet($id, $title, $description, $image);
            $featureSetArray[$feature->getId()] = $feature;
        }
        $query->close();
        return $featureSetArray;
    }
    static function readFeatureRooms($mysqli, $featureId, $start, $end){
        $query = $mysqli->prepare("SELECT R.ID, R.room_number FROM rooms AS R 
        LEFT JOIN bookings AS B ON R.ID=B.room_ID 
        AND (B.start_date <= ? AND B.end_date >= ?) WHERE B.ID IS NULL AND R.feature_ID=?");
        $query->bind_param("ssi", $end->format("Y-m-d H:i:s"), $start->format("Y-m-d H:i:s"), $featureId);
        $query->execute();
        $query->bind_result($id, $room_number);
        $numberArray = array();
        while($query->fetch()){
            $numberArray[$id] = $room_number;
        }
        $query->close();
        return $numberArray;
    }
}
?>