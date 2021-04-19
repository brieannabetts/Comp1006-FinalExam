<?php
// hidden page so no header / footer needed
// get login inputs
$username = $_POST['username'];
$password = $_POST['password'];

// connect
include 'db.php';

// set up query
$sql = "SELECT * FROM examusers WHERE username = :username";
$cmd = $db->prepare($sql);
$cmd->bindParam(':username', $username, PDO::PARAM_STR, 100);
$cmd->execute();
$user = $cmd->fetch();

    // if user found, check password
    if (!$user) {
        $db = null;
        header('location:login.php?invalid=true');
    }
    else {
        // compare the hashed password in the db with a hashed version of the password entered
        if (password_verify($password, $user['password'])) {
            // connect to existing session on the web server
            session_start();

            // store username in a session variable for persistence
            $_SESSION['username'] = $username;

            // redirect to items list
            $db = null;
            header('location:items.php');
        }
        else {
            // disconnect
            $db = null;

            // if invalid, reload login page w/error
            header('location:login.php?invalid=true');
        }
    }
?>