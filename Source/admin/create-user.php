<?php
    session_start();

    include_once ('../php/class.settings.php');
    $Settings = new Settings();

    include_once ('../php/class.security.php');
    $Security = new Security();

    $Security->CheckAdminSession();
?>

<!DOCTYPE html>
<html>
    <head>
        <base href="<?php echo $Settings->GetRootURL(); ?>" />
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0, minimal-ui" />
        <title>Create User | <?php echo $Settings->GetSiteTitle(); ?></title>
        <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="styles/header.css">
        <link rel="stylesheet" type="text/css" href="styles/recipes.css">
        <script type="text/javascript" src="scripts/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="scripts/utilities.js"></script>
        <script type="text/javascript" src="scripts/formhelper.js"></script>
        <script type="text/javascript" src="admin/scripts/useradmin.js"></script>
    </head>
    <body>
        <?php include ('../elements/header-large.php'); ?>
        <?php include ('../elements/menu.php'); ?>

        <div class="container">
            <h1>Create User</h1>

            <?php if (isset($_SESSION['messages']) && $_SESSION['messages'] != '') { ?>
                <p class="error">There were errors creating the user.</p>
                <ul class="errors">
                <?php foreach ($_SESSION['messages'] as $message) { ?>
                    <li><span><?php echo $message; ?></span></li>
                <?php } ?>
                </ul>
            <?php } ?>

            <ul class="errors" id="client-side-errors">

            </ul>

            <form action="admin/php/action.createuser.php" method="post" onsubmit="return Admin.validateCreateUser()">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" />
                </div>

                <div class="form-group">
                    <label for="email_address">Email Address</label>
                    <input type="email" class="form-control" id="email_address" name="email_address" placeholder="Email Address">
                </div>

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                </div>

                <div class="form-group">
                    <label for="username">Password</label>
                    <input type="password" class="form-control" id="password1" name="password1" placeholder="Password">
                </div>

                <div class="form-group">
                    <label for="username">Re-Enter Password</label>
                    <input type="password" class="form-control" id="password2" name="password2" placeholder="Re-Enter Password">
                </div>

                <div class="checkbox">
                    <label>
                        <input type="checkbox" id="is_admin" name="is_admin" value="true"> Is Administrator
                    </label>
                </div>

                <button type="submit" class="btn btn-default">Create User</button>
            </form>
        </div>

        <?php include ('../elements/footer.php'); ?>
    </body>
</html>