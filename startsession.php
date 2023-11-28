<?php 


    session_set_cookie_params([
        'samesite' => 'Lax',
        'secure' => true,
        'httponly' => true

    ]); //we should prob make a config file instead of having this pasted in every doc

    session_start();

	include("connection1.php");
	include("functions1.php");

    if (!isset($_SESSION['ServGen'])) {
        session_destroy();
        session_start(); // Start a new session after destroying the old one
    }
    
    // Regenerate session ID only if the session is already started
    if (session_status() == PHP_SESSION_ACTIVE) {
        session_regenerate_id();
    }
    
    $_SESSION['ServGen'] = true;





