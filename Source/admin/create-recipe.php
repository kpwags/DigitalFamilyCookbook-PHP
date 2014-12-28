<?php
    session_start();

    include_once ('../php/class.settings.php');
    $Settings = new Settings();

    include_once ('../php/class.security.php');
    $Security = new Security();

    include_once ('../php/class.recipe.php');
    $Recipe = new Recipe();

    $Security->CheckAdminSession();
?>

<!DOCTYPE html>
<html>
    <head>
        <base href="<?php echo $Settings->GetRootURL(); ?>" />
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0, minimal-ui" />
        <title>Create Recipe | <?php echo $Settings->GetSiteTitle(); ?></title>
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
            <h1>Create Recipe</h1>

            <?php if (isset($_SESSION['messages']) && $_SESSION['messages'] != '') { ?>
                <p class="error">There were errors creating the recipe.</p>
                <ul class="errors">
                <?php foreach ($_SESSION['messages'] as $message) { ?>
                    <li><span><?php echo $message; ?></span></li>
                <?php } ?>
                </ul>
            <?php } ?>

            <ul class="errors" id="client-side-errors">

            </ul>

            <form action="admin/php/action.createrecipe.php" method="post" onsubmit="return RecipeAdmin.validateCreateRecipe()">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                </div>

                <div class="form-group">
                    <label for="source">Source</label>
                    <input type="text" class="form-control" id="source" name="source" placeholder="Source">
                </div>

                <div class="form-group">
                    <label for="source_url">Source URL</label>
                    <input type="text" class="form-control" id="source_url" name="source_url" placeholder="Source URL">
                </div>

                <div class="form-group">
                    <label for="servings">Servings</label>
                    <input type="text" class="form-control" id="servings" name="servings" placeholder="Servings">
                </div>

                <div class="form-group">
                    <label for="time">Total Time (In Minutes)</label>
                    <input type="text" class="form-control" id="time" name="time" placeholder="Total Time">
                </div>

                <div class="form-group">
                    <label for="active_time">Active Time (In Minutes)</label>
                    <input type="text" class="form-control" id="active_time" name="active_time" placeholder="Active Time">
                </div>

                <hr/>

                <h2>Ingredients</h2>
                <div class="form-group">
                    <input type="text" class="form-control" id="ingredient1" name="ingredient[]" placeholder="Ingredient">
                </div>
                <div id="additional-ingredients"></div>
                <div class="add-link"><a id="add-ingredient" data-val="2">+ Add Ingredient</a></div>

                <h2>Directions</h2>
                <div class="form-group">
                    <input type="text" class="form-control" id="step1" name="step[]" placeholder="Step">
                </div>
                <div id="additional-steps"></div>
                <div class="add-link"><a id="add-step" data-val="2">+ Add Step</a></div>

                <hr/>

                <h2>Nutritional Information (per serving)</h2>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="source_url">Calories</label>
                            <input type="text" class="form-control" id="calories" name="calories" placeholder="Calories">
                        </div>
                        <div class="form-group">
                            <label for="source_url">Saturated Fat (g)</label>
                            <input type="text" class="form-control" id="saturated_fat" name="saturated_fat" placeholder="Saturated Fat">
                        </div>
                        <div class="form-group">
                            <label for="source_url">Total Fat (g)</label>
                            <input type="text" class="form-control" id="total_fat" name="total_fat" placeholder="Total Fat">
                        </div>
                        <div class="form-group">
                            <label for="source_url">Cholesterol (mg)</label>
                            <input type="text" class="form-control" id="cholesterol" name="cholesterol" placeholder="Cholesterol">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="source_url">Protein (g)</label>
                            <input type="text" class="form-control" id="protein" name="protein" placeholder="Protein">
                        </div>
                        <div class="form-group">
                            <label for="source_url">Sodium (mg)</label>
                            <input type="text" class="form-control" id="sodium" name="sodium" placeholder="Sodium">
                        </div>
                        <div class="form-group">
                            <label for="source_url">Carbohydrates (g)</label>
                            <input type="text" class="form-control" id="carbohydrates" name="carbohydrates" placeholder="Carbohydrates">
                        </div>
                        <div class="form-group">
                            <label for="source_url">Fiber (g)</label>
                            <input type="text" class="form-control" id="fiber" name="fiber" placeholder="Fiber">
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
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="category<?php echo $i; ?>" name="category[]" value="<?php echo $categories[$i]['id']; ?>"> <?php echo $categories[$i]['name']; ?>
                                </label>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6">
                        <?php for ($i = $half; $i < count($categories); $i++) { ?>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="category<?php echo $i; ?>" name="category[]" value="<?php echo $categories[$i]['id']; ?>"> <?php echo $categories[$i]['name']; ?>
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
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="meat<?php echo $i; ?>" name="meat[]" value="<?php echo $meats[$i]['id']; ?>"> <?php echo $meats[$i]['name']; ?>
                                </label>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6">
                        <?php for ($i = $half; $i < count($meats); $i++) { ?>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="meat<?php echo $i; ?>" name="meat[]" value="<?php echo $meats[$i]['id']; ?>"> <?php echo $meats[$i]['name']; ?>
                                </label>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <hr/>

                <button type="submit" class="btn btn-default">Create Recipe</button>
            </form>
        </div>

        <?php include ('../elements/footer.php'); ?>
    </body>
</html>