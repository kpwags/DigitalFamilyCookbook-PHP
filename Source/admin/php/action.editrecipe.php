<?php
session_start();

include_once ('../../php/class.security.php');
$Security = new Security();

$Security->CheckSession();

include_once ('../../php/class.recipe.php');
$Recipe = new Recipe();

$recipe_id = $_POST['recipe_id'];
$name = $_POST['name'];
$source = $_POST['source'];
$source_url = $_POST['source_url'];
$servings = $_POST['servings'];
$time = $_POST['time'];
$active_time = $_POST['active_time'];
$calories = $_POST['calories'];
$saturated_fat = $_POST['saturated_fat'];
$total_fat = $_POST['total_fat'];
$cholesterol = $_POST['cholesterol'];
$protein = $_POST['protein'];
$carbohydrates = $_POST['carbohydrates'];
$sodium = $_POST['sodium'];
$fiber = $_POST['fiber'];
$ingredients = $_POST['ingredient'];
$steps = $_POST['step'];
$categories = $_POST['category'];
$meats = $_POST['meat'];

$result = $Recipe->EditRecipe($recipe_id, $name, $source, $source_url, $servings, $time, $active_time, $calories, $saturated_fat, $total_fat, $cholesterol, $protein, $carbohydrates, $sodium, $fiber, $ingredients, $steps, $categories, $meats);
if ($result['result'] != "SUCCESS") {
    $_SESSION['messages'] = $result['messages'];
    header("Location: /admin/edit-recipe/$recipe_id?error");
    exit();
} else {
    session_destroy();
    header("Location: /admin/edit-recipe/$recipe_id?success");
    exit();
}
?>