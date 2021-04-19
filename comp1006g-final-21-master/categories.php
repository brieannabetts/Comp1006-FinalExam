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
            $db =null;
            include 'footer-unfixed.php';
            ?>
        </select>
        <button class="btn btn-primary">Search</button>
        <a class="btn btn-primary" href="categories.php">Clear</a>
    </form>
    <nav>categories</nav>
</section>
