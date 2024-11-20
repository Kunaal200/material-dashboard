<?php 
session_start();
require_once('./config.php');

$layout = 'virtual-reality';
$template = basename(__FILE__); 

render_view($template, $layout);
?>