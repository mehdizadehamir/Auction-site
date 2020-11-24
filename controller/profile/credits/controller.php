<?php
session_start();
$output = ['result'=>false, 'message'=>'Warning: purchasing failed!, please try again later.'];
// request check
if(empty($_POST))
    die($output);

// include requirements
include_once __DIR__.'/../../config.php';
include_once __DIR__.'/../../../model/users/users.php';

// code statement
$credit = $_POST['credit'];

if(empty($credit)){
    die($output);
}

$users = new Users($__connection);
$data  = $users->check(['username',$_SESSION[$__USER_DATA_SESSION_INDEX]['username']]);

if($data != null){
    $uid = $_SESSION[$__USER_DATA_SESSION_INDEX]['id'];
    $updatedStatus = $users->updateCredit($credit,$uid);
    if($updatedStatus)
    {
        $output =
            [
                'result'=>true,
                'message'=>'$'.$credit.' has been added to your wallet.',
            ];
    }
    else
    {
        $output =
            [
                'result'=>false,
                'message'=>'Warning: purchasing failed!, please try again later.',
            ];
    }
}else{
    $output =
        [
            'result'=>false,
            'message'=>'Warning: purchasing failed!, please try again later.'
        ];
}

// out put
header('Content-Type: application/json');
echo json_encode($output);
return;
