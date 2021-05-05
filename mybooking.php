<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <title>My bookings</title>
   <link rel="shortcut icon" type="image/jpg" href="img/favicon.png" />
   <link rel="stylesheet" href="styles/main.css">
   <link rel="stylesheet" href="styles/mybooking.css">
   <link rel="preconnect" href="https://fonts.gstatic.com/">
   <link href="https://fonts.googleapis.com/css2?family=RocknRoll+One&display=swap" rel="stylesheet">
   <script src="scripts/logout.js" async></script>
   <script src="scripts/dateformat.js" async></script>
   <script src="scripts/remove.js" async></script>
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
      if (isset($_SESSION['username'])) {
         require_once("connect.db.php");
         $username = $_SESSION['username'];
         $mysqli = new mysqli($db_server, $db_user, $db_password, $db_name); // connect to database
         $query = "SELECT ID FROM users WHERE username= ?"; //find user id
         $query = $mysqli->prepare($query);
         $query->bind_param("s", $username);
         $query->execute();
         $query->bind_result($ID);
         echo "<p> Hello, ", $_SESSION['username'], "!</p>";
         $userid;
         $roomid;
         while ($query->fetch()) {
            echo "<p>Your user ID is: " . $ID . "</p>";
            $userid = $ID;
         }
         if (isset($_POST['deletion'])) {
            $query = "SELECT B.ID FROM bookings AS B WHERE B.user_ID= ?"; //find user bookings
            $query = $mysqli->prepare($query);
            $query->bind_param("i", $userid);
            $query->execute();
            $query->bind_result($ID);
            while ($query->fetch()){
               if ($ID = $_POST['deletion']){
                  $retreivedid = $ID;
                  $query = "DELETE FROM bookings WHERE ID = ?";
                  $query = $mysqli->prepare($query);
                  $query->bind_param("i", $retreivedid);
                  $query->execute();
                  header("Refresh:0; url=mybooking.php");
               }
            }
         }
         $query = "SELECT COUNT(*) FROM bookings AS B, users AS U WHERE U.username=? AND B.user_ID=U.ID;"; //find user id
         $query = $mysqli->prepare($query);
         $query->bind_param("s", $_SESSION['username']);
         $query->execute();
         $query->bind_result($count);
         while ($query->fetch()) {
            if ($count > 0) {
               echo "<p> Here are Your bookings: </p>";
            } else {
               echo "<p> You currently have no bookings!</p>";
            }
         }
         $query = "SELECT B.ID, room_ID, start_date, end_date, room_number, capacity FROM bookings AS B, rooms AS R, featuresets AS F WHERE B.user_ID= ? AND R.ID=room_ID AND R.feature_ID=F.ID"; //find user bookings
         $query = $mysqli->prepare($query);
         $query->bind_param("i", $userid);
         $query->execute();
         $query->bind_result($ID, $roomid, $startdate, $end_date, $roomnumber, $capacity);
         while ($query->fetch()) {
            echo "<p> Booking ID: " . $ID . " Starts: <span class='startdate'>" . $startdate . "</span> Ends: <span class='enddate'>" . $end_date . "</span> Room number: " . $roomnumber . " Capacity: " . $capacity . "</p>";
            echo "<br><button type='button' onclick='removeBooking(" . $ID . ")'>Remove</button>"; // button for removing booking;
         }
      } else {
         echo "<p>You must be logged in to see this page!</p>";
      }
      ?>
   </article>
</body>

</html>