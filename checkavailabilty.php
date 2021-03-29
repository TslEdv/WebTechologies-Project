<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Check availability</title>
        <link rel="shortcut icon" type="image/jpg" href="img/favicon.png" />
        <link rel="stylesheet" href="styles/main.css">
        <link href='https://fonts.googleapis.com/css?family=RocknRoll One' rel='stylesheet'>
     </head>
     <body>
     <header>
         <h1>Room booking</h1>
         <ul id="login-menu">
         <?php
         if(isset($_COOKIE['PHPSESSID'])){
            echo "<li><a href='logout.php'>Log out</a></li>";
         } else{
            echo "<li><a href='login.html'>Login</a></li>";
            echo "<li><a href='register.html'>Register</a></li>";
         }
         ?>
         </ul>
      </header>
      <nav>
         <ul>
            <li><a href="index.php">Home page</a></li>
            <li><a href="overview.php">Overview</a></li>
            <li><a href="bookingform.php">Booking</a></li>
            <li><a href="contact.php">Contact</a></li>
         </ul>
      </nav>
        <article>
        <?php
        require_once("classes.php");
        if(isset($_GET['submit'])){
            if(isset($_GET['start-date']) && isset($_GET['end-date']) && isset($_GET['capacity'])){
                $date1 = new DateTime($_GET['start-date']);
                $date2 = new DateTime($_GET['end-date']);
                if($date1 === false){ //input validation
                    exit("Please check Your date! Incorrect start date!");
                }
                else if($date2 === false){
                    exit("Please check Your date! Incorrect end date!");
                }
                else if($date2 < $date1){
                    exit("Please check Your date! Starting date cannot be further than ending date!");
                }
                else if($date1 < date("Y-m-d")){
                    exit("Please check Your date! Starting date cannot be in the past!");
                }
                else if(!filter_var($_GET['capacity'], FILTER_VALIDATE_INT) === 0 || !filter_var($_GET['capacity'], FILTER_VALIDATE_INT)){ //checks if capacity is integer
                    exit("Capacity must be a number (integer)!");
                }
                $capacity = intval($_GET['capacity']) * 2; //multiplied required capacity by 2 due to covid
                $whiteboard = intval(isset($_GET['whiteboard'])); //converts required features into 0 or 1
                $audio = intval(isset($_GET['audio']));
                $projector = intval(isset($_GET['projector']));
                $featureSetArray = DataActions::readFeatures($capacity, $whiteboard, $audio, $projector);
                $roomArray = DataActions::readRooms($featureSetArray);
                $bookingArray = DataActions::readBookedRooms($roomArray, $date1, $date2);
                foreach($bookingArray as $booking){ //removes rooms that are booked
                    unset($roomArray[$booking->getRoomId()]);
                }
                foreach($featureSetArray as $feature){ //removes featuresets with 0 available rooms
                    $featureRoomCount = 0;
                    foreach($roomArray as $room){
                        if($room->featureId == $feature->getId()){
                            $featureRoomCount++;
                        }
                    }
                    if($featureRoomCount == 0){
                        unset($featureSetArray[$feature->getId()]);
                    }
                }
                echo "<ul>";
                foreach($featureSetArray as $feature){
                    echo "<li>";
                    echo "<div class='room'>";
                    echo "<h3>Title</h3>";
                    echo "<p>description</p>";
                    echo "<p>available rooms: </p>";
                    echo "<form action='booking.php' method='POST'>";
                    echo "<button name='book' value='' type='submit'>Book</button>";
                    echo "</form>";
                    echo "</div>";
                    echo "</li>";
                }
                echo "</ul>";
            }
        }
        ?>
        </article>
    </body>
 </html>