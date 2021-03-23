<?php
if(isset($_GET['submit'])){
    if(isset($_GET['start-date']) && isset($_GET['end-date']) && isset($_GET['capacity'])){
        $date2 = DateTime::createFromFormat('Y-m-d', $_GET['end-date']);
        $date1 = DateTime::createFromFormat('Y-m-d', $_GET['start-date']);
        if($date1 === false){
            exit("Please check Your date!");
        }
        else if($date2 === false){
            exit("Please check Your date!");
        }
        else if($date2 < $date1){
            exit("Please check Your date");
        }
        else if(!filter_var($_GET['capacity'], FILTER_VALIDATE_INT) === 0 || !filter_var($_GET['capacity'], FILTER_VALIDATE_INT)){
            exit("Wrong input!");
        }
    }
}
?>