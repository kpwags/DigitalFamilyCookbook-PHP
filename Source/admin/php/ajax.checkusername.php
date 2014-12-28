<?php
    header('Content-Type: application/json');

    include_once ('../../php/class.security.php');
    $Security = new Security();

    if ($Security->IsUserAdmin()) {
        include_once ('../../php/class.user.php');
        $User = new User();

        $username = $_GET['username'];

        if ($User->IsUsernameAvailable($username)) {
            echo json_encode(array("Result" => "SUCCESS",
                                    "Messages" => array("Username '$username' is available"),
                                    "Data" => array("available" => true)
                                    ));
        } else {
            echo json_encode(array("Result" => "SUCCESS",
                                    "Messages" => array("Username '$username' is not available"),
                                    "Data" => array("available" => false)
                                    ));
        }
    } else {
        // not an admin...shouldn't be here
        echo json_encode(array("Result" => "ERROR",
                                    "Messages" => array("Access denied"),
                                    "Data" => array()
                                    ));
    }
?>