<?php
    include_once ('../../php/class.security.php');
    $Security = new Security();

    $Security->CheckSession();

    $recipe_id = $_GET['recipe_id'];

    include_once ('../../php/class.recipe.php');
    $Recipe = new Recipe();

    $Recipe->DeleteRecipe($recipe_id);

    header("Location: /admin/index?recipe-deleted");
    exit();
?>