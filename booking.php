<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <title>Booking</title>
   <link rel="shortcut icon" type="image/jpg" href="img/favicon.png" />
   <link rel="stylesheet" href="styles/main.css">
   <link rel="stylesheet" href="styles/checkavailability.css">
   <link href='https://fonts.googleapis.com/css?family=RocknRoll One' rel='stylesheet'>
</head>

<body>
   <header>
      <h1>Room booking</h1>
      <ul id="login-menu">
         <?php
         session_name("PP_Table");
         session_start();
         if (isset($_SESSION['username'])) {
            echo "<li><a href='logout.php'>Log out</a></li>";
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
        if(isset($_POST['roomId'])){
            session_name("PP_Table");
            session_start();
            if (!isset($_SESSION['username'])){
                session_unset();
                session_destroy();
                unset($_COOKIE['PP_Table']);
                setcookie("PP_Table", null, -1);
                exit("<p>You must be logged in to view this page!</p>");
            }
            $startdate = new DateTime($_POST['startdate']);
            $enddate = new DateTime($_POST['enddate']);
            if($startdate == false){ //input validation
                exit("Please check Your date! Incorrect start date!");
            }
            else if($enddate == false){
                exit("Please check Your date! Incorrect end date!");
            }
            else if($enddate < $startdate){
                exit("Please check Your date! Starting date cannot be further than ending date!");
            }
            else if($startdate < date("Y-m-d")){
                exit("Please check Your date! Starting date cannot be in the past!");
            }
            $mysqli = new mysqli($db_server, $db_user, $db_password, $db_name);
            $query = $mysqli->prepare("SELECT ID FROM users WHERE username=?");
            $query->bind_param("s", $_SESSION['username']);
            $query->execute();
            $query->bind_result($user);
            $userid = 0;
            while($query->fetch()){
               $userid = $user;
            }
            $query = $mysqli->prepare("INSERT INTO bookings (room_ID, user_ID, start_date, end_date) VALUES (?, ?, ?, ?)");
            $query->bind_param("iiss", $_POST['roomId'], $userid, $startdate->format("Y-m-d\TH:i"), $enddate->format("Y-m-d\TH:i"));
            $query->execute();
            print($query->error);
            $query->close();
            echo "<p>Booking successful! Your booking number is " . $mysqli->insert_id ."</p>";
            echo "<p>You have made a booking starts on ", $startdate->format("Y-m-d\TH:i"), " and ends on ", $enddate->format("Y-m-d\TH:i"),"</p>";

        }
        else {
            echo "Invalid request!";
        }
        ?>
        </article>
    </body>
 </html>
