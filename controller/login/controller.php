<?php
session_start();
$output = ['result'=>false, 'message'=>'Warning: sign-in failed, please try again later!'];

// request check
if(empty($_POST))
    die($output);

// include requirements
include_once '../config.php';
include_once '../../model/users/users.php';

// code statement
$username = $_POST['username'];
$password = $_POST['password'];

if(empty($username) || empty($password)){
    die($output);
}

$users = new Users($__connection);
$data  = $users->checkLogin($username,strongPassword($password));

if($data != null){
    $_SESSION[$__USER_DATA_SESSION_INDEX] = $data;
    $output =
        [
            'result'=>true,
            'message'=>'',
        ];
}else{
    $output =
        [
            'result'=>false,
            'message'=>'Warning: the username or password is incorrect!'
        ];
}

// out put
header('Content-Type: application/json');
echo json_encode($output);
