<?php
    session_start();
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        die("This page does not accept get requests!!!");
    }
    require "../../dbconfig.php";  
    include "../../Include/User.php";
    $connection = mysqli_init();
    mysqli_real_connect($connection,  $servername, $username, $password, $dbname,  $port);
    if (mysqli_connect_errno()) {
    die('Failed to connect to MySQL: '.mysqli_connect_error()); }

    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($connection,$sql);
    mysqli_stmt_bind_param($stmt, "s", $email);    
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($result)){
        $password_hash = $row["password"];
        if(password_verify($password, $password_hash)){
            $user = new User($row["userID"], $row["email"], $row["firstname"], $row["lastname"], $row["address"], $row["city"], $row["zipcode"], $row["country"], $row["phone"]);
            $_SESSION["user"] = serialize($user);
            header('Location: ../index.php');
        }
        else {
            $_SESSION["login_error"] = true;
            $_SESSION['error_message'] = "Email or Password is incorrect!!!";
            $_SESSION["email"] = $email;
            header('Location: ../login.php');
        }
    }
    else{
        $_SESSION["login_error"] = true;
        $_SESSION['error_message'] = "Email or Password is incorrect!!!";
        $_SESSION["email"] = $email;
        header('Location: ../login.php');
    }
?>
