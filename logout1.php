<?php

require_once 'startsession.php';

if(isset($_SESSION['user_id']))
{
    unset($_SESSION['user_id']);
}

session_destroy(); //deletes all session variables! might need to be changed

header("Location: login1.php");

