<?php
    session_start();

    include_once ('../../php/class.security.php');
    $Security = new Security();

    $Security->CheckAdminSession();

    include_once ('../../php/class.user.php');
    $User = new User();

    $username = $_POST['username'];
    $email = $_POST['email_address'];
    $name = $_POST['name'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];
    $is_admin = $_POST['is_admin'];

    $result = $User->CreateUser($username, $email, $name, $password1, $password2, $is_admin);

    if ($result['result'] != "SUCCESS") {
        $_SESSION['messages'] = $result['messages'];
        header('Location: /admin/create-user?error');
        exit();
    } else {
        $_SESSION['messages'] = '';
        session_destroy();
        header('Location: /admin/users?useradded');
        exit();
    }
?>