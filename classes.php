<?php
class Room {
    public $id;
    public $type;
    public $features = array_fill_keys(array("whiteboard", "audio", "projector"));
}
class Booking {
    public $id;
    public $user;
    public $startDate;
    public $endDate;
    public $roomId;
}
?>