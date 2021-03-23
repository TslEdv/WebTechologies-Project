<?php
class Features {
    public $whiteboard;
    public $audio;
    public $projector;
}

class Room {
    public $id;
    public $type;
    public $capacity;
    public $features;
    function __construct($type, $capacity, $features) {
        $this->id = uniqid();
        $this->type = $type;
        $this->capacity = $capacity;
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