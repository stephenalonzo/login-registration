<?php 

// Dependencies go here
date_default_timezone_set('America/Los_Angeles');
session_start();

require_once ('./php/app.php');

foreach ($_REQUEST as $key => $value)
{

    switch ($key)
    {

        case 'register':
            userRegistration($conn);
        break;

        case 'login':
            userLogin($conn);
        break;

        case 'logout':
            userLogout();
        break;

    }

}

?>