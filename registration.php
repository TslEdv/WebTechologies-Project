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
        if (isset($_POST['register'])) {
            $password = password_hash($_POST['psw1'], PASSWORD_DEFAULT);
            unset($_POST['psw1']);
            if (!password_verify($_POST['psw2'], $password)) {
                exit("Password was unconfirmed! Please try again!");
            }
            unset($_POST['psw2']);
            $text = $_POST['uname'] . "," . $password . PHP_EOL;
            file_put_contents("data/users.csv", $text, FILE_APPEND);
            echo "Registery Successful!";
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
                    $lifetime = 86400 * 30;
                    session_set_cookie_params($lifetime);
                    session_start();
                    $_SESSION['username'] = $_POST['uname'];
                    echo "Login Successful! Welcome back ", $_SESSION['username'];
                } else {
                    session_start();
                    $_SESSION['username'] = $_POST['uname'];
                    echo "Login Successful! Welcome back ", $_SESSION['username'];
                }
            } else {
                echo "Wrong Username or Password!";
            }
        }
        ?>
    </article>
</body>

</html>