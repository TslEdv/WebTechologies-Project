<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Contact & Feedback</title>
        <link rel="shortcut icon" type="image/jpg" href="img/favicon.png" />
        <link rel="stylesheet" href="styles/main.css">
        <link href='https://fonts.googleapis.com/css?family=RocknRoll One' rel='stylesheet'>
     </head>
     <body>
        <header>
           <h1>Room booking</h1>
           <ul id="login-menu">
              <li><a href="login.html">Login</a></li>
              <li><a href="register.html">Register</a></li>
           </ul>
        </header>
        <nav>
           <ul>
              <li><a href="index.html">Home page</a></li>
              <li><a href="overview.html">Overview</a></li>
              <li><a href="booking.html">Booking</a></li>
              <li><a href="contact.html">Contact</a></li>
           </ul>
        </nav>
        <article>
        <?php
        require_once("classes.php");
        if(isset($_GET['submit'])){
            if(isset($_GET['start-date']) && isset($_GET['end-date']) && isset($_GET['capacity'])){
                $date2 = DateTime::createFromFormat('Y-m-dTH%3i', $_GET['end-date']);
                $date1 = DateTime::createFromFormat('Y-m-dTH%3i', $_GET['start-date']);
                if($date1 === false){
                    exit("Please check Your date! Incorrect start date!");
                }
                else if($date2 === false){
                    exit("Please check Your date! Incorrect end date!");
                }
                else if($date2 < $date1){
                    exit("Please check Your date! Starting date cannot be further than ending date!");
                }
                else if($_GET['start-date'] < date("Y-m-d")){
                    exit("Please check Your date! Starting date cannot be in the past!");
                }
                else if(!filter_var($_GET['capacity'], FILTER_VALIDATE_INT) === 0 || !filter_var($_GET['capacity'], FILTER_VALIDATE_INT)){
                    exit("Capacity must be a number (integer)!");
                }
                $handle = fopen("data/featureset.csv", "r");
                $featureSetArray = array();
                while ($data = fgetcsv($handle) !== FALSE){
                    $feature = new FeatureSet;
                    $feature->id = $data[0];
                    $feature->capacity = $data[1];
                    $feature->whiteboard = $data[2];
                    $feature->audio = $data[3];
                    $feature->audio = $data[4];
                    array_push($featureSetArray, $feature);
                }
                fclose($handle);
                $handle = fopen("data/rooms.csv", "r");
                $roomtArray = array();
                while ($data = fgetcsv($handle) !== FALSE){
                    $room = new Room;
                    $room->id = $data[0];
                    $room->features = $data[1];
                }
                fclose($handle);
            }
        }
        ?>
        </article>
    </body>
 </html>