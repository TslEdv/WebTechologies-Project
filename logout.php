<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Check availability</title>
    <link rel="shortcut icon" type="image/jpg" href="img/favicon.png" />
    <link rel="stylesheet" href="styles/main.css">
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
        <?php
        session_start();
        session_unset();
        session_destroy();
        unset($_COOKIE['PHPSESSID']);
        setcookie('PHPSESSID', null, -1, '/');
        echo "<p style='text-align: center; 
        margin-top: 14vw;
        font-size: xxx-large;'>
        Logged out!</p>";
        ?>
    </article>
</body>

</html>