<?php
    /**
     * Class dealing with recipes
     *
     * @package RecipeWebiste
     * @subpackage Recipe
     * @since 1.0.0
     */
    class Recipe
    {
        function __construct() { 
            require_once 'class.database.php'; 

            require_once 'class.utilities.php';
            $this->Utilities = new Utilities();

            require_once 'class.security.php';
            $this->Security = new Security();
        }

        function __destruct() { }
        function __clone() { }

        /**
         * Gets the number of recipes for each letter of the alphabet
         * @access public
         * @return array Array with each letter of the alphabet and the value being the count
         * @since 1.0.0
         */
        public function GetRecipeCountByLetter() {
            $query = "CALL spRecipeByLetterGet()";
            $result = Database::Query($query);

            $letter = $result->fetch_assoc();

            Database::FreeResult();
            return $letter;
        }

        /**
         * Gets the recipe categories from the database
         * @access public
         * @return array Array consisting of all the categories
         * @since 1.0.0
         */
        public function GetCategories() {
            $query = "SELECT CategoryId, Name, URLName FROM Category ORDER BY Name ASC";
            $result = Database::Query($query);

            if ($result) {
                $categories = array();
                while ($row = $result->fetch_assoc()) {
                    $category['id'] = $row['CategoryId'];
                    $category['name'] = stripslashes($row['Name']);
                    $category['urlname'] = stripslashes($row['URLName']);
                    $category['count'] = $this->GetRecipeCategoryCount($row['CategoryId']);
                    
                    array_push($categories, $category);
                }
            } else {
                return false;
            }

            return $categories;
        }

        /**
         * Gets the number of recipes with the specified category
         * @access public
         * @param int $cagtegory_id Category PK
         * @return int Recipe count
         * @since 1.0.0
         */
        public function GetRecipeCategoryCount($category_id) {
            $category_id = Database::EscapeInput($category_id);
            $query = "SELECT COUNT(*) AS Count FROM Recipe r INNER JOIN RecipeCategory rc ON rc.RecipeId = r.RecipeId WHERE rc.CategoryId = $category_id";
            $result = Database::Query($query);

            if ($result) {
                $row = $result->fetch_assoc();
                return $row['Count'];
            } else {
                return 0;
            }
        }

        /**
         * Gets the recipe meats from the database
         * @access public
         * @return array Array consisting of all the meats
         * @since 1.0.0
         */
        public function GetMeats() {
            $query = "SELECT MeatId, Name, URLName FROM Meat ORDER BY Name ASC";
            $result = Database::Query($query);

            if ($result) {
                $meats = array();
                while ($row = $result->fetch_assoc()) {
                    $meat['id'] = $row['MeatId'];
                    $meat['name'] = stripslashes($row['Name']);
                    $meat['urlname'] = stripslashes($row['URLName']);
                    $meat['count'] = $this->GetRecipeMeatCount($row['MeatId']);
                    
                    array_push($meats, $meat);
                }
            } else {
                return false;
            }

            return $meats;
        }

        /**
         * Gets the number of recipes with the specified meat
         * @access public
         * @param int $meat_id Meat PK
         * @return int Recipe count
         * @since 1.0.0
         */
        public function GetRecipeMeatCount($meat_id) {
            $meatid = Database::EscapeInput($meat_id);
            $query = "SELECT COUNT(*) AS Count FROM Recipe r INNER JOIN RecipeMeat rm ON rm.RecipeId = r.RecipeId WHERE rm.MeatId = $meat_id";
            $result = Database::Query($query);

            if ($result) {
                $row = $result->fetch_assoc();
                return $row['Count'];
            } else {
                return 0;
            }
        }

        public function GetCountByTime($min, $max = 'MAX') {
            $min = Database::EscapeInput($min);
            $max = Database::EscapeInput($max);

            if ($max == 'MAX') {
                $query = "SELECT COUNT(*) AS Count FROM Recipe WHERE ActiveTime >= $min";
            } else {
                $query = "SELECT COUNT(*) AS Count FROM Recipe WHERE ActiveTime >= $min AND ActiveTime <= $max";
            }

            $result = Database::Query($query);

            if ($result) {
                $row = $result->fetch_assoc();
                return $row['Count'];
            } else {
                return 0;
            }
        }

        public function GetRecipesByLetter($letter) {
            $letter = strtoupper(Database::EscapeInput($letter));
            $query = "SELECT RecipeId, Name FROM Recipe WHERE Name LIKE '" . $letter . "%' ORDER BY Name ASC";
            $result = Database::Query($query);

            if ($result) {
                $recipes = array();
                while ($row = $result->fetch_assoc()) {
                    $recipe['recipeid'] = $row['RecipeId'];
                    $recipe['name'] = stripslashes($row['Name']);
                    $recipe['urlname'] = $this->Utilities->ConvertToUrl($recipe['name']);

                    array_push($recipes, $recipe);
                }
            } else {
                return false;
            }

            return $recipes;
        }

        public function GetAllRecipes($page_number = 1) {
            $query = "SELECT COUNT(RecipeId) AS RecipeCount FROM Recipe";
            $result = Database::Query($query);

            $row = $result->fetch_assoc();

            $num_recipes = $row['RecipeCount'];

            $limits = $this->Utilities->CalculateLimits($page_number, $num_recipes);
            
            $offset = $limits['offset'];
            $limit = $limits['limit'];

            $query = "SELECT RecipeId, Name FROM Recipe ORDER BY Name"; // LIMIT $offset, $limit";
            $result = Database::Query($query);

            if ($result && $result->num_rows > 0) {
                $recipes = array();

                while ($row = $result->fetch_assoc()) {
                    $recipe['RecipeId'] = $row['RecipeId'];
                    $recipe['Name'] = stripslashes($row['Name']);

                    array_push($recipes, $recipe);
                }

                return $recipes;
            } else {
                return false;
            }
        }

        public function AddRecipe($name, $source, $source_url, $servings, $time, $active_time, $calories, $saturated_fat, $total_fat, $cholesterol, $protein, $carbohydrates, $sodium, $fiber, $ingredients, $steps, $categories, $meats) {
            $messages = array();
            $result = true;

            if ($name == '') {
                array_push($messages, 'Name is required');
                $result =  false;
            }

            $has_ingredients = false;
            foreach ($ingredients as $ingredient) {
                if ($ingredient != "") {
                    $has_ingredients = true;
                }
            }

            if (!$has_ingredients) {
                array_push($messages, 'At least one (1) ingredient is required');
                $result = false;
            }

            $has_steps = false;
            foreach ($steps as $step) {
                if ($step != "") {
                    $has_steps = true;
                }
            }

            if (!$has_steps) {
                array_push($messages, 'At least one (1) step is required');
                $result = false;
            }

            if ($result) {
                $name = Database::EscapeInput($name);
                $source = Database::EscapeInput($source);
                $source_url = Database::EscapeInput($source_url);
                $servings = Database::EscapeInput($servings);
                $time = Database::EscapeInput($time);
                $active_time = Database::EscapeInput($active_time);
                $calories = Database::EscapeInput($calories);
                $saturated_fat = Database::EscapeInput($saturated_fat);
                $total_fat = Database::EscapeInput($total_fat);
                $cholesterol = Database::EscapeInput($cholesterol);
                $protein = Database::EscapeInput($protein);
                $carbohydrates = Database::EscapeInput($carbohydrates);
                $sodium = Database::EscapeInput($sodium);
                $fiber = Database::EscapeInput($fiber);

                $currentUser = $this->Security->GetUserID();

                $query = "INSERT INTO Recipe (Name, Source, SourceURL, Servings, Time, ActiveTime, Calories, SaturatedFat, TotalFat, Cholesterol, Protein, Sodium, Fiber, Carbohydrates, AddedByUserId) VALUES ('$name', '$source', '$source_url', '$servings', '$time', '$active_time', '$calories', '$saturated_fat', '$total_fat', '$cholesterol', '$protein', '$sodium', '$fiber', '$carbohydrates', $currentUser)";
                $result = Database::Insert($query);

                if ($result) {
                    $recipe_id = $result;

                    // add ingredients
                    $i = 1;
                    foreach ($ingredients as $ingredient) {
                        $ingredient = Database::EscapeInput($ingredient);

                        if ($ingredient != "") {
                            $query = "INSERT INTO RecipeIngredient(RecipeId, Ingredient, SortOrder) VALUES ($recipe_id, '$ingredient', $i)";
                            Database::Insert($query);

                            $i++;
                        }
                    }

                    // add steps
                    $i = 1;
                    foreach ($steps as $step) {
                        $step = Database::EscapeInput($step);

                        if ($step != "") {
                            $query = "INSERT INTO RecipeStep(RecipeId, StepText, SortOrder) VALUES ($recipe_id, '$step', $i)";
                            Database::Insert($query);

                            $i++;
                        }
                    }

                    // add categories
                    foreach ($categories as $category_id) {
                        $category_id = Database::EscapeInput($category_id);

                        $query = "INSERT INTO RecipeCategory(RecipeId, CategoryId) VALUES ($recipe_id, $category_id)";
                        Database::Insert($query);
                    }

                    // add meats
                    foreach ($meats as $meat_id) {
                        $meat_id = Database::EscapeInput($meat_id);

                        $query = "INSERT INTO RecipeMeat(RecipeId, MeatId) VALUES ($recipe_id, $meat_id)";
                        Database::Insert($query);
                    }

                    return array('result' => 'SUCCESS', 'messages' => array());
                } else {
                    return array('result' => 'ERROR', 'messages' => array('Error executing SQL query'));
                }
            } else {
                return array('result' => 'ERROR', 'messages' => $messages);
            }
        }

        public function GetRecipeDetails($recipe_id) {
            $recipe_id = Database::EscapeInput($recipe_id);

            $query = "SELECT r.Name, r.Source, r.SourceURL, r.Servings, r.Time, r.ActiveTime, r.Calories, r.SaturatedFat, r.TotalFat, r.Cholesterol, r.Protein, r.Sodium, r.Fiber, r.Carbohydrates, u.Name AS 'PersonName' FROM Recipe r INNER JOIN User u ON u.UserId = r.AddedByUserId WHERE r.RecipeId = $recipe_id LIMIT 0, 1";
            $result = Database::Query($query);

            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();

                $recipe['recipe_id'] = $recipe_id;

                $recipe['name'] = stripslashes($row['Name']);
                $recipe['source'] = stripslashes($row['Source']);
                $recipe['source_url'] = stripslashes($row['SourceURL']);
                $recipe['servings'] = stripslashes($row['Servings']);
                $recipe['time'] = stripslashes($row['Time']);
                $recipe['active_time'] = stripslashes($row['ActiveTime']);
                $recipe['calories'] = stripslashes($row['Calories']);
                $recipe['saturated_fat'] = stripslashes($row['SaturatedFat']);
                $recipe['total_fat'] = stripslashes($row['TotalFat']);
                $recipe['cholesterol'] = stripslashes($row['Cholesterol']);
                $recipe['protein'] = stripslashes($row['Protein']);
                $recipe['sodium'] = stripslashes($row['Sodium']);
                $recipe['fiber'] = stripslashes($row['Fiber']);
                $recipe['carbohydrates'] = stripslashes($row['Carbohydrates']);
                $recipe['person_name'] = stripslashes($row['PersonName']);

                $recipe['ingredients'] = array();
                $ingredient_query = "SELECT Ingredient FROM RecipeIngredient WHERE RecipeId = $recipe_id ORDER BY SortOrder";
                $ingredient_result = Database::Query($ingredient_query);

                if ($ingredient_result && $ingredient_result->num_rows > 0) {
                    while ($ingredient_row = $ingredient_result->fetch_assoc()) {
                        array_push($recipe['ingredients'], stripslashes($ingredient_row['Ingredient']));
                    }
                }

                $recipe['steps'] = array();
                $step_query = "SELECT StepText FROM RecipeStep WHERE RecipeId = $recipe_id ORDER BY SortOrder";
                $step_result = Database::Query($step_query);

                if ($step_result && $step_result->num_rows > 0) {
                    while ($step_row = $step_result->fetch_assoc()) {
                        array_push($recipe['steps'], stripslashes($step_row['StepText']));
                    }
                }

                $recipe['categories'] = array();
                $category_query = "SELECT CategoryId FROM RecipeCategory WHERE RecipeId = $recipe_id";
                $category_result = Database::Query($category_query);

                if ($category_result && $category_result->num_rows > 0) {
                    while ($category_row = $category_result->fetch_assoc()) {
                        array_push($recipe['categories'], stripslashes($category_row['CategoryId']));
                    }
                }

                $recipe['meats'] = array();
                $meat_query = "SELECT MeatId FROM RecipeMeat WHERE RecipeId = $recipe_id";
                $meat_result = Database::Query($meat_query);

                if ($meat_result && $meat_result->num_rows > 0) {
                    while ($meat_row = $meat_result->fetch_assoc()) {
                        array_push($recipe['meats'], stripslashes($meat_row['MeatId']));
                    }
                }

                return $recipe;
            } else {
                return false;
            }
        }

        public function EditRecipe($recipe_id, $name, $source, $source_url, $servings, $time, $active_time, $calories, $saturated_fat, $total_fat, $cholesterol, $protein, $carbohydrates, $sodium, $fiber, $ingredients, $steps, $categories, $meats) {
            $messages = array();
            $result = true;

            if ($recipe_id == '') {
                array_push($messages, 'Recipe ID not specified');
                $result = false;
            }

            if ($name == '') {
                array_push($messages, 'Name is required');
                $result =  false;
            }

            $has_ingredients = false;
            foreach ($ingredients as $ingredient) {
                if ($ingredient != "") {
                    $has_ingredients = true;
                }
            }

            if (!$has_ingredients) {
                array_push($messages, 'At least one (1) ingredient is required');
                $result = false;
            }

            $has_steps = false;
            foreach ($steps as $step) {
                if ($step != "") {
                    $has_steps = true;
                }
            }

            if (!$has_steps) {
                array_push($messages, 'At least one (1) step is required');
                $result = false;
            }

            if ($result) {
                $recipe_id = Database::EscapeInput($recipe_id);
                $name = Database::EscapeInput($name);
                $source = Database::EscapeInput($source);
                $source_url = Database::EscapeInput($source_url);
                $servings = Database::EscapeInput($servings);
                $time = Database::EscapeInput($time);
                $active_time = Database::EscapeInput($active_time);
                $calories = Database::EscapeInput($calories);
                $saturated_fat = Database::EscapeInput($saturated_fat);
                $total_fat = Database::EscapeInput($total_fat);
                $cholesterol = Database::EscapeInput($cholesterol);
                $protein = Database::EscapeInput($protein);
                $carbohydrates = Database::EscapeInput($carbohydrates);
                $sodium = Database::EscapeInput($sodium);
                $fiber = Database::EscapeInput($fiber);

                $currentUser = $this->Security->GetUserID();

                $query = "UPDATE Recipe SET 
                                Name = '$name', 
                                Source = '$source', 
                                SourceURL = '$source_url',
                                Servings = '$servings',
                                Time = '$time',
                                ActiveTime = '$active_time',
                                Calories = '$calories',
                                SaturatedFat = '$saturated_fat',
                                TotalFat = '$total_fat',
                                Cholesterol = '$cholesterol',
                                Protein = '$protein',
                                Carbohydrates = '$carbohydrates',
                                Sodium = '$sodium',
                                Fiber = '$fiber'
                            WHERE RecipeId = $recipe_id";
                $result = Database::ExecuteNonQuery($query);

                if ($result) {
                    // first, delete all ingredients
                    $query = "DELETE FROM RecipeIngredient WHERE RecipeId = $recipe_id";
                    $result = Database::ExecuteNonQuery($query);

                    if ($result) {
                        // add ingredients
                        $i = 1;
                        foreach ($ingredients as $ingredient) {
                            $ingredient = Database::EscapeInput($ingredient);

                            if ($ingredient != "") {
                                $query = "INSERT INTO RecipeIngredient(RecipeId, Ingredient, SortOrder) VALUES ($recipe_id, '$ingredient', $i)";
                                Database::Insert($query);

                                $i++;
                            }
                        }
                    } else {
                        return array('result' => 'ERROR', 'messages' => array('Error executing SQL query'));
                    }

                    // first, delete all steps
                    $query = "DELETE FROM RecipeStep WHERE RecipeId = $recipe_id";
                    $result = Database::ExecuteNonQuery($query);

                    if ($result) {
                        // add steps
                        $i = 1;
                        foreach ($steps as $step) {
                            $step = Database::EscapeInput($step);

                            if ($step != "") {
                                $query = "INSERT INTO RecipeStep(RecipeId, StepText, SortOrder) VALUES ($recipe_id, '$step', $i)";
                                Database::Insert($query);

                                $i++;
                            }
                        }
                    } else {
                        return array('result' => 'ERROR', 'messages' => array('Error executing SQL query'));
                    }

                    // first, delete all categories
                    $query = "DELETE FROM RecipeCategory WHERE RecipeId = $recipe_id";
                    $result = Database::ExecuteNonQuery($query);

                    if ($result) {
                        // add categories
                        foreach ($categories as $category_id) {
                            $category_id = Database::EscapeInput($category_id);

                            $query = "INSERT INTO RecipeCategory(RecipeId, CategoryId) VALUES ($recipe_id, $category_id)";
                            Database::Insert($query);
                        }
                    } else {
                        return array('result' => 'ERROR', 'messages' => array('Error executing SQL query'));
                    }

                    // first, delete all meats
                    $query = "DELETE FROM RecipeMeat WHERE RecipeId = $recipe_id";
                    $result = Database::ExecuteNonQuery($query);

                    if ($result) {
                        // add meats
                        foreach ($meats as $meat_id) {
                            $meat_id = Database::EscapeInput($meat_id);

                            $query = "INSERT INTO RecipeMeat(RecipeId, MeatId) VALUES ($recipe_id, $meat_id)";
                            Database::Insert($query);
                        }
                    } else {
                        return array('result' => 'ERROR', 'messages' => array('Error executing SQL query'));
                    }

                    return array('result' => 'SUCCESS', 'messages' => array());
                } else {
                    return array('result' => 'ERROR', 'messages' => array('Error executing SQL query'));
                }
            } else {
                return array('result' => 'ERROR', 'messages' => $messages);
            }
        }

        public function DeleteRecipe($recipe_id) {
            // delete all ingredients
            $query = "DELETE FROM RecipeIngredient WHERE RecipeId = $recipe_id";
            Database::ExecuteNonQuery($query);

            // delete all steps
            $query = "DELETE FROM RecipeStep WHERE RecipeId = $recipe_id";
            Database::ExecuteNonQuery($query);

            // delete all categories
            $query = "DELETE FROM RecipeCategory WHERE RecipeId = $recipe_id";
            Database::ExecuteNonQuery($query);

            // delete all meats
            $query = "DELETE FROM RecipeMeat WHERE RecipeId = $recipe_id";
            Database::ExecuteNonQuery($query);

            // delete actual recipe
            $query = "DELETE FROM Recipe WHERE RecipeId = $recipe_id";
            Database::ExecuteNonQuery($query);
        }

        /**
         * Utilities Class Object
         * @access protected
         * @var Utilities
         * @since 1.0.0
         */
        protected $Utilities;

        /**
         * Security Class Object
         * @access protected
         * @var Security
         * @since 1.0.0
         */
        protected $Security;
    }
?>