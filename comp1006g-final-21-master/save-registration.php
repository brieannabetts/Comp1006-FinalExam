<?php
$pageTitle = "Registering...";
include 'header.php';

// store the user's input in a variable (optional but recommended by simplicity)
$username = $_POST['username'];
$password = $_POST['password'];
$confirm = $_POST['confirm'];
$ok = true;

// validate inputs
if (empty($username)) {
    echo 'Username required<br />';
    $ok = false;
}

if (empty($password)) {
    echo 'Password required<br />';
    $ok = false;
}

if ($password != $confirm) {
    echo 'Passwords must match<br />';
    $ok = false;
}

// recaptcha validation
$apiUrl = 'https://www.google.com/recaptcha/api/siteverify'; // from api docs
$secret = '6LfWjqgaAAAAABhz3RdbMyHjAsarcRjkGqXjAMcd'; // from google console
$response = $_POST['recaptchaResponse']; // from hidden input on form

//echo "Response: $response<br />";
// call recaptcha api and parse the result to check the bot score
$apiResponse = file_get_contents($apiUrl . "?secret=$secret&response=$response");
$recaptchaResponse = json_decode($apiResponse);

if ($recaptchaResponse->success == false) {
    echo 'Are you human?';
    $ok = false;
}
else {
    // check if api shows bot (0.0) or user (1.0)
    if ($recaptchaResponse->score < 0.5) {
        echo 'Are you human?';
        $ok = false;
    }
}

// save if valid
if ($ok) {
    // connect
    include 'db.php';
        // check username doesn't already exist
        $sql = "SELECT userId FROM examusers WHERE username = :username";
        $cmd = $db->prepare($sql);
        $cmd->bindParam(':username', $username, PDO::PARAM_STR, 100);
        $cmd->execute();
        $user = $cmd->fetch();

        if ($user) {
            echo '<p class="alert alert-danger">User already exists</p>';
        }
        else {
            // set up SQL INSERT
            $sql = "INSERT INTO examusers (username, password) VALUES (:username, :password)";
            $cmd = $db->prepare($sql);

            // hash the password & fill params
            $password = password_hash($password, PASSWORD_DEFAULT);
            $cmd->bindParam(':username', $username, PDO::PARAM_STR, 100);
            $cmd->bindParam(':password', $password, PDO::PARAM_STR, 128);

            // save to db
            $cmd->execute();

            // confirmation
            echo '<h1>Registration Saved</h1><p>Click <a href="login.php">Login</a> to enter the site</p>';
        }

        // disconnect
        $db = null;
}

include 'footer.php';
?>

