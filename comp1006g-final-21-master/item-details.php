<?php
$pageTitle = "Item Details";
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
if (!empty($_GET['itemId'])) {
    if (is_numeric($_GET['itemId'])) {
        $itemId = $_GET['itemId'];

        try {
            // connect
            include 'db.php';

            // fetch selected item
            $sql = "SELECT * FROM examitems WHERE itemId = :itemId";
            $cmd = $db->prepare($sql);
            $cmd->bindParam(':itemId', $itemId, PDO::PARAM_INT);
            $cmd->execute();
            $item = $cmd->fetch(); // use fetch for as single record
        }
        catch (exception $e) {
            header('location:error.php');
        }
    }
}

?>

    <main class="container">
        <h1>Grocery Item</h1>
        <form method="post" action="save-item.php" enctype="multipart/form-data">
            <fieldset class="form-group">
                <label for="name" class="col-2">Name: </label>
                <input name="name" id="name" required value="<?php echo $item['name']; ?>" />
            </fieldset>
            <fieldset class="form-group">
                <label for="quantity" class="col-2">Quantity: </label>
                <input name="quantity" id="quantity" required type="number" min="1" value="<?php echo $item['quantity']; ?>" />
            </fieldset>
            <fieldset class="form-group">
                <label for="categoryId" class="col-2">Category: </label>
                <select name="categoryId" id="categoryId">
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
            <fieldset class="form-group">
                <label for="photo" class="col-2">Photo:</label>
                <input type="file" name="photo" id="photo" accept=".jpg,.png,.jpeg" />
            </fieldset>
            <input type="hidden" name="itemId" id="itemId" value="<?php echo $item['itemId']; ?>" />
            <input type="hidden" name="currentPhoto" id="currentPhoto" value="<?php echo $item['photo']; ?>" />
            <?php
            // show current image if any
            if (!empty($item['photo'])) {
                echo '<img src="img/item-uploads/' . $item['photo'] . '"
                 alt="Item Photo" class="thumbnail offset-2" />';
            }
            ?>
            <div>
                <button class="offset-2 btn btn-primary">Save</button>
            </div>
        </form>
    </main>

<?php include 'footer.php'; ?>
