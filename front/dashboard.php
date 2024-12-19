<?php 
    session_start();
    require_once('./config.php');

    $layout = 'dashboard';
    $template = basename(__FILE__);

    if(!is_user_logged_in()){
        header('Location: /sign-in/');
    }

    render_view($template, $layout);
?>