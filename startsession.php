<?php 


    session_set_cookie_params([
        'samesite' => 'Lax', //Strict can be used instead
        'secure' => true,
        'httponly' => true

    ]); //is it enough to only have this in the php.ini file?

    /*if ($_SERVER['HTTPS'] !== 'on') {
        $redirect_url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header("Location: $redirect_url", true, 301);
        exit();
    } //might have to better this code - experimental - redirects to https always!
    */

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
    } //this should in theory protect a little against CSRF

    // Check if CSRF token is not set, generate one
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    
    $_SESSION['ServGen'] = true;





