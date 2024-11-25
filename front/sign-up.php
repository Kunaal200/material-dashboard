<?php
session_start();
require_once('./config.php');

$layout = 'auth';
$template = basename(__FILE__);
$postData = $_POST;

$requiredFields = array('email', 'password');

if (isset($_POST['submit']) && $_POST['submit'] == 'submitbtn') {
    $error = [];

    if (count($error) == 0) {

        $insert = $conn1->prepare("INSERT INTO users (`email`, `password`, `created`, `updated`) VALUES (?, ?, NOW(), NOW())");

        $insert->bind_param("ss", $_POST['email'], $_POST['password']);

        $insert->execute();
        echo $conn1->insert_id;
        $insert->close();
    }
}

render_view($template, $layout);