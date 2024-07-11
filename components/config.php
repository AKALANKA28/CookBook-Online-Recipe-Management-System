<?php
$db_host = 'localhost';
$db_name = 'reviews_db';
$db_user_name = 'root';
$db_user_pass = '';

$conn = new mysqli($db_host, $db_user_name, $db_user_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!function_exists('create_unique_id')) {
    function create_unique_id()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characters_length = strlen($characters);
        $random_string = '';
        for ($i = 0; $i < 20; $i++) {
            $random_string .= $characters[mt_rand(0, $characters_length - 1)];
        }
        return $random_string;
    }
}

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}


if (isset($_COOKIE['chef_id'])) {
    $chef_id = $_COOKIE['chef_id'];
} else {
    $chef_id = '';
}
?>
