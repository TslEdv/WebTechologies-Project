<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <title>Booking</title>
   <link rel="shortcut icon" type="image/jpg" href="img/favicon.png" />
   <link rel="stylesheet" href="styles/main.css">
   <link rel="stylesheet" href="styles/booking.css">
   <link rel="preconnect" href="https://fonts.gstatic.com/">
   <link href="https://fonts.googleapis.com/css2?family=RocknRoll+One&display=swap" rel="stylesheet">
   <script src="scripts/logout.js" async></script>
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
      <h3>Booking</h3>
      <h4>This page contains the booking form</h4>
      <?php
      if (!isset($_SESSION['username'])) {
         echo "<h4>Before booking a room you must login/register first!</h4>
            <h4>You can still browse the rooms without logging in.</h4>";
      }
      ?>
      <form action="checkavailabilty.php" method="GET" id="booking-form">
         <div class="start-date">
            <label for="start-date" id="start">Start date</label>
            <input type="datetime-local" id="start-date" name="start-date">
         </div>
         <div class="end-date">
            <label for="end-date" id="end">End date</label>
            <input type="datetime-local" id="end-date" name="end-date">
         </div>
         <div class="capacity">
            <label for="capacity" id="cap">Capacity</label>
            <input type="number" id="capacity" name="capacity" placeholder="100">
         </div>
         <div class="features">
            Requirements:
            <label for="whiteboard">Whiteboard</label>
            <input type="checkbox" id="whiteboard" name="whiteboard" value="1">
            <label for="audio">Audio</label>
            <input type="checkbox" id="audio" name="audio" value="1">
            <label for="projector" id="proj">Projector</label>
            <input type="checkbox" id="projector" name="projector" value="1">
         </div>
         <input type="submit" name="submit" value="Check availability">
      </form>
   </article>
</body>

</html>