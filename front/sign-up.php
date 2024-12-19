<?php
session_start();
require_once('./config.php');

if(is_user_logged_in()){
    header('Location: /dashboard/');
}

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
                $userData = array(
                    'name' => $name,
                    'dob' => date('d-m-Y H:i:s')
                );

                $insertUserData = $conn1->prepare("INSERT INTO userdata (`user_id`, `datakey`, `datavalue`) VALUES (?, ?, ?)");
                foreach ($userData as $datakey => $datavalue) {
                    $insertUserData->bind_param("sss", $insert_id, $datakey, $datavalue);
                    $insertUserData->execute();
                }

                $insertUserData->close();

                $_SESSION['user'] = array(
                    'ID' => $insert_id,
                    'name' => $name,
                    'email' => $email,
                    'dob' => $userData['dob']
                );

                $_SESSION['user_id'] = $insert_id;

                send_json_response(true, '', ['insert_id' => $insert_id]);

            }else{
                $message = "Unexpected signup issue. Please try again later.";
                send_json_response(false, $message);
            }
        }
    }
}

render_view($template, $layout);
?>