<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Log out</title>
    <link rel="shortcut icon" type="image/jpg" href="img/favicon.png" />
    <link rel="stylesheet" href="styles/main.css">
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=RocknRoll+One&display=swap" rel="stylesheet">
    <script src="scripts/logout.js" async></script>
    <script src="scripts/logouttimer.js" async></script>
</head>

<body>
    <header>
        <h1>Room booking</h1>
        <ul id="login-menu">
            <li><a href='login.html'>Login</a></li>
            <li><a href='register.html'>Register</a></li>
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
        session_start();
        session_unset();
        session_destroy();
        unset($_COOKIE['PP_Table']);
        setcookie('PP_Table', null, -1, '/');
        echo "<p style='text-align: center; 
        margin-top: 14vw;
        font-size: xx-large;'>
        Logged out! <br> You will be redirected in 5 seconds...</p>";
        ?>
    </article>
</body>

</html>