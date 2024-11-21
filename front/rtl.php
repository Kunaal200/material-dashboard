<?php 
    session_start();
    require_once('./config.php');

    $layout = 'rtl';
    $template = basename(__FILE__);

    render_view($template, $layout);
?>