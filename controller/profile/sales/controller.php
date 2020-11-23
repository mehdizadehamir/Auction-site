<?php
session_start();
$output = ['result'=>false, 'message'=>'Warning: creating new auction failed!, please try again later.'];
// request check
if(empty($_POST) || empty($_FILES)){
    echo json_encode($output);
    return;
}

// include requirements
include_once '../../config.php';
include_once '../../../model/users/users.php';

if(!isset($_SESSION[$__USER_DATA_SESSION_INDEX])){
    $output = ['result'=>false, 'message'=>'Warning: user must be login!'];
    echo json_encode($output);
    return;
}

// code statement
$name = $_POST['name'];
$price = intval($_POST['price']);
$image = $_FILES['image'];

if(($image['size'] / 1024) > 1024){
    $output = ['result'=>false, 'message'=>'Warning: max image size: 1MB'];
    echo json_encode($output);
    return;
}

if(!in_array($image['type'],['image/png','image/jpg','image/jpeg'])){
    $output = ['result'=>false, 'message'=>'Warning: valid images type: [.jpg, .png]'];
    echo json_encode($output);
    return;
}

$folder = '../../../resources/user-uploads/user-'.$_SESSION[$__USER_DATA_SESSION_INDEX]['username'];
if(!file_exists($folder)){
    mkdir($folder);
}

$newImageName = $_SESSION[$__USER_DATA_SESSION_INDEX]['id'].'-'.time().'-'.$_SESSION[$__USER_DATA_SESSION_INDEX]['username'];

$upload = move_uploaded_file($image['tmp_name'],$folder.'/'.$newImageName.'.'.str_replace('image/','',$image['type']));
if($upload){
    
    $output =
        [
            'result'=>true,
            'message'=>'',
        ];
}else{
    $output =
        [
            'result'=>false,
            'message'=>'Warning: creating new auction failed!, please try again later.',
            'error'=>$image['tmp_name']
        ];
}

// out put
header('Content-Type: application/json');
echo json_encode($output);
return;
