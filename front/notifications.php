<?php

session_start();
require_once('./config.php');

$layout = 'notifications';
$template = basename(__FILE__);

render_view($template,$layout);

?>