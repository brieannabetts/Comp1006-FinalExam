<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Saving your Profile</title>
</head>
<body>
<?php
// 1. store the form inputs in variables (optional but reduces syntax errors)
$photo = $_POST['photo'];
$ok = true;

if ($ok) {
    // 2. connect to db
    include 'db.php';

    // 3. set up an SQL INSERT command w/2 parameters that have : prefixes
    $sql = "INSERT INTO examusers";

    // 4. populate the INSERT with our variables using a Command variable to prevent SQL Injection
    $cmd = $db->prepare($sql);
    $cmd->bindParam(':name', $photo, PDO::PARAM_STR, 50);

    // 5. execute the INSERT to save the data
    $cmd->execute();

    // 6. disconnect
    $db = null;

    // 7. show confirmation message to user
    echo "<h1>Profile Saved</h1>";
    header('location:profile.php');
}

?>
</body>
</html>
