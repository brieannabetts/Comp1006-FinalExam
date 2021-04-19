<?php $pageTitle = "Categories";
include 'header.php'; ?>

    <h1>Categories</h1>
<?php
// session_start called in header above; only call once per page
if (!empty($_SESSION['username'])) {
    echo '<a href="categories-details.php">Category Details</a>';
}
?>
<section>
    <form action="categories.php">
        <select name="categoryId" id="categoryId">
            <option value="-1">-Select Category-</option>
            <?php
            // 1. Connect to the db.  Host: 172.31.22.43, DB: dbNameHere, Username: usernameHere, PW: passwordHere
            include 'db.php';

            $sql = "SELECT * FROM examcategories ORDER BY name";
            $cmd = $db->prepare($sql);
            $cmd->execute();
            $categories = $cmd->fetchAll();

            foreach ($categories as $c) {
                if ($c['categoryId'] == $categories) {
                    echo '<option value="' . $c['categoryId'] . '" selected>' . $c['name'] . '</option>';
                } else {
                    echo '<option value="' . $c['categoryId'] . '">' . $c['name'] . '</option>';
                }
            }
            ?>
        </select>
        <button class="btn btn-primary">Search</button>
        <a class="btn btn-primary" href="categories.php">Clear</a>
    </form>
    <nav>categories</nav>
</section>
<?php

//  2. Write the SQL Query to read all the records from the artists table and store in a variable
$sql = "SELECT examitems.*, examcategories.name AS category FROM examitems
        LEFT OUTER JOIN examcategories on examitems.categoryId = examcategories.categoryId";

// 3. Create a Command variable $cmd then use it to run the SQL Query
$cmd = $db->prepare($sql);


if ($categories != null) {
    $cmd->bindParam(':categoryId', $categories, PDO::PARAM_INT);
}

$cmd->execute();

// 4. Use the fetchAll() method of the PDO Command variable to store the data into a variable called $items.  See for details.
$categories = $cmd->fetchAll();

if (!$categories) {
    echo '<div class="alert alert-danger">No items found</div>';
}
else {
    // 5. Use a foreach loop to iterate (cycle) through all the values in the $items variable.  Inside this loop, use an echo command to display the name of each item.  See https://www.php.net/manual/en/control-structures.foreach.php for details.
    // start an HTML table for formatting BEFORE the foreach loop
    echo '<table class="table table-striped table-light sortable">
            <thead>
                <th><a href="#">Category</a></th>
                <th><a href="#">Name</a></th>
                <th><a href="#">Quantity</a></th>
                <th></th>';

    if (!empty($_SESSION['username'])) {
        echo '<th>Actions</th>';
    }

    echo '</thead>';

    foreach ($categories as $indCategories) {
        // must use "return" to evaluate the confirm method to decide if the link should fire or not
        echo '<tr><td>' . $indCategories['category'] . '</td>';

        if (!empty($_SESSION['username'])) {
            echo '<td><a href="category-details.php?categoryId=' . $indCategories['categoryId'] .
                '">' . $indCategories['name'] . '</a></td>';
        } else {
            echo '<td>' . $indCategories['name'] . '</td>';
        }
        echo '</td>';

        if (!empty($_SESSION['username'])) {
            echo '<td><a href="category-details.php?categoryId=' . $indCategories['categoryId'] .
                '" class="btn btn-secondary">Edit</a>&nbsp;
                    <a href="delete-item.php?itemId=' . $indCategories['categoryId'] .
                '" class="btn btn-danger" title="Delete"
                    onclick="return confirmDelete();">Delete</a></td>';
        }
        echo '</tr>';
    }

    // close the table
    echo '</table>';
}

// 6. Disconnect from the database
$db = null;
//}
//catch (exception $e) {
/* mail('me@email.com', 'Lamp Food Error', $e,
    'From:contact@lampfood.com'); */
//    header('location:error.php');
//}

include 'footer-unfixed.php';
?>


