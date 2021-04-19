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
//connect
include 'db.php';
$sql ="SELECT username FROM examusers";
$cmd = $db->prepare($sql);
$cmd->execute();
$username = $cmd->fetchAll();
if (!$username){
    echo '<div class="alert alert-danger">No User found</div>';
}
else{
    echo '<table class="table table-striped table-light sortable">
    <thead>
                <th><a>User</a></th>';

}
$db =null;
?>
<?php include 'footer.php'; ?>


