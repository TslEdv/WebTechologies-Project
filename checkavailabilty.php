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
                $date2 = DateTime::createFromFormat('Y-m-dTH%3i', $_GET['end-date']); //converts date strings to dates
                $date1 = DateTime::createFromFormat('Y-m-dTH%3i', $_GET['start-date']);
                if($date1 === false){ //input validation
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
                else if(!filter_var($_GET['capacity'], FILTER_VALIDATE_INT) === 0 || !filter_var($_GET['capacity'], FILTER_VALIDATE_INT)){ //checks if capacity is integer
                    exit("Capacity must be a number (integer)!");
                }
                $capacity = intval($_GET['capacity']) * 2; //multiplied required capacity by 2 due to covid
                $whiteboard = intval(isset($_GET['whiteboard'])); //converts required features into 0 or 1
                $audio = intval(isset($_GET['audio']));
                $projector = intval(isset($_GET['projector']));
                $featureSetArray = DataActions::readFeatures($capacity, $whiteboard, $audio, $projector);
                $roomArray = DataActions::readRooms($featureSetArray);
                $bookingArray = DataActions::readBookings($roomArray, $date1, $date2);
            }
        }
        ?>
        </article>
    </body>
 </html>