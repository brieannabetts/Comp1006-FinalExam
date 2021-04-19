<?php
$pageTitle = "Saving...";
include 'header.php';

// auth check
include 'auth.php';

// 1. store the form inputs in variables (optional but reduces syntax errors)
$name = $_POST['name'];
$quantity = $_POST['quantity'];
$categoryId = $_POST['categoryId'];
$itemId = $_POST['itemId']; // hidden field; blank when adding, has value when editing
$ok = true;



// 1a. validate inputs before saving
if (empty(trim($name))) {
    echo 'Name is required<br />';
    $ok = false;
}

if (empty($quantity)) {
    echo 'Quantity is required<br />';
    $ok = false;
}
else {
    if (!is_numeric($quantity)) {
        echo 'Quantity must be a number<br />';
        $ok = false;
    }
    else {
        if ($quantity < 1) {
            echo 'Quantity must be greater than zero';
            $ok = false;
        }
    }
}

if (empty($categoryId)) {
    echo 'Category is required<br />';
    $ok = false;
}
else {
    if (!is_numeric($categoryId)) {
        echo 'Category must be a number<br />';
        $ok = false;
    }
    else {
        if ($categoryId < 1) {
            echo 'Category must be greater than zero';
            $ok = false;
        }
    }
}

if (!empty($_FILES['photo']['name'])) {
    // check that upload is an image
    $type = mime_content_type($_FILES['photo']['tmp_name']);
    if ($type != 'image/jpeg' && $type != 'image/png') {
        echo 'Invalid file type<br />';
        $ok = false;
    }
    else {
        // give file a unique name & save to img/item-uploads
        $photo = session_id() . "-" . $_FILES['photo']['name'];
        move_uploaded_file($_FILES['photo']['tmp_name'], "img/item-uploads/$photo");
    }
}
else {
    $photo = $_POST['currentPhoto']; // keep existing photo if nothing uploaded
}

if ($ok) {
    //try {
        // 2. connect to db
        include 'db.php';

        // 3. set up an SQL command w/parameters that have : prefixes
        if (empty($itemId)) {
            $sql = "INSERT INTO examitems (name, quantity, categoryId, photo) 
            VALUES (:name, :quantity, :categoryId, :photo)";
        }
        else {
            $sql = "UPDATE examitems SET name = :name, quantity = :quantity, 
                 categoryId = :categoryId, photo = :photo 
                WHERE itemId = :itemId";
        }

        // 4. populate the INSERT with our variables using a Command variable to prevent SQL Injection
        $cmd = $db->prepare($sql);
        $cmd->bindParam(':name', $name, PDO::PARAM_STR, 50);
        $cmd->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $cmd->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
        $cmd->bindParam(':photo', $photo, PDO::PARAM_STR, 100);

        // fill itemId param if editing existing record
        if (!empty($itemId)) {
            $cmd->bindParam(':itemId', $itemId, PDO::PARAM_INT);
        }
        // 5. execute the SQL command to save the data
        $cmd->execute();

        // 6. disconnect
        $db = null;
  /*  }
    catch (exception $e) {
        header('location:error.php');
    } */

    // 7. show confirmation message to user
    //echo "<h1>Item Saved</h1>";
    header('location:items.php');
}
?>
</body>
</html>
