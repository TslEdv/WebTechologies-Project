<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <link rel="shortcut icon" type="image/jpg" href="img/favicon.png" />
   <title>Homepage</title>
   <link rel="stylesheet" href="styles/main.css">
   <link rel="stylesheet" href="styles/homepage.css">
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
         session_name("PP_Table"); // starts a session PP_Table
         session_start();
         if (isset($_SESSION['username'])) { // if there is variable $_SESSION['username'], 
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
      <h3>Welcome to Our wonderful booking service page!</h3>
      <p>
         Here you can book a room to study, work or have some fun time with your friends!
      </p>
      <p>Variety of rooms are guaranteed to fit any need possible, even with pandemic restrictions.</p>
      <p>Our services have been around already 20 years.</p>
      <p>
         Its really simple to book a room at any time!
      </p>
      <p>
         You only need to add amount of people, date, time and requirements.
      </p>
   </article>
   <div class="images">
      <img src="img/buisnessroom1.jpg" alt="Conference Room" class="myImages">
      <img src="img/buisness2room.jpg" alt="Premium Room" class="myImages">
      <img src="img/businessroom3.jpg" alt="Casual Room" class="myImages">
      <img src="img/buisnessroom.jpg" alt="Cozy Room" class="myImages">
      <div id="myModal" class="modal">
         <span class="close">&times;</span>
         <img class="modal-content" id="img01" src="img/buisnessroom1.jpg" alt="bigger-image">
         <div id="caption"></div>
      </div>
   </div>
</body>

</html>