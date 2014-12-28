<?php
    include_once ('php/class.recipe.php');
    $Recipe = new Recipe();

    include_once ('php/class.security.php');
    $Security = new Security();

    include_once ('php/class.settings.php');
    $Settings = new Settings();

    $type = $_GET['type'];
    $value = $_GET['value'];

    switch ($type) {
        case 'alphabetical':
            $recipes = $Recipe->GetRecipesByLetter($value);
            $page_title = "Recipes by Letter";
            break;
        case 'category':
            //$recipes = Recipe::GetRecipesByLetter($value);
            break;
        case 'meat':
            //$recipes = Recipe::GetRecipesByLetter($value);
            break;
        case 'time':
            //$recipes = Recipe::GetRecipesByLetter($value);
            break;
    }

    if (!$recipes) {
        //error
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <base href="<?php echo $Settings->GetRootURL(); ?>" />
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0, minimal-ui" />
        <title><?php echo $page_title . " | " . $Settings->GetSiteTitle(); ?></title>
        <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="styles/header.css">
        <link rel="stylesheet" type="text/css" href="styles/recipes.css">
        <script type="text/javascript" src="scripts/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="scripts/recipes.js"></script>
    </head>
    <body>
        <?php include ('elements/header-large.php'); ?>
        <?php include ('elements/menu.php'); ?>

        <div class="container">
            <ul class="recipe-list">
                <?php foreach ($recipes as $recipe) { ?>
                    <li><a href="recipe/<?php echo $recipe['recipeid']; ?>/<?php echo $recipe['urlname']; ?>"><?php echo $recipe['name']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </body>
</html>