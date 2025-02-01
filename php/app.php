<?php

function dbConnect($conn)
{

    $servername = "localhost";
    $username = "root";

    try {

        $conn = new PDO("mysql:host=$servername;dbname=log_reg_system", $username, '');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo 'Connected successfully'; // debug

    } catch (PDOException $e) {

        echo "Connection failed: " . $e->getMessage();

    }

    return $conn;

}

function filterInput($data)
{

    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;

}

function userRegistration($conn)
{

    $conn = dbConnect($conn);

    $fName = filterInput($_POST['first_name']);
    $lName = filterInput($_POST['last_name']);
    $email = filterInput($_POST['email']);

    if (filterInput($_POST['password']) == filterInput($_POST['password_confirmation']))
    {
        
        $password_confirmation = filterInput($_POST['password_confirmation']);
        $password = password_hash($password_confirmation, PASSWORD_BCRYPT);

    }

    if (!empty($fName) && !empty($lName) && !empty($email) && !empty($password))
    {

        $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':first_name', $fName);
        $stmt->bindParam(':last_name', $lName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        return $stmt;
    
    }

}

function userLogin($conn)
{

    $conn = dbConnect($conn);

    $email = filterInput($_POST['email']);
    $password = filterInput($_POST['password']);

    if (!empty($email) && !empty($password))
    {

        $sql = "SELECT * FROM users";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($users as $user)
        {
            
            if ($email == $user['email'] && password_verify($password, $user['password']) && $stmt->rowCount() >= 1)
            {
    
                $_SESSION['id'] = $user['id'];
                header("Location: index.php");
    
            }
    
        }
    
        return $stmt;

    }

}

function userLogout()
{

    session_destroy();
    header("Location: login.php");

}
