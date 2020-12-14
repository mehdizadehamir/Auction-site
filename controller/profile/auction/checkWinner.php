<?php
session_start();
$output = ['result'=>false, 'message'=>'','value'=>0];

// include requirements
include_once __DIR__.'/../../config.php';

$users = new Users($__connection);
$data  = $users->check(['username',$_SESSION[$__USER_DATA_SESSION_INDEX]['username']]);

if($data != null){

    $aid = $_SESSION['__CURRENT_AUCTION_ID'];

    $q1 = "select `withdraw` from `auctions` where `id`='$aid' limit 1";
    $s1 = mysqli_query($__connection,$q1);
    $r1 = mysqli_fetch_array($s1);
    if($r1['withdraw'] == 0){
        $query = "update `users` set `wallet` = `wallet` - (select soldPrice from `auctions` where `id`='$aid') where `id`=(select winner from `auctions` where `id`='$aid')";
        @$select = mysqli_query($__connection,$query);
        @$select2 = mysqli_query($__connection,"update `auctions` set `withdraw` = '1' where `id`='$aid'");

        $output = ['result'=>$select, 'message'=>''];
    }else{
        $output = ['result'=>$select, 'message'=>'did withdraw already!'];
    }
}else{
    $output =
        [
            'result'=>false,
            'message'=>''
        ];
}

// out put
header('Content-Type: application/json');
echo json_encode($output);
return;
