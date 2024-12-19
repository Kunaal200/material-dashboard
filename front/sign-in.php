<?php 
session_start();
require_once('./config.php');

if(is_user_logged_in()){
    header('Location: /dashboard/');
}

$layout = 'auth';
$template = basename(__FILE__); 

if (isset($_POST['action']) && $_POST['action'] == 'signin') {

    if($formData = validate_form()){
        $email = $formData['email'];
        $pwd = $formData['pwd'];
        $hashedPwd = md5($pwd);

        //Pa$$w0rd!
        //Check if user exists in database with same email id
        $sql = "SELECT `ID`, `email` FROM `users` WHERE `email` = ? AND `password` = ?";
        $select = $conn1-> prepare($sql);
        $select->bind_param("ss", $email, $hashedPwd);
        $select->execute();
        $res = $select->get_result();
        $result = $res->fetch_all(MYSQLI_ASSOC);
        $select->close();

        if(count($result)){

            $user = $result[0]; 

            $userData = get_userdata($user['ID']);

            $user = array_merge($user, $userData);

            $_SESSION['user'] = $user;
            $_SESSION['user_id'] = $user['ID'];

            send_json_response(true, '', $result);
        }else{
            $message = "No user account found. Please check your email id and password.";
            send_json_response(false, $message);
        }
    }
}

render_view($template, $layout);
?>