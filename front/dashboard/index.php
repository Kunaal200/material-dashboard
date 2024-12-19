<?php 
    session_start();
    require_once('../config.php');

    $layout = 'dashboard';
    $template = 'dashboard.php';

    if(!is_user_logged_in()){
        header('Location: /sign-in/');
    }

    render_view($template, $layout);
?>