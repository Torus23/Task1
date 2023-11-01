<?php
    session_start();
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        die("This page does not accept get requests!!!");
    }
    require "../../dbconfig.php";
    require "../../Include/Dbconnect/php";
    include "../../Include/User.php";
   

    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($connection,$sql);
    mysqli_stmt_bind_param($stmt, "s", $email);    
    $result = $stmt->get_result();

    if($row = $result->fetch_assoc()){
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
