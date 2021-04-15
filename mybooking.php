<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <title>My bookings</title>
   <link rel="shortcut icon" type="image/jpg" href="img/favicon.png" />
   <link rel="stylesheet" href="styles/main.css">
   <link rel="stylesheet" href="styles/mybooking.css">
   <link href='https://fonts.googleapis.com/css?family=RocknRoll One' rel='stylesheet'>
   <script type="text/javascript" src="scripts/logout.js"></script>
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
         if (isset($_POST['deletion'])){
            $retreivedid = $_POST['deletion'];
            $query = "DELETE FROM bookings WHERE ID ='$retreivedid'";
            mysqli_query($mysqli, $query);
         }
         $query = "SELECT ID FROM users WHERE username='$username'"; //find user id
         $id = mysqli_query($mysqli, $query);
         echo "<p> Hello, ", $_SESSION['username'], "!</p>";
         $userid;
         $roomid;
         while ($row = $id->fetch_assoc()) {
            echo "<p><br> Your user ID is: ". $row["ID"]. "</p>";
            $userid = $row["ID"];
         }
         echo "<p> Here are Your bookings: </p>";
         $query = "SELECT ID, room_ID, start_date, end_date FROM bookings WHERE user_ID='$userid'"; //find user bookings
         $result = mysqli_query($mysqli, $query);
         while ($row = $result->fetch_assoc()) {
            $roomid = $row["room_ID"];
            $bookingid = $row["ID"];
            echo "<br><p> Booking ID: ". $row["ID"]. " Starts: " . $row["start_date"] . " Ends: " . $row["end_date"];
            $query2 = "SELECT feature_ID, room_number FROM rooms WHERE ID='$roomid'"; //find rooms related to the roomid
            $result2 = mysqli_query($mysqli, $query2);
            while ($row = $result2->fetch_assoc()) {
               echo " Room number: " . $row["room_number"] . "</p>";
            }
            echo "<form action='mybooking.php' method=POST>"; // button for removing booking
            echo "<input type='hidden'name='deletion' value='$bookingid'>";
            echo "<input type='submit' value='Remove'>";
            echo "</form>";
         }
      } else {
         echo "<p>You must be logged in to see this page!</p>";
      }
      ?>
   </article>
</body>

</html>