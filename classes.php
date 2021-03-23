<?php
class FeatureSet {
    public $id;
    public $capacity;
    public $whiteboard;
    public $audio;
    public $projector;
}

class Room {
    public $id;
    public $features;
}
class Booking {
    public $id;
    public $user;
    public $startDate;
    public $endDate;
    public $roomId;
}
?>