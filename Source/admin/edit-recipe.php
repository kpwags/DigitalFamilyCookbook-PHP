<?php
    session_start();

    include_once ('../php/class.settings.php');
    $Settings = new Settings();

    include_once ('../php/class.security.php');
    $Security = new Security();

    include_once ('../php/class.recipe.php');
    $Recipe = new Recipe();

    if (!isset($_GET['recipe_id'])) {
        // no ID, error
        header("Location: error");
        exit();
    }

    $recipe_id = $_GET['recipe_id'];
    $recipe = $Recipe->GetRecipeDetails($recipe_id);

    if (!$recipe) {
        // error
        header("Location: error");
        exit();
    }

    $Security->CheckAdminSession();
?>

<!DOCTYPE html>
<html>
    <head>
        <base href="<?php echo $Settings->GetRootURL(); ?>" />
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0, minimal-ui" />
        <title>Edit Recipe | <?php echo $Settings->GetSiteTitle(); ?></title>
        <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="styles/header.css">
        <link rel="stylesheet" type="text/css" href="styles/recipes.css">
        <script type="text/javascript" src="scripts/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="scripts/utilities.js"></script>
        <script type="text/javascript" src="scripts/formhelper.js"></script>
        <script type="text/javascript" src="admin/scripts/recipeadmin.js"></script>
    </head>
    <body>
        <?php include ('../elements/header-large.php'); ?>
        <?php include ('../elements/admin-menu.php'); ?>

        <div class="container">
            <h1>Edit Recipe: <?php echo $recipe['name']; ?></h1>

            <?php if (isset($_GET['error'])) { ?> <p class="error">There were errors saving the recipe.</p> <?php } ?>
            <?php if (isset($_GET['success'])) { ?> <p class="success">Recipe Saved.</p> <?php } ?>

            <?php if (isset($_SESSION['messages']) && $_SESSION['messages'] != '') { ?>
                <ul class="errors">
                <?php foreach ($_SESSION['messages'] as $message) { ?>
                    <li><span><?php echo $message; ?></span></li>
                <?php } ?>
                </ul>
            <?php } ?>

            <ul class="errors" id="client-side-errors">

            </ul>

            <form action="admin/php/action.editrecipe.php" method="post" onsubmit="return RecipeAdmin.validateCreateRecipe()">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?php echo $recipe['name']; ?>"/>
                </div>

                <div class="form-group">
                    <label>Added By: <?php echo $recipe['person_name']; ?></label>
                </div>

                <div class="form-group">
                    <label for="source">Source</label>
                    <input type="text" class="form-control" id="source" name="source" placeholder="Source" value="<?php echo $recipe['source']; ?>"/>
                </div>

                <div class="form-group">
                    <label for="source_url">Source URL</label>
                    <input type="text" class="form-control" id="source_url" name="source_url" placeholder="Source URL" value="<?php echo $recipe['source_url']; ?>"/>
                </div>

                <div class="form-group">
                    <label for="servings">Servings</label>
                    <input type="text" class="form-control" id="servings" name="servings" placeholder="Servings" value="<?php echo $recipe['servings']; ?>"/>
                </div>

                <div class="form-group">
                    <label for="time">Total Time (In Minutes)</label>
                    <input type="text" class="form-control" id="time" name="time" placeholder="Total Time" value="<?php echo $recipe['time']; ?>"/>
                </div>

                <div class="form-group">
                    <label for="active_time">Active Time (In Minutes)</label>
                    <input type="text" class="form-control" id="active_time" name="active_time" placeholder="Active Time" value="<?php echo $recipe['active_time']; ?>"/>
                </div>

                <hr/>

                <h2>Ingredients</h2>
                <?php
                    $i = 1;
                    foreach ($recipe['ingredients'] as $ingredient) {
                ?>
                        <div class="form-group">
                            <input type="text" class="form-control" id="ingredient<?php echo $i; ?>" name="ingredient[]" placeholder="Ingredient" value="<?php echo $ingredient; ?>"/>
                        </div>
                <?php
                        $i++;
                    }
                ?>
                <div id="additional-ingredients"></div>
                <div class="add-link"><a id="add-ingredient" data-val="<?php echo $i; ?>">+ Add Ingredient</a></div>

                <h2>Directions</h2>
                <?php
                    $i = 1;
                    foreach ($recipe['steps'] as $step) {
                ?>
                        <div class="form-group">
                            <input type="text" class="form-control" id="step<?php echo $i; ?>" name="step[]" placeholder="Step" value="<?php echo $step; ?>"/>
                        </div>
                <?php
                        $i++;
                    }
                ?>
                <div id="additional-steps"></div>
                <div class="add-link"><a id="add-step" data-val="<?php echo $i; ?>">+ Add Step</a></div>

                <hr/>

                <h2>Nutritional Information (per serving)</h2>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="source_url">Calories</label>
                            <input type="text" class="form-control" id="calories" name="calories" placeholder="Calories" value="<?php echo $recipe['calories']; ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="source_url">Saturated Fat (g)</label>
                            <input type="text" class="form-control" id="saturated_fat" name="saturated_fat" placeholder="Saturated Fat" value="<?php echo $recipe['saturated_fat']; ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="source_url">Total Fat (g)</label>
                            <input type="text" class="form-control" id="total_fat" name="total_fat" placeholder="Total Fat" value="<?php echo $recipe['total_fat']; ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="source_url">Cholesterol (mg)</label>
                            <input type="text" class="form-control" id="cholesterol" name="cholesterol" placeholder="Cholesterol" value="<?php echo $recipe['cholesterol']; ?>"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="source_url">Protein (g)</label>
                            <input type="text" class="form-control" id="protein" name="protein" placeholder="Protein" value="<?php echo $recipe['protein']; ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="source_url">Sodium (mg)</label>
                            <input type="text" class="form-control" id="sodium" name="sodium" placeholder="Sodium" value="<?php echo $recipe['sodium']; ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="source_url">Carbohydrates (g)</label>
                            <input type="text" class="form-control" id="carbohydrates" name="carbohydrates" placeholder="Carbohydrates" value="<?php echo $recipe['carbohydrates']; ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="source_url">Fiber (g)</label>
                            <input type="text" class="form-control" id="fiber" name="fiber" placeholder="Fiber" value="<?php echo $recipe['fiber']; ?>"/>
                        </div>
                    </div>
                </div>

                <hr/>

                <h2>Categories</h2>
                <?php
                    $categories = $Recipe->GetCategories();

                    $half = ceil(count($categories) / 2);
                ?>
                <div class="row">
                    <div class="col-md-6">
                        <?php for ($i = 0; $i < $half; $i++) { ?>
                            <?php if (in_array($categories[$i]['id'], $recipe['categories'])) { $checked = "checked"; } else { $checked = ""; } ?>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="category<?php echo $i; ?>" name="category[]" value="<?php echo $categories[$i]['id']; ?>" <?php echo $checked; ?>> <?php echo $categories[$i]['name']; ?>
                                </label>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6">
                        <?php for ($i = $half; $i < count($categories); $i++) { ?>
                            <?php if (in_array($categories[$i]['id'], $recipe['categories'])) { $checked = "checked"; } else { $checked = ""; } ?>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="category<?php echo $i; ?>" name="category[]" value="<?php echo $categories[$i]['id']; ?>" <?php echo $checked; ?>> <?php echo $categories[$i]['name']; ?>
                                </label>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <hr/>

                <h2>Meats</h2>
                <?php
                    $meats = $Recipe->GetMeats();

                    $half = ceil(count($meats) / 2);
                ?>
                <div class="row">
                    <div class="col-md-6">
                        <?php for ($i = 0; $i < $half; $i++) { ?>
                            <?php if (in_array($meats[$i]['id'], $recipe['meats'])) { $checked = "checked"; } else { $checked = ""; } ?>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="meat<?php echo $i; ?>" name="meat[]" value="<?php echo $meats[$i]['id']; ?>" <?php echo $checked; ?>> <?php echo $meats[$i]['name']; ?>
                                </label>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6">
                        <?php for ($i = $half; $i < count($meats); $i++) { ?>
                            <?php if (in_array($meats[$i]['id'], $recipe['meats'])) { $checked = "checked"; } else { $checked = ""; } ?>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="meat<?php echo $i; ?>" name="meat[]" value="<?php echo $meats[$i]['id']; ?>" <?php echo $checked; ?>> <?php echo $meats[$i]['name']; ?>
                                </label>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <hr/>

                <input type="hidden" name="recipe_id" value="<?php echo $recipe_id; ?>" />

                <button type="submit" class="btn btn-default">Save Changes</button>
            </form>
        </div>

        <?php include ('../elements/footer.php'); ?>
    </body>
</html>