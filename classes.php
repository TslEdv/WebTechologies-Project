<?php
class FeatureSet {
    public $id;
    public $whiteboard;
    public $audio;
    public $projector;
    public $capacity;
    function __construct(){
        $this->id = uniqid();
    }
}

class Room {
    public $id;
    public $features;
    function __construct($features) {
        $this->id = uniqid();
        $this->features = $features;
    }
}
class Booking {
    public $id;
    public $user;
    public $startDate;
    public $endDate;
    public $roomId;
}
?>