<?php
    require_once ('class.security.php');
    $Security = new Security();

    if ($Security->LoginUser($_POST['username'], $_POST['password'])) {
        header ("Location: /admin/index");
        exit();
    } else {
        header ("Location: /login?error");
        exit();
    }
?>