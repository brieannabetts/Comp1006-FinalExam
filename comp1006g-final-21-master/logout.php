<?php
// access current session
session_start();

// remove all session variables
session_unset();

// terminate the session
session_destroy();

// redirect to login
header('location:login.php');
exit();
?>
