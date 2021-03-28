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

    public function __construct($id, $features)
    {
        $this->id = $id;
        $this->features = $features;
    }
    public function getId(){
        return $this->id;
    }
    public function getFeatures(){
        return $this->features;
    }
}
class Booking {
    public $id;
    public $user;
    public $startDate;
    public $endDate;
    public $roomId;
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
            $booking = new Booking;
            $booking->id = $data[0];
            $booking->startDate = new DateTime($data[1]);
            $booking->endDate = new DateTime($data[2]);
            $booking->roomId = new DateTime($data[3]);
            foreach($roomArray as $room){
                if($booking->roomId == $room->id){
                    if($booking->startDate <= $end && $booking->endDate >= $start){ //checks if requested date overlaps with date in booking, returns true if overlaps
                        $bookingArray[$booking->id] = $booking; //contains bookings that overlap
                    }
                }
            }
        }
        fclose($handle);
        return $bookingArray;
    }
}
?>