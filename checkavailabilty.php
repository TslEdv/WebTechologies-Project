<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Check availability</title>
    <link rel="shortcut icon" type="image/jpg" href="img/favicon.png" />
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/checkavailability.css">
    <link rel="stylesheet" href="styles/modalimages.css">
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=RocknRoll+One&display=swap" rel="stylesheet">
    <script src="scripts/logout.js" async></script>
    <script src="scripts/images.js" async></script>
</head>

<body>
    <header>
        <h1>Room booking</h1>
        <ul id="login-menu">
            <?php
            session_name("PP_Table");
            session_start();
            if (isset($_SESSION['username'])) {
                echo "<li><a onclick='logout()'>Log out</a></li>";
            } else {
                echo "<li><a href='login.html'>Login</a></li>";
                echo "<li><a href='register.html'>Register</a></li>";
            }
            ?>
        </ul>
    </header>
    <nav>
        <ul>
            <?php
            if (isset($_SESSION['username'])) {
                echo "<li><a href='index.php'>Home page</a></li>
               <li><a href='overview.php'>Overview</a></li>
               <li><a href='bookingform.php'>Booking</a></li>
               <li><a href='contact.php'>Contact</a></li>
               <li><a href='mybooking.php'>My bookings</a></li>";
            } else {
                echo "<li><a href='index.php'>Home page</a></li>
               <li><a href='overview.php'>Overview</a></li>
               <li><a href='bookingform.php'>Booking</a></li>
               <li><a href='contact.php'>Contact</a></li>";
            }
            ?>
        </ul>
    </nav>
    <article>
        <?php
        require_once("classes.php");
        require_once("connect.db.php");
        if (isset($_GET['submit'])) {
            if (!empty($_GET['start-date']) && !empty($_GET['end-date']) && isset($_GET['capacity'])) {
                $date1 = new DateTime($_GET['start-date']);
                $date2 = new DateTime($_GET['end-date']);
                if ($date1 == false) { //input validation
                    exit("Please check Your date! Incorrect start date!");
                } else if ($date2 == false) {
                    exit("Please check Your date! Incorrect end date!");
                } else if ($date2 < $date1) {
                    exit("Please check Your date! Starting date cannot be further than ending date!");
                } else if ($date1 < new DateTime('now') || $date2 < new DateTime('now')) {
                    exit("Please check Your date! Starting date cannot be in the past!");
                } else if (!filter_var($_GET['capacity'], FILTER_VALIDATE_INT) === 0 || !filter_var($_GET['capacity'], FILTER_VALIDATE_INT)) { //checks if capacity is integer
                    exit("Capacity must be a number (integer) or greater than 0");
                }
                $capacity = intval($_GET['capacity']) * 2; //multiplied required capacity by 2 due to covid
                $whiteboard = intval(isset($_GET['whiteboard'])); //converts required features into 0 or 1
                $audio = intval(isset($_GET['audio']));
                $projector = intval(isset($_GET['projector']));
                $mysqli = new mysqli($db_server, $db_user, $db_password, $db_name);
                if($mysqli->connect_error){ //checks for errors when connecting to db
                    die($mysqli->connect_error);
                }
                $featureSetArray = DataActions::readFeatures($mysqli, $capacity, $whiteboard, $audio, $projector, $date1, $date2);
                $roomArray = DataActions::readRooms($mysqli, $featureSetArray);
                $bookingArray = DataActions::readBookedRooms($mysqli, $roomArray, $date1, $date2);
                foreach ($bookingArray as $booking) { //removes rooms that are booked
                    unset($roomArray[($booking->getRoomId())]);
                }
                foreach ($featureSetArray as $feature) { //removes featuresets with 0 available rooms
                    $featureRoomCount = 0;
                    foreach ($roomArray as $room) {
                        if ($room->getFeatures() == $feature->getId()) {
                            $featureRoomCount++;
                        }
                    }
                    if ($featureRoomCount == 0) {
                        unset($featureSetArray[$feature->getId()]);
                    }
                }
                foreach ($featureSetArray as $feature) {
                    echo "<div class='room'>";
                    echo "<div class='room-info'>";
                    echo "<h3>", $feature->getTitle(), "</h3>";
                    echo "<p>", $feature->getDescription(), "</p>";
                    echo "<div class='room-actions'>";
                    echo "<p>Click room number to book: </p>";
                    $roomNumbers = DataActions::readFeatureRooms($mysqli, $feature->getId(), $roomArray);
                    foreach ($roomNumbers as $roomId => $roomNumber) {
                        echo "<form action='booking.php' method='POST' class='room-buttons'>";
                        echo "<input type='hidden' name='startdate' value=", $date1->format('Y-m-d\TH:i'), ">";
                        echo "<input type='hidden' name='enddate' value=", $date2->format('Y-m-d\TH:i'), ">";
                        echo "<button name='roomId' value=", $roomId, " type='submit'>", $roomNumber, "</button>";
                        echo "</form>";
                    }
                    echo "</div>";
                    echo "</div>";
                    echo "<div class='room-details'>";
                    echo "<img class='myImages' src=", $feature->getImage(), " alt='", $feature->getTitle(), "'>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "Please check your input!";
            }
            $mysqli->close();
        }
        ?>
    </article>
    <div id="myModal" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="img01" src="img/buisnessroom1.jpg" alt="bigger-image">
        <div id="caption"></div>
    </div>
</body>

</html>