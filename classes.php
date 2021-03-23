<?php
class Room {
    public $id;
    public $type;
    public $capacity;
    public $features = array_fill_keys(array("whiteboard", "audio", "projector"));
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