<?php
$output = ['result'=>false, 'message'=>'Warning: creating account was failed, please try again later!'];

// request check
if(empty($_POST))
    die($output);

// include requirements
include_once __DIR__.'/../config.php';
include_once __DIR__.'/../../model/users/users.php';

// code statement
$username = $_POST['username'];
$password = $_POST['password'];

if(empty($username) || empty($password)){
    die($output);
}

$users = new Users($__connection);
$data  = $users->check(['username',$username]);

if($data != null){
    $output =
        [
            'result'=>false,
            'message'=>'Warning: this username already taken!'
        ];
}else{

    if($users->add([$username,strongPassword($password)])){
        $output =
            [
                'result'=>true,
                'message'=>'',
            ];
    }else{
        $output =
            [
                'result'=>false,
                'message'=>'Warning: creating account was failed, please try again later!',
            ];
    }}

// out put
header('Content-Type: application/json');
echo json_encode($output);
