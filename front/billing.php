<?php

session_start();
require_once('./config.php');

$layout = 'billing';
$template = basename(__FILE__);

render_view($template,$layout);

?>