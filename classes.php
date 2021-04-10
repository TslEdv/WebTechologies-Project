<?php
class FeatureSet {
    private $id;
    private $capacity;
    private $whiteboard;
    private $audio;
    private $projector;
    private $title;
    private $description;
    private $image;

    function __construct($id, $capacity, $whiteboard, $audio, $projector, $title, $description, $image)
    {
        $this->id = $id;
        $this->capacity = $capacity;
        $this->whiteboard = $whiteboard;
        $this->audio = $audio;
        $this->projector = $projector;
        $this->title = $title;
        $this->description = $description;
        $this->image = $image;
    }
    public function getId(){
        return $this->id;
    }
    public function getCapacity(){
        return $this->capacity;
    }
    public function getWhiteboard(){
        return $this->whiteboard;
    }
    public function getAudio(){
        return $this->audio;
    }
    public function getProjector(){
        return $this->projector;
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

class Room {
    private $id;
    private $features;
    private $number;

    public function __construct($id, $features, $number)
    {
        $this->id = $id;
        $this->features = $features;
        $this->number = $number;
    }
    public function getId(){
        return $this->id;
    }
    public function getFeatures(){
        return $this->features;
    }
    public function getRoom(){
        return $this->number;
    }
}
class Booking {
    private $id;
    private $user;
    private $startDate;
    private $endDate;
    private $roomId;

    public function __construct($id, $user, $startDate, $endDate, $roomId){
        $this->id = $id;
        $this->user = $user;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->roomId = $roomId;
    }
    public function getId(){
        return $this->id;
    }
    public function getUser(){
        return $this->user;
    }
    public function getStartDate(){
        return $this->startDate;
    }
    public function getEndDate(){
        return $this->endDate;
    }
    public function getRoomId(){
        return $this->roomId;
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
    static function readFeatures($capacity, $whiteboard, $audio, $projector){ //returns featureSets with required features
        require_once("connect.db.php");
        $mysqli = new mysqli($db_server, $db_user, $db_password, $db_name);
        $capacity = intval(self::sanitiseInput($mysqli, $capacity));
        $whiteboard = intval(self::sanitiseInput($mysqli, $whiteboard));
        $audio = intval(self::sanitiseInput($mysqli, $audio));
        $projector = intval(self::sanitiseInput($mysqli, $projector));
        $query = $mysqli->prepare("SELECT * FROM featuresets WHERE capacity>=? AND whiteboard>=? AND audio>=? AND projector>=?;");
        $query->bind_param("iiii", $capacity, $whiteboard, $audio, $projector);
        $query->execute();
        $query->bind_result($id, $title, $capacity, $description, $image, $whiteboard, $audio, $projector);
        $featureSetArray = array();
        while ($query->fetch()){
            $feature = new FeatureSet($id, $capacity, $whiteboard, $audio, $projector, $title, $description, $image);
            $featureSetArray[$feature->getId()] = $feature;
        }
        $query->close();
        $mysqli->close();
        return $featureSetArray;
    }
    static function readRooms($featureSetArray){
        require_once("connect.db.php");
        $mysqli = new mysqli($db_server, $db_user, $db_password, $db_name);
        $roomArray = array();
        foreach($featureSetArray as $key=>$feature){
            $key = intval(self::sanitiseInput($mysqli, $key));
            $query = $mysqli->prepare("SELECT * FROM rooms WHERE feature_ID=?;");
            $query->bind_param("i", $key);
            $query->execute();
            $query->bind_result($id, $featureid, $room_number);
            while ($query->fetch()){
                $room = new Room($id, $featureid, $room_number);
                $roomArray[$room->getId()] = $room;
            }
            $query->close();
        }
        $mysqli->close();
        return $roomArray;
    }
    static function readBookedRooms($roomArray, $start, $end){ //reads bookings
        $handle = fopen("data/bookings.csv", "r");
        $bookingArray = array();
        while (($data = fgetcsv($handle)) !== FALSE){
            $booking = new Booking($data[0],"foobar", $data[1], new DateTime($data[2]), new DateTime($data[3]));
            foreach($roomArray as $room){
                if($booking->getRoomId() == $room->getId()){
                    if($booking->getStartDate() <= $end && $booking->getEndDate() >= $start){ //checks if requested date overlaps with date in booking, returns true if overlaps
                        $bookingArray[$booking->getId()] = $booking; //contains bookings that overlap
                    }
                }
            }
        }
        fclose($handle);
        return $bookingArray;
    }
}
?>