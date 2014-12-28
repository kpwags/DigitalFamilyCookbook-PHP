<?php
    include_once ('./../php/class.settings.php');
    $Settings = new Settings();

    include_once ('./../php/class.user.php');
    $User = new User();

    include_once ('../php/class.security.php');
    $Security = new Security();

    $Security->CheckAdminSession();

    $page_number = 1;
    if (isset($_GET['page'])) {
        $page_number = $_GET['page'];
    }

    $all_users = $User->GetUsers();
?>

<!DOCTYPE html>
<html>
    <head>
        <base href="<?php echo $Settings->GetRootURL(); ?>" />
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0, minimal-ui" />
        <title>Users | <?php echo $Settings->GetSiteTitle(); ?></title>
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
                    <li><a href="admin">Recipes</a></li>
                    <?php if ($Security->IsUserAdmin()) { ?>
                        <li><a href="admin/categories-and-meats">Recipe Categories &amp; Meats</a></li>
                        <li><a href="admin/create-user">Add User</a></li>
                        <li><a href="admin/edit-settings">Settings</a></li>
                    <?php } ?>
                </ul>
            </div>

            <?php if (isset($_GET['user-deleted'])) { ?> <p class="success">User Deleted.</p> <?php } ?>
            <?php if (isset($_GET['user-created'])) { ?> <p class="success">User Created.</p> <?php } ?>

            <div class="admin-table">
                <?php if ($all_users) { ?>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Username</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($all_users as $u) { ?>
                                <tr>
                                    <td width="35%"><?php echo $u['name']; ?></td>
                                    <td width="35%"><?php echo $u['username']; ?></td>
                                    <td width="15%" class="center-align"><a href="admin/edit-user/<?php echo $u['user_id']; ?>">Edit</a></td>
                                    <td width="15%" class="center-align"><a href="admin/php/action.deleteuser.php?user_id=<?php echo $u['user_id']; ?>" class="confirm-delete" data-val="<?php echo $u['name']; ?>">Delete</a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <p>No Users</p>
                <?php } ?>
            </div>
        </div>

        <?php include ('./../elements/footer.php'); ?>
    </body>
</html>