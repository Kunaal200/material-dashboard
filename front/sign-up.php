<?php
session_start();
require_once('./config.php');

$layout = 'auth';
$template = basename(__FILE__);
$postData = $_POST;

$requiredFields = array('email', 'password');

if (isset($_POST['action']) && $_POST['action'] == 'signup') {

    if($formData = validate_form()){
        $email = $formData['email'];
        $name = $formData['name'];
        $pwd = $formData['password'];
        $hashedPwd = md5($pwd);


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
            $message = "This user already exists.";
            send_json_response(false, $message);
        }else{
            $insert = $conn1->prepare("INSERT INTO users (`email`, `password`, `created`, `updated`) VALUES (?, ?, NOW(), NOW())");

            $insert->bind_param("ss", $email, $hashedPwd);

            $insert->execute();
            // echo $conn1->insert_id;
            $insert_id = $conn1->insert_id;
            $insert->close();
            if($insert_id > 0){
                $datakey = 'name';
                $insertUserData = $conn1->prepare("INSERT INTO userdata (`user_id`, `datakey`, `datavalue`) VALUES (?, ?, ?)");
                $insertUserData->bind_param("sss", $insert_id, $datakey, $name);
                $insertUserData->execute();
                $insertUserData->close();

                send_json_response(true, '', ['insert_id' => $insert_id]);
            }else{
                $message = "Unexpected signup issue. Please try again later.";
                send_json_response(false, $message);
            }
        }
    }
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