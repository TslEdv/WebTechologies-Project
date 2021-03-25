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
    static function readFeatures($capacity, $whiteboard, $projector){
        $handle = fopen("data/featureset.csv", "r");
        $featureSetArray = array();
        while ($data = fgetcsv($handle) !== FALSE){
            $feature = new FeatureSet;
            $feature->id = $data[0];
            $feature->capacity = intval($data[1]);
            $feature->whiteboard = intval($data[2]);
            $feature->audio = intval($data[3]);
            $feature->projector = intval($data[4]);
            if($feature->capacity >= $capacity){
                if($whiteboard == 1){
                    if($feature->whiteboard !== 1){
                        continue;
                    }
                }
                if($audio == 1){
                    if($feature->audio !== 1){
                        continue;
                    }
                }
                if($projector == 1){
                    if($feature->projector !== 1){
                        continue;
                    }
                }
                array_push($featureSetArray, $feature);
            }
        }
        fclose($handle);
        return $featureSetArray;
    }
}
?>