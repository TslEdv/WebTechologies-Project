<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <title>Contact & Feedback</title>
   <link rel="shortcut icon" type="image/jpg" href="img/favicon.png" />
   <link rel="stylesheet" href="styles/main.css">
   <link rel="stylesheet" href="styles/contact.css">
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
      <h3>Contact</h3>
      <p><b>If you have any questions regarding booking, please contact our customer support</b></p>
      <p>We will try our best to answer your questions through our e-mail <a id="mailing" href="mailto: edvess@taltech.ee">edvess@taltech.ee</a> or the phone.</p>
      <br>
      <p><b>Phone number: </b>currently unavailable</p>
      <p><b>Working hours: </b>Monday-Friday 14:00-02:00</p>
      <br>
      <p><b>If you have any feedback or recommendations, please fill the box below:</b></p>
      <form action="#">
         <label for="feedback">
            <h2>Feedback:</h2>
         </label>
         <textarea id="feedback" name="feedback" rows="7" cols="50"></textarea>
         <br>
         <input type="submit" value="Submit">
      </form>
   </article>
</body>

</html>