<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/jpg" href="img/favicon.png" />
    <title>Overview</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/modalimages.css">
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=RocknRoll+One&display=swap" rel="stylesheet">
    <script src="scripts/logout.js" async></script>
    <script src="scripts/images.js" async></script>
    <style>
        .room {
            position: absolute;
            left: 20%;
            margin-top: 5%;
        }
    </style>
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
        <h3>Overview of PP_Table bookings services</h3>
        <p>
            Our services have been around for already 20 years! We know how please our customers so they keep coming back.
            5 types of rooms with several available for every need You could imagine!
        </p>
        <p>
            Rooms are cleaned daily to assure the best quality of rooms and experience.
            Your feedback matter and we have made sure that people can reach out to us and share their toughts on our services.
        </p>
        <div class="room">
            <img src="img/1991room.jpg" alt="room 1991" style="width:60%;height:60%" class="myImages">
            <div id="myModal" class="modal">
                <span class="close">&times;</span>
                <img class="modal-content" id="img01" src="img/1991room.jpg" alt="zoomedin-image">
                <div id="caption"></div>
            </div>
        </div>
    </article>
</body>

</html>