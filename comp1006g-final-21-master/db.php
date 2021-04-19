<?php
// aws
$db = new PDO('mysql:host=172.31.22.43;dbname=', '', '');

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
