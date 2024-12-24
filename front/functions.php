<?php 

function render_view($template, $layout, $params = []){
    $view = __DIR__ . '/templates/'. $template;
    $layout = __DIR__ . '/layout/'. $layout . '.php';
    require_once($layout);
}
function debug_pre($input, $exit = false){
    echo "<pre>";
    print_r($input);
    echo "</pre>";
    if($exit === false){
        $exit;
    }
}

function validate_form(){

    // debug_pre($_POST);

    $args = array(
        'name' => array(
            "filter" => FILTER_VALIDATE_REGEXP,
            "flags" => FILTER_FLAG_STRIP_BACKTICK,
            "options" => array(
                "regexp" => "/^[A-Za-z\s]{1,}[\.]{0,1}[A-Za-z\s]{0,}$/"
            )
        ),
        'email' => array(
            "filter" => FILTER_VALIDATE_REGEXP,
            "flags" => FILTER_FLAG_STRIP_BACKTICK,
            "options" => array(
                "regexp" => "/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/"
            )
        ),
        'password' => array(
            "filter" => FILTER_VALIDATE_REGEXP,
            "options" => array(
                "regexp" => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/"
            )
        ),
        'pwd' => ''
    );

    $formData = filter_input_array(INPUT_POST, $args);
    // debug_pre($formData);
    $valid = true;
    $message = '';

    foreach ($formData as $formKey => $formInput) {
        if(isset($_POST[$formKey])){
            if($formKey == 'email' && empty($formInput)){
                $message = "This is not a valid email id. Please submit your real email id.";
                $valid = false;
            }
    
            if($formKey == 'name' && empty($formInput)){
                $message = "Name contains invalid charachters. Please submit your real full name.";
                $valid = false;
            }
    
            if($formKey == 'password' && empty($formInput)){
                $message = "Password should be min 8 charachters long having atleast 1 speacial charachter, 1 numeric, 1 uppercase & 1 lowercase charachter.";
                $valid = false;
            }
        }
    }

    if($valid === false){
        send_json_response(false, $message);
    }else{
        return $formData;
    }
}

function send_json_response(bool $success = false, string $message = '', array $data = []){
    $response =  array(
        "success" => $success,
        "message" => $message,
        "data" => $data
    );

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);
    exit;
}

function is_user_logged_in(){
    if(isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0){
        return true;
    }

    return false;
}

function current_user(){
    return $_SESSION['user_id'] ?? false;
}

function get_userdata($user_id = null){

    global $conn1;
    if(!$user_id){
        $user_id = current_user();
    }

    if($user_id){
        $sql = "SELECT * FROM `userdata` WHERE `user_id` = ?";
        $select = $conn1-> prepare($sql);
        $select->bind_param("s", $user_id);
        $select->execute();
        $res = $select->get_result();
        $result = $res->fetch_all(MYSQLI_ASSOC);
        $select->close();

        $userData = [];

        foreach ($result as $datarow) {
            $dataKey = $datarow['datakey'];
            $dataValue = $datarow['datavalue'];
            $userData[$dataKey] = $dataValue;
        }

        return $userData;
    }
    
    return [];
}

function get_route(){
    $url = $_SERVER['REQUEST_URI'];

    $url = strtok($url, '?');

    return $url;
}

function is_current_route($route = ''){
    return $route === get_route();
}

function load_template_styles($template){
    $fileName = str_replace('.php', '', $template);
    $stylePath = BASEPATH . '/assets/js/pages/'.$fileName . '.css';

    if(file_exists($stylePath)){
        $styleURL = str_replace(BASEPATH, BASEURL, $stylePath);
        echo '<link href="'.$styleURL.'" />';
    }
}

function load_template_scripts($template){
    $fileName = str_replace('.php', '', $template);
    $scriptPath = BASEPATH . '/assets/js/pages/'.$fileName . '.js';
    if(file_exists($scriptPath)){
        $scriptURL = str_replace(BASEPATH, BASEURL, $scriptPath);
        echo "<script src='".$scriptURL."'></script>";
    }
}
?>