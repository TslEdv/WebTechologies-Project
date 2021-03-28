<?php
if(isset($_POST['register'])){
    $password = password_hash($_POST['psw1'], PASSWORD_DEFAULT);
    unset($_POST['psw1']);
    if(!password_verify($_POST['psw2'], $password)){
        exit("Password was unconfirmed! Please try again!");
    }
    unset($_POST['psw2']);
    $text = $_POST['uname'] . "," . $password . PHP_EOL;
    file_put_contents("data/users.csv", $text, FILE_APPEND);
    echo "Registery Successful!";
}
if (isset($_POST['login'])){
    $handle = fopen("data/users.csv", "r");
    $success = FALSE;
    while (($data = fgetcsv($handle)) !== FALSE){
        if (($data[0] == $_POST['uname']) && (password_hash($_POST['psw1'], PASSWORD_DEFAULT) == $data[1])){
            $success = TRUE;
        }
    }
    if ($success == TRUE){
        if(isset($_POST['remember'])){
            session_name($_POST['uname']);
            session_start();
            $_SESSION['username'] = $_POST['uname'];
            $_SESSION['id'] = session_id();
            echo "Login Successful! Welcome back ", $_SESSION['username'];
        } else{
            session_name($_POST['uname']);
            $lifetime=600;
            session_set_cookie_params($lifetime);
            session_start();
            $_SESSION['username'] = $_POST['uname'];
            $_SESSION['id'] = session_id();
            echo "Login Successful! Welcome back ", $_SESSION['username'];
        }
    } else{
        echo "Wrong Username or Password!";
    }
}
?>