<?php
require_once("connect.db.php");
if (isset($_POST['feedback'])) {
   $mysqli = new mysqli($db_server, $db_user, $db_password, $db_name);
   $query = "INSERT INTO feedback (ip_address, feedback_date, feedback_text) VALUES (?, ?, ?)";
   $query = $mysqli->prepare($query);
   $query->bind_param("sss", $_SERVER['REMOTE_ADDR'], date("Y-m-d H:i:s"), $_POST['feedback']);
   $query->execute();
   if ($query->error) {
      die("Feedback submission failed. " . $query->error);
   }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <title>Contact & Feedback</title>
   <script src="scripts/feedback.js" async></script>
   <link rel="shortcut icon" type="image/jpg" href="img/favicon.png" />
   <link rel="stylesheet" href="styles/main.css">
   <link rel="stylesheet" href="styles/contact.css">
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
      <h3>Contact</h3>
      <p><b>If you have any questions regarding booking, please contact our customer support</b></p>
      <p>We will try our best to answer your questions through our e-mail <a id="mailing" href="mailto:edvess@taltech.ee">edvess@taltech.ee</a> or the phone.</p>
      <br>
      <p><b>Phone number: </b>currently unavailable</p>
      <p><b>Working hours: </b>Monday-Friday 14:00-02:00</p>
      <br>
      <div id="feedback-form">
         <p><b>If you have any feedback or recommendations, please fill the box below. Your IP address will be logged for security reasons.</b></p>

         <h2>Feedback:</h2>
         <textarea id="feedback" name="feedback" rows="7" cols="50"></textarea>
         <br>
         <input type="submit" value="Submit" name="feedbacksubmit" onclick="thankSubmission()">

      </div>
      <div id="thank">
      </div>
   </article>
</body>

</html>