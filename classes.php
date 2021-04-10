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
    static function readFeatures($capacity, $whiteboard, $audio, $projector){ //returns featureSets with required features
        $handle = fopen("data/featureset.csv", "r");
        $featureSetArray = array();
        while (($data = fgetcsv($handle)) !== FALSE){ //reads lines from csv
            $feature = new FeatureSet($data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7]);
            if($feature->getCapacity() >= $capacity){ //capacity requirement check
                if($whiteboard == 1){
                    if($feature->getWhiteboard() != 1){ //checks whiteboard only if we care about it
                        continue;
                    }
                }
                if($audio == 1){
                    if($feature->getAudio() != 1){
                        continue;
                    }
                }
                if($projector == 1){
                    if($feature->getProjector() != 1){
                        continue;
                    }
                }
                $featureSetArray[$feature->getId()] = $feature;
            }
        }
        fclose($handle);
        return $featureSetArray;
    }
    static function readRooms($featureSetArray){
        $handle = fopen("data/rooms.csv", "r");
        $roomArray = array();
        while (($data = fgetcsv($handle)) !== FALSE){
            $room = new Room($data[0], $data[1]);
            foreach($featureSetArray as $feature){
                if($room->getFeatures() == $feature->getId()){
                    $roomArray[$room->getId()] = $room;
                }
            }
        }
        fclose($handle);
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