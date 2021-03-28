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
class DataActions {
    static function readFeatures($capacity, $whiteboard, $audio, $projector){ //returns featureSets with required features
        $handle = fopen("data/featureset.csv", "r");
        $featureSetArray = array();
        while (($data = fgetcsv($handle)) !== FALSE){ //reads lines from csv
            $feature = new FeatureSet;
            $feature->id = $data[0];
            $feature->capacity = $data[1]; //sets features to 0 or 1
            $feature->whiteboard = $data[2];
            $feature->audio = $data[3];
            $feature->projector = $data[4];
            if($feature->capacity >= $capacity){ //capacity requirement check
                if($whiteboard == 1){
                    if($feature->whiteboard != 1){ //checks whiteboard only if we care about it
                        continue;
                    }
                }
                if($audio == 1){
                    if($feature->audio != 1){
                        continue;
                    }
                }
                if($projector == 1){
                    if($feature->projector != 1){
                        continue;
                    }
                }
                array_push($featureSetArray, $feature);
            }
        }
        fclose($handle);
        return $featureSetArray;
    }
    static function readRooms($featureSetArray){
        $handle = fopen("data/rooms.csv", "r");
        $roomArray = array();
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE){
            $room = new Room;
            $room->id = $data[0];
            $room->features = $data[1];
            foreach($featureSetArray as $feature){
                if($room->features == $feature->id){
                    $roomArray[$room->id] = $room;
                }
            }
        }
        fclose($handle);
        return $roomArray;
    }
    static function readBookedRooms($roomArray, $start, $end){ //reads bookings
        $handle = fopen("data/bookings.csv", "r");
        $bookingArray = array();
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE){
            $booking = new Booking;
            $booking->id = $data[0];
            $booking->startDate = new DateTime($data[1]);
            $booking->endDate = new DateTime($data[2]);
            $booking->roomId = new DateTime($data[3]);
            foreach($roomArray as $room){
                if($booking->roomId == $room->id){
                    if($booking->startDate <= $end && $booking->endDate >= $start){ //checks if requested date overlaps with date in booking, returns true if overlaps
                        array_push($bookingArray, $booking); //contains bookings that overlap
                    }
                }
            }
        }
        fclose($handle);
        return $bookingArray;
    }
}
?>