
<?php
$pageTitle = "Category Details";
include 'header.php'; // header must go first as it calls session_start() which auth needs

// auth check
include 'auth.php';

// initialize $item variable
$item = null;
$item['name'] = null;
$item['quantity'] = null;
$item['categoryId'] = null;
$item['itemId'] = null;
$item['photo'] = null;

// check if there's an itemId URL param. If so, fetch this item for edit; if not not, show blank
if (!empty($_GET['categoryId'])) {
    if (is_numeric($_GET['categoryId'])) {
        $categories = $_GET['categoryId'];

        try {
            // connect
            include 'db.php';

            // fetch selected item
            $sql = "SELECT * FROM examcategories WHERE categoryId = :categoryId";
            $cmd = $db->prepare($sql);
            $cmd->bindParam(':categoryId', $categories, PDO::PARAM_INT);
            $cmd->execute();
            $item = $cmd->fetch(); // use fetch for as single record
        }
        catch (exception $e) {
            header('location:error.php');
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Category Details</title>
</head>
<body>
    <h1>Category</h1>
    <form method="post" action="save-category.php">
        <fieldset>
            <label for="category">Category Name: </label>
            <input name="category" id="category" required />
        </fieldset>
        <button>Save</button>
    </form>
</body>
</html>
<?php
// connect
include 'db.php';

// set up query to fetch categories
$sql = "SELECT * FROM examcategories ORDER BY name";

// set up & execute command
$cmd = $db->prepare($sql);
$cmd->execute();
$categories = $cmd->fetchAll();

// loop through the results adding each category to the dropdown list
foreach ($categories as $c) {
    // check if current category matches the item category when editing
    if ($item['categoryId'] == $c['categoryId']) {
        echo '<option selected value="' . $c['categoryId'] . '">' . $c['name'] . '</option>';
    }
    else {
        echo '<option value="' . $c['categoryId'] . '">' . $c['name'] . '</option>';
    }
}

// disconnect
$db = null;
?>
</select>
</fieldset>
</form>
</main>

<?php include 'footer.php'; ?>

