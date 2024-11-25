<?php
    ini_set('display_errors', 1);

    ini_set('display_stratup_errors', 1);

    error_reporting(E_ALL);

    define('BASEPATH', __DIR__);

    require_once('./vendor/autoload.php');
    require_once('./functions.php');
    $dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
    $dotenv->load();

    $db = array(
        'mysql' => array(
            'host' => getenv('DB_HOST'),
            'user' => getenv('DB_USER'),
            'password' => getenv('DB_PWD'),
            'db' => getenv('DB_NAME')
        )
        );
    $mysql = $db['mysql'];

    $conn1 = new mysqli($mysql['host'], $mysql['user'], $mysql['password'], $mysql['db']);

    if ($conn1->connect_error) {
        die("Connection failed: " . $conn1->connect_error);
    }
    echo "Connected successfully";
?>