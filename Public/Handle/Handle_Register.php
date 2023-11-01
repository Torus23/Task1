<?php
    session_start();
    if($_SERVER["REQUEST_METHOD"] == 'GET'){
        die("This page does not accept get requests!!!");
    }
    require "../../dbconfig.php";
    $connection = mysqli_init();
    mysqli_real_connect($connection,  $servername, $username, $password, $dbname,  $port);
    if (mysqli_connect_errno()) {
    die('Failed to connect to MySQL: '.mysqli_connect_error()); }
  
    $email = $_POST["email"];
    $password = $_POST["password"];
    $firstname = $_POST["first-name"];
    $lastname = $_POST["last-name"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $zipcode = $_POST["zip"];
    $country = $_POST["country"];
    $confirm_password = $_POST["confirm-password"];
    $phone = $_POST["phone"];

    $password_hash = password_hash($password, PASSWORD_ARGON2I);

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($connection,$sql);
    mysqli_stmt_bind_param($stmt,'s', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);


    if(mysqli_fetch_assoc($result)){
        $_SESSION["email"] = $email;
        $_SESSION["password"] = $password;
        $_SESSION["firstname"] = $firstname;
        $_SESSION["lastname"] = $lastname;
        $_SESSION["address"] = $address;
        $_SESSION["city"] = $city;
        $_SESSION["zip"] = $zipcode;
        $_SESSION["country"] = $country;
        $_SESSION["phone"] = $phone;
        $_SESSION['error_message'] = "Email already registered!!!";
        $_SESSION["register_error"] = true;
        header('Location: ../register.php');
    }
    else{
        if($password != $confirm_password){
            $_SESSION["email"] = $email;
            $_SESSION["password"] = $password;
            $_SESSION["firstname"] = $firstname;
            $_SESSION["lastname"] = $lastname;
            $_SESSION["address"] = $address;
            $_SESSION["city"] = $city;
            $_SESSION["zip"] = $zipcode;
            $_SESSION["country"] = $country;
            $_SESSION["phone"] = $phone;
            $_SESSION["register_error"] = true;
            $_SESSION['error_message'] = "Passwords do not match!!!";
            header('Location: ../register.php');
            die;
        }

        $sql = "INSERT INTO users (email, password, firstname, lastname, address, city, zipcode, country, phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($connection,$sql);
        if(!$stmt) {
            die("Failed preparing SQL statment: " . .mysqli_connect_error());
        }
        mysqli_stmt_bind_param($stmt,'ssssssiss', $email, $password_hash, $firstname, $lastname, $address, $city, $zipcode, $country, $phone);
        mysqli_stmt_execute($stmt);
        header('Location: ../login.php');
    }
?>
