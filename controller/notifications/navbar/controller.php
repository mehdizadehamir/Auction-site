<?php
session_start();
$output = ['result'=>false, 'message'=>'Warning: please try again later!'];

// include requirements
include_once __DIR__.'/../../config.php';
include_once __DIR__.'/../../../model/notifications/badges/badges.php';

// code statement
$loginUserData = userLoginData();
if($loginUserData == null){
    $output = ['result'=>false, 'message'=>'Warning: please first login then try to send request!'];
}

$badges = new Badges($__connection,$loginUserData);
$output=
    [
        'result' => true,
        'message'=> '',
        'badges' => ['purchases'=>$badges->purchases(), 'sales'=>$badges->sellList()]
    ];

// out put
header('Content-Type: application/json');
echo json_encode($output);
