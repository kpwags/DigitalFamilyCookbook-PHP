<?php
    include_once ('./../php/class.settings.php');
    $Settings = new Settings();

    include_once ('./../php/class.recipe.php');
    $Recipe = new Recipe();

    include_once ('../php/class.security.php');
    $Security = new Security();

    $Security->CheckSession();

    $page_number = 1;
    if (isset($_GET['page'])) {
        $page_number = $_GET['page'];
    }

    $all_recipes = $Recipe->GetAllRecipes($page_number);
?>

<!DOCTYPE html>
<html>
    <head>
        <base href="<?php echo $Settings->GetRootURL(); ?>" />
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0, minimal-ui" />
        <title>Admin | <?php echo $Settings->GetSiteTitle(); ?></title>
        <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="styles/header.css">
        <link rel="stylesheet" type="text/css" href="styles/recipes.css">
        <script type="text/javascript" src="scripts/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="admin/scripts/admin.js"></script>
    </head>
    <body>
        <?php include ('./../elements/header-large.php'); ?>
        <?php include ('./../elements/admin-menu.php'); ?>
        
        <div class="container">
            <div class="admin-top-menu">
                <ul>
                    <li><a href="admin/create-recipe">Add Recipe</a></li>
                    <?php if ($Security->IsUserAdmin()) { ?>
                        <li><a href="admin/categories-and-meats">Recipe Categories &amp; Meats</a></li>
                        <li><a href="admin/users">Users</a></li>
                        <li><a href="admin/edit-settings">Settings</a></li>
                    <?php } ?>
                </ul>
            </div>

            <?php if (isset($_GET['recipe-deleted'])) { ?> <p class="success">Recipe Deleted.</p> <?php } ?>
            <?php if (isset($_GET['recipe-created'])) { ?> <p class="success">Recipe Created.</p> <?php } ?>

            <div class="admin-table">
                <?php if ($all_recipes) { ?>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($all_recipes as $r) { ?>
                                <tr>
                                    <td width="60%"><?php echo $r['Name']; ?></td>
                                    <td width="20%" class="center-align"><a href="admin/edit-recipe/<?php echo $r['RecipeId']; ?>">Edit</a></td>
                                    <td width="20%" class="center-align"><a href="admin/php/action.deleterecipe.php?recipe_id=<?php echo $r['RecipeId']; ?>" class="confirm-delete" data-val="<?php echo $r['Name']; ?>">Delete</a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <p>No Recipes</p>
                <?php } ?>
            </div>
        </div>

        <?php include ('./../elements/footer.php'); ?>
    </body>
</html>