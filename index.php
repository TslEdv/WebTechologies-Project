<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <link rel="shortcut icon" type="image/jpg" href="img/favicon.png" />
   <title>Homepage</title>
   <link rel="stylesheet" href="styles/main.css">
   <link rel="stylesheet" href="styles/homepage.css">
   <link href='https://fonts.googleapis.com/css?family=RocknRoll One' rel='stylesheet'>
</head>

<body>
   <header>
      <h1>Room booking</h1>
      <ul id="login-menu">
         <?php
         if (isset($_COOKIE['PHPSESSID'])) {
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
         <li><a href="index.php">Home page</a></li>
         <li><a href="overview.php">Overview</a></li>
         <li><a href="bookingform.php">Booking</a></li>
         <li><a href="contact.php">Contact</a></li>
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
   <div>
      <a href="img/buisnessroom1.jpg">
         <img src="img/buisnessroom1.jpg" alt="room1">
      </a>
      <a href="img/buisness2room.jpg">
         <img src="img/buisness2room.jpg" alt="room2">
      </a>
      <a href="img/businessroom3.jpg">
         <img src="img/businessroom3.jpg" alt="room3">
      </a>
      <a href="img/buisnessroom.jpg">
         <img src="img/buisnessroom.jpg" alt="room4">
      </a>
   </div>
</body>

</html>