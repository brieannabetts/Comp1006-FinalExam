<?php
$pageTitle = 'My Profile';
include 'header.php';
include 'auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile</title>
</head>
<body>
<h1>My Profile</h1>
<form method="post" action="save-profile.php">
    <fieldset>
    </fieldset>
    <button>Save</button>
</form>
</body>
</html>
<?php

    // connect
    include 'db.php';

    // fetch selected item
    $sql = "SELECT * FROM examusers";
    $cmd = $db->prepare($sql);
    $cmd->bindParam(':username', $username, PDO::PARAM_INT);
    $cmd->execute();
    $username = $cmd->fetch(); // use fetch for as single record

    if  (!$username) {
    echo '<div class="alert alert-danger">No User found</div>';
}
    else{
        echo "Username: " + $username;
}
    echo "Add profile picture: ";
 echo '<td>'; // show photo if any
    if (!empty($indPhoto['photo'])) {
    echo '<img src="img/profile-uploads/' . $indPhoto['photo'] . '"
               alt="Profile Photo" class="thumbnail" />';
    }
    echo '</td>';
    ?>
<button>ADD PICTURE</button>

<?php
$db =null;
include 'footer.php'; ?>


