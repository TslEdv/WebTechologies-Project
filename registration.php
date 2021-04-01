<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Check availability</title>
    <link rel="shortcut icon" type="image/jpg" href="img/favicon.png" />
    <link rel="stylesheet" href="styles/main.css">
    <link href='https://fonts.googleapis.com/css?family=RocknRoll One' rel='stylesheet'>
    <style>
         p{
            text-align: center; 
            margin-top: 14vw;
            font-size: xxx-large;
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
            if(isset($_SESSION['username'])){
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
        if (isset($_POST['register'])) {
            $password = password_hash($_POST['psw1'], PASSWORD_DEFAULT);
            unset($_POST['psw1']);
            if (!password_verify($_POST['psw2'], $password)) {
                exit("<p>Password was unconfirmed! Please try again!</p>");
            }
            unset($_POST['psw2']);
            $uniqueid = uniqid();
            $text = $_POST['uname'] . "," . $password . "," . $uniqueid . PHP_EOL;
            file_put_contents("data/users.csv", $text, FILE_APPEND);
            session_name("PP_Table");
            session_start();
            $_SESSION['username'] = $_POST['uname'];
            echo "<p>Registery Successful!</p>";
        }
        if (isset($_POST['login'])) {
            $handle = fopen("data/users.csv", "r");
            $success = FALSE;
            while (($data = fgetcsv($handle)) !== FALSE) {
                if (($data[0] == $_POST['uname']) && (password_verify($_POST['psw'], $data[1]))) {
                    $success = TRUE;
                }
            }
            if ($success == TRUE) {
                if (isset($_POST['remember'])) {
                    session_name("PP_Table");
                    $lifetime = 86400 * 30;
                    session_set_cookie_params($lifetime);
                    session_start();
                    $_SESSION['username'] = $_POST['uname'];
                    echo "<p>Login Successful! Welcome back ", $_SESSION['username'], "</p>";
                } else {
                    session_name("PP_Table");
                    session_start();
                    $_SESSION['username'] = $_POST['uname'];
                    echo "<p>Login Successful! Welcome back ", $_SESSION['username'], "</p>";
                }
            } else {
                echo "<p>Wrong Username or Password!</p>";
            }
        }
        ?>
    </article>
</body>

</html>