<?php
// json api to fetch the current grocery list
// connect
require '../db.php';

// add an optional category parameter
$category = null;
if (!empty($_GET['category'])) {
    $category = $_GET['category'];
}

// set up the query
$sql = "SELECT examitems.*, examcategories.name FROM examitems
INNER JOIN examcategories ON examitems.categoryId = examcategories.categoryId";

if ($category != null) {
    $sql .= " WHERE categories.name = :category";
}

// run the query & fetch results as an array
$cmd = $db->prepare($sql);

if ($category != null) {
    $cmd->bindParam(':category', $category, PDO::PARAM_STR, 50);
}
$cmd->execute();
$items = $cmd->fetchAll(PDO::FETCH_ASSOC);

// convert the array to json and display
echo json_encode($items);

$db = null;
?>