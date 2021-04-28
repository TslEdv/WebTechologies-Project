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
        $query->bind_param("ssiiii", $start->format("Y-m-d H:i:s"), $end->format("Y-m-d H:i:s"), $whiteboard, $audio, $projector, $capacity);
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
    static function readRooms($mysqli, $featureSetArray){
        if($mysqli->connect_error){
            die($mysqli->connect_error);
        }
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
        return $roomArray;
    }
    static function readFeatureRooms($mysqli, $featureId, $roomArray){
        $query = $mysqli->prepare("SELECT ID, room_number FROM rooms WHERE feature_ID=?");
        $query->bind_param("i", $featureId);
        $query->execute();
        $query->bind_result($id, $room_number);
        $numberArray = array();
        while($query->fetch()){
            if(array_key_exists($id, $roomArray)){
                $numberArray[$id] = $room_number;
            }
        }
        $query->close();
        return $numberArray;
    }
    static function readBookedRooms($mysqli, $roomArray, $start, $end){ //reads bookings
        $query = $mysqli->prepare("SELECT * FROM bookings;");
        $query->execute();
        $query->bind_result($id, $roomid, $userid, $startDate, $endDate);
        $bookingArray = array();
        while ($query->fetch()){
            $booking = new Booking($id,$userid, new DateTime($startDate), new DateTime($endDate), $roomid);
            foreach($roomArray as $room){
                if($booking->getRoomId() == $room->getId()){
                    if($booking->getStartDate() <= $end && $booking->getEndDate() >= $start){ //checks if requested date overlaps with date in booking, returns true if overlaps
                        $bookingArray[$booking->getId()] = $booking; //contains bookings that overlap
                    }
                }
            }
        }
        $query->close();
        return $bookingArray;
    }
}
?>