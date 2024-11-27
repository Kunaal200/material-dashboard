<?php
session_start();
require_once('./config.php');

$layout = 'auth';
$template = basename(__FILE__);
$postData = $_POST;

$requiredFields = array('email', 'password');

if (isset($_POST['action']) && $_POST['action'] == 'signup') {
    $formData = $_POST;
    $email = $_POST['email'];
    $name = $_POST['name'];
    $pwd = $_POST['password'];

    //Check if user exists in database with same email id
    $sql = "SELECT * FROM `users` WHERE `email` = ?";
    $select = $conn1-> prepare($sql);
    $select->bind_param("s", $email);
    $select->execute();
    $res = $select->get_result();
    $result = $res->fetch_all(MYSQLI_ASSOC);
    $select->close();

    // debug_pre($result);

    if(count($result)){
        $response = array(
            "success" => false,
            "message" => "This user already exists.",
            "data" => []
        );
    }else{
        $response = array(
            "success" => true,
            "message" => "",
            "data" => $result
        );
    }

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);
    exit;
}

if (isset($_POST['submit']) && $_POST['submit'] == 'submitbtn') {
    $error = [];

    if (count($error) == 0) {

        $insert = $conn1->prepare("INSERT INTO users (`email`, `password`, `created`, `updated`) VALUES (?, ?, NOW(), NOW())");

        $insert->bind_param("ss", $_POST['email'], $_POST['password']);

        $insert->execute();
        // echo $conn1->insert_id;
        $insert->close();
    }
}

render_view($template, $layout);
?>