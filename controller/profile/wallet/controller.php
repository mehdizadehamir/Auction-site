<?php
session_start();
$output = ['result'=>false, 'message'=>'','value'=>0];

// include requirements
include_once __DIR__.'/../../config.php';
include_once __DIR__.'/../../../model/users/users.php';

$users = new Users($__connection);
$data  = $users->check(['username',$_SESSION[$__USER_DATA_SESSION_INDEX]['username']]);

if($data != null){
    $output =
        [
            'result'=>false,
            'message'=>'',
            'value'=>$users->getWallet($_SESSION[$__USER_DATA_SESSION_INDEX]['id'])
        ];
}else{
    $output =
        [
            'result'=>false,
            'message'=>'',
            'value'=>0
        ];
}

// out put
header('Content-Type: application/json');
echo json_encode($output);
return;
