<?php
    session_start();

    include_once ('php/class.settings.php');
    $Settings = new Settings();

    include_once ('php/class.security.php');
    $Security = new Security();
?>

<!DOCTYPE html>
<html>
    <head>
        <base href="<?php echo $Settings->GetRootURL(); ?>" />
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0, minimal-ui" />
        <title>Login | <?php echo $Settings->GetSiteTitle(); ?></title>
        <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.min.css">
        <link rel="stylesheet" type="text/css" href="styles/header.css">
        <link rel="stylesheet" type="text/css" href="styles/recipes.css">
        <script type="text/javascript" src="scripts/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="scripts/recipes.js"></script>
    </head>
    <body>
        <?php include ('elements/header-large.php'); ?>
        <?php include ('elements/menu.php'); ?>

        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                <h1>Login</h1>

                    <div class="login-form">
                        <form action="php/action.login.php" method="post">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                            </div>

                            <button type="submit" class="btn btn-default">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>