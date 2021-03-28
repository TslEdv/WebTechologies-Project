<?php
if(isset($_POST['register'])){
    $password = password_hash($_POST['psw1'], PASSWORD_DEFAULT);
    unset($_POST['psw1']);
    if(!password_verify($_POST['psw2'], $password)){
        echo "Password was unconfirmed! Please try again!";
    }
    unset($_POST['psw2']);
}
?>