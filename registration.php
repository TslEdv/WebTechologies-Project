<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Registration</title>
    <link rel="shortcut icon" type="image/jpg" href="img/favicon.png" />
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/registration.css">
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
        <?php
        require_once("connect.db.php");
        if (isset($_POST['register'])) {
            $mysqli = new mysqli($db_server, $db_user, $db_password, $db_name); // connect to database
            $username = mysqli_real_escape_string($mysqli, $_POST['uname']);
            $password = password_hash($_POST['psw1'], PASSWORD_BCRYPT);
            if (empty($username) || empty($password) || empty($_POST['psw2'])) { //check for inputs
                exit("Incorrect input!");
            }
            unset($_POST['psw1']); //unset post password
            if (!password_verify($_POST['psw2'], $password)) {
                exit("The two passwords do not match");
            }
            unset($_POST['psw2']);
            $user_check_query = "SELECT * FROM users WHERE username=? LIMIT 1"; //query for checking if user already exists
            $query = $mysqli->prepare($user_check_query);
            $query->bind_param("s", $username);
            $query->execute();
            $query->bind_result($user);
            print($query->error);
            if ($query->fetch()) {
                exit("Username already exists.");
            }
            $query = "INSERT INTO users (username, password) VALUES(?, ?)"; // query for adding user
            $query = $mysqli->prepare($query);
            $query->bind_param("ss", $username, $password);
            $query->execute();
            print($query->error);
            session_name("PP_Table"); // start session and add variables
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['success'] = TRUE;
            echo "<p>Registery Successful!</p>";
        } else if (isset($_POST['login'])) { //check for login
            $mysqli = new mysqli($db_server, $db_user, $db_password, $db_name); // connect to database
            $username = mysqli_real_escape_string($mysqli, $_POST['uname']);
            if (empty($username)) {
                exit("Username is required");
            }
            $query = "SELECT * FROM users WHERE username=?"; //query for selecting the user from data
            $query = $mysqli->prepare($query);
            $query->bind_param("s", $username);
            $query->execute();
            $query->bind_result($user, $hash);
            while ($query->fetch()) {
                if (password_verify($_POST['psw'], $hash)) {
                    break;
                }
            }
            session_name("PP_Table");
            if (isset($_POST['remember'])) {
                $lifetime = 86400 * 30;
                session_set_cookie_params($lifetime);
                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['success'] = TRUE;
                echo "<p>Login Successful! Welcome back ", $_SESSION['username'], "</p>";
            } else {
                session_name("PP_Table");
                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['success'] = TRUE;
                echo "<p>Login Successful! Welcome back ", $_SESSION['username'], "</p>";
            }
        }
        ?>
    </article>
</body>

</html>