<?php
    require_once ('class.security.php');
    $Security = new Security();

    $Security->LogoutUser();
    header ("Location: /");
    exit();
?>