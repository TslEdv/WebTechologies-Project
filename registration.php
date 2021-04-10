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
        if (isset($_POST['register'])) {
            require_once("connect.db.php");
            $mysqli = new mysqli($db_server, $db_user, $db_password, $db_name); // connect to database
            $username = mysqli_real_escape_string($mysqli, $_POST['uname']); //sanitize
            $password_1 = mysqli_real_escape_string($mysqli, $_POST['psw1']);
            $password_2 = mysqli_real_escape_string($mysqli, $_POST['psw2']);
            if (empty($username) || empty($_POST['psw1']) || empty($_POST['psw2'])){ //check for inputs
                exit("Incorrect input!");
            }
            unset($_POST['psw1']); //unset post password
            if ($password_1 != $password_2) {
                exit("The two passwords do not match");
            }
            unset($_POST['psw2']);
            $password = sha1($password_1);
            $password = mysqli_real_escape_string($mysqli, $password);
            $user_check_query = "SELECT * FROM users WHERE username='$username' LIMIT 1"; //query for checking if user already exists
            $result = mysqli_query($mysqli, $user_check_query);
            $user = mysqli_fetch_assoc($result);
            if ($user){ //check for existance
                if ($user['username'] === $username) {
                    exit("Username already exists");
                }
            }
            $query = "INSERT INTO users (username, password) VALUES('$username', '$password')"; // query for adding user
            mysqli_query($mysqli, $query);
            session_name("PP_Table"); // start session and add variables
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in";
            echo "<p>Registery Successful!</p>";
        }
        else if (isset($_POST['login'])) { //check for login
            require_once("connect.db.php");
            $mysqli = new mysqli($db_server, $db_user, $db_password, $db_name); // connect to database
            $username = mysqli_real_escape_string($mysqli, $_POST['uname']);
            $password = mysqli_real_escape_string($mysqli, $_POST['psw']);
            if (empty($username)) {
                exit("Username is required");
            }
            if (empty($password)) {
                exit("Password is required");
            }
            $password = sha1($password);
            $query = "SELECT * FROM users WHERE username='$username' AND password='$password'"; //query for selecting the user from data
            $results = mysqli_query($mysqli, $query);
            if (mysqli_num_rows($results) == 1) { //if user is found do following
                if (isset($_POST['remember'])) {
                    session_name("PP_Table");
                    $lifetime = 86400 * 30;
                    session_set_cookie_params($lifetime);
                    session_start();
                    $_SESSION['username'] = $username;
                    echo "<p>Login Successful! Welcome back ", $_SESSION['username'], "</p>";
                } else {
                    session_name("PP_Table");
                    session_start();
                    $_SESSION['username'] = $username;
                    echo "<p>Login Successful! Welcome back ", $_SESSION['username'], "</p>";
                }
            }else {
                exit("Wrong username/password combination");
            }
        }
        ?>
    </article>
</body>

</html>