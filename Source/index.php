<?php
    include_once ('php/class.settings.php');
    $Settings = new Settings();

    include_once ('php/class.security.php');
    $Security = new Security();

    include_once ('php/class.recipe.php');
    $Recipe = new Recipe();

    $active_section = "alphabetical";
    if (isset($_GET['section'])) { $active_section = $_GET['section']; }
?>

<!DOCTYPE html>
<html>
    <head>
        <base href="<?php echo $Settings->GetRootURL(); ?>" />
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0, minimal-ui" />
        <title><?php echo $Settings->GetSiteTitle(); ?></title>
        <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="styles/header.css">
        <link rel="stylesheet" type="text/css" href="styles/recipes.css">
        <script type="text/javascript" src="scripts/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="scripts/recipes.js"></script>
    </head>
    <body>
        <?php include ('elements/header-large.php'); ?>
        <div class="menu">
            <div class="container">
                <ul>
                    <li id="alphabetical-item" <?php if ($active_section == "alphabetical") { ?>class="active" <?php } ?>><a onclick="gotoSection('alphabetical')">Alphabetical</a></li>
                    <li id="category-item" <?php if ($active_section == "category") { ?>class="active" <?php } ?>><a onclick="gotoSection('category')">By Category</a></li>
                    <li id="meat-item" <?php if ($active_section == "meat") { ?>class="active" <?php } ?>><a onclick="gotoSection('meat')">By Meat</a></li>
                    <li id="time-item" <?php if ($active_section == "time") { ?>class="active" <?php } ?>><a onclick="gotoSection('time')">By Time</a></li>
                    <li id="search"><a>Search</a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
        </div>

        <div class="container">
            <div class="section <?php if ($active_section == "alphabetical") { ?>active<?php } ?>" id="alphabetical">
                <?php
                    $letter = $Recipe->GetRecipeCountByLetter();
                ?>
                <h1>By Alphabetical Order</h1>
                <div class="row">
                    <div class="col-md-6">
                        <ul class="category-list">
                            <li><a href="recipes/alphabetical/a">A</a> <span class="count">(<?php echo $letter['A']; ?> Recipes)</span></li>
                            <li><a href="recipes/alphabetical/b">B</a> <span class="count">(<?php echo $letter['B']; ?> Recipes)</span></li>
                            <li><a href="recipes/alphabetical/c">C</a> <span class="count">(<?php echo $letter['C']; ?> Recipes)</span></li>
                            <li><a href="recipes/alphabetical/d">D</a> <span class="count">(<?php echo $letter['D']; ?> Recipes)</span></li>
                            <li><a href="recipes/alphabetical/e">E</a> <span class="count">(<?php echo $letter['E']; ?> Recipes)</span></li>
                            <li><a href="recipes/alphabetical/f">F</a> <span class="count">(<?php echo $letter['F']; ?> Recipes)</span></li>
                            <li><a href="recipes/alphabetical/g">G</a> <span class="count">(<?php echo $letter['G']; ?> Recipes)</span></li>
                            <li><a href="recipes/alphabetical/h">H</a> <span class="count">(<?php echo $letter['H']; ?> Recipes)</span></li>
                            <li><a href="recipes/alphabetical/i">I</a> <span class="count">(<?php echo $letter['I']; ?> Recipes)</span></li>
                            <li><a href="recipes/alphabetical/j">J</a> <span class="count">(<?php echo $letter['J']; ?> Recipes)</span></li>
                            <li><a href="recipes/alphabetical/k">K</a> <span class="count">(<?php echo $letter['K']; ?> Recipes)</span></li>
                            <li><a href="recipes/alphabetical/l">L</a> <span class="count">(<?php echo $letter['L']; ?> Recipes)</span></li>
                            <li><a href="recipes/alphabetical/m">M</a> <span class="count">(<?php echo $letter['M']; ?> Recipes)</span></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="category-list">
                            <li><a href="recipes/alphabetical/n">N</a> <span class="count">(<?php echo $letter['N']; ?> Recipes)</span></li>
                            <li><a href="recipes/alphabetical/o">O</a> <span class="count">(<?php echo $letter['O']; ?> Recipes)</span></li>
                            <li><a href="recipes/alphabetical/p">P</a> <span class="count">(<?php echo $letter['P']; ?> Recipes)</span></li>
                            <li><a href="recipes/alphabetical/q">Q</a> <span class="count">(<?php echo $letter['Q']; ?> Recipes)</span></li>
                            <li><a href="recipes/alphabetical/r">R</a> <span class="count">(<?php echo $letter['R']; ?> Recipes)</span></li>
                            <li><a href="recipes/alphabetical/s">S</a> <span class="count">(<?php echo $letter['S']; ?> Recipes)</span></li>
                            <li><a href="recipes/alphabetical/t">T</a> <span class="count">(<?php echo $letter['T']; ?> Recipes)</span></li>
                            <li><a href="recipes/alphabetical/u">U</a> <span class="count">(<?php echo $letter['U']; ?> Recipes)</span></li>
                            <li><a href="recipes/alphabetical/v">V</a> <span class="count">(<?php echo $letter['V']; ?> Recipes)</span></li>
                            <li><a href="recipes/alphabetical/w">W</a> <span class="count">(<?php echo $letter['W']; ?> Recipes)</span></li>
                            <li><a href="recipes/alphabetical/x">X</a> <span class="count">(<?php echo $letter['X']; ?> Recipes)</span></li>
                            <li><a href="recipes/alphabetical/y">Y</a> <span class="count">(<?php echo $letter['Y']; ?> Recipes)</span></li>
                            <li><a href="recipes/alphabetical/z">Z</a> <span class="count">(<?php echo $letter['Z']; ?> Recipes)</span></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="section <?php if ($active_section == "category") { ?>active<?php } ?>" id="category">
                <?php
                    $categories = $Recipe->GetCategories();

                    $half = ceil(count($categories) / 2);
                ?>
                <h1>By Category</h1>
                <div class="row">
                    <div class="col-md-6">
                        <ul class="category-list">
                            <?php for ($i = 0; $i < $half; $i++) { ?>
                                <li><a href="recipes/category/<?php echo $categories[$i]['urlname']; ?>"><?php echo $categories[$i]['name']; ?></a> <span class="count">(<?php echo $categories[$i]['count']; ?> Recipes)</span></li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="category-list">
                            <?php for ($i = $half; $i < count($categories); $i++) { ?>
                                <li><a href="recipes/category/<?php echo $categories[$i]['urlname']; ?>"><?php echo $categories[$i]['name']; ?></a> <span class="count">(<?php echo $categories[$i]['count']; ?> Recipes)</span></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="section <?php if ($active_section == "meat") { ?>active<?php } ?>" id="meat">
                <?php
                    $meats = $Recipe->GetMeats();

                    $half = ceil(count($meats) / 2);
                ?>
                <h1>By Type of Meat</h1>
                <div class="row">
                    <div class="col-md-6">
                        <ul class="category-list">
                            <?php for ($i = 0; $i < $half; $i++) { ?>
                                <li><a href="recipes/meat/<?php echo $meats[$i]['urlname']; ?>"><?php echo $meats[$i]['name']; ?></a> <span class="count">(<?php echo $meats[$i]['count']; ?> Recipes)</span></li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="category-list">
                            <?php for ($i = $half; $i < count($meats); $i++) { ?>
                                <li><a href="recipes/meat/<?php echo $meats[$i]['urlname']; ?>"><?php echo $meats[$i]['name']; ?></a> <span class="count">(<?php echo $meats[$i]['count']; ?> Recipes)</span></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="section <?php if ($active_section == "time") { ?>active<?php } ?>" id="time">
                <?php
                    
                ?>
                <h1>By Active Time Taken</h1>
                <div class="row">
                    <div class="col-md-6">
                        <ul class="category-list">
                            <li><a href="recipes/time/under-30">Under 30 Minutes</a> <span class="count">(<?php echo $Recipe->GetCountByTime(0, 30); ?> Recipes)</span></li>
                            <li><a href="recipes/time/30-60">30 to 60 Minutes</a> <span class="count">(<?php echo $Recipe->GetCountByTime(31, 60); ?> Recipes)</span></li>
                            <li><a href="recipes/time/60-90">1 to 1.5 Hours</a> <span class="count">(<?php echo $Recipe->GetCountByTime(61, 90); ?> Recipes)</span></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="category-list">
                            <li><a href="recipes/time/90-120">1.5 to 2 Hours</a> <span class="count">(<?php echo $Recipe->GetCountByTime(91, 120); ?> Recipes)</span></li>
                            <li><a href="recipes/time/120-plus">2+ Hours</a> <span class="count">(<?php echo $Recipe->GetCountByTime(120); ?> Recipes)</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <?php include ('elements/footer.php'); ?>
    </body>
</html>