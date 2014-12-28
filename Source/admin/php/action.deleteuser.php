<?php
    include_once ('../../php/class.security.php');
    $Security = new Security();

    $Security->CheckAdminSession();

    $user_id = $_GET['user_id'];

    include_once ('../../php/class.user.php');
    $User = new User();

    $User->DeleteUser($user_id);

    header("Location: /admin/users?user-deleted");
    exit();
?>