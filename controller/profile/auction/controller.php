<?php
session_start();
$output = ['result'=>false, 'message'=>'','value'=>0];

// include requirements
include_once __DIR__.'/../../config.php';
include_once __DIR__.'/../../../model/users/users.php';
include_once __DIR__.'/../../../model/purchases/purchases.php';

$users = new Users($__connection);
$data  = $users->check(['username',$_SESSION[$__USER_DATA_SESSION_INDEX]['username']]);

if($data != null){

    $aid = $_SESSION['__CURRENT_AUCTION_ID'];
    $uid = $_SESSION[$__USER_DATA_SESSION_INDEX]['id'];

    $query = "select `soldStatus`,`winner` from `auctions` where `id` = '$aid' limit 1";
    $select = mysqli_query($__connection,$query);
    $data_0 = mysqli_fetch_array($select);
    if($data_0['soldStatus'] == 2 && ($data_0['winner'] == null || empty($data_0['winner'])))
    {
        $query_1 = "select `value`,`userId` from `bids` where `auctionId` = '$aid' order by `value` desc limit 1";
        $select_1 = mysqli_query($__connection,$query_1);
        $data_1 = mysqli_fetch_array($select_1);

        mysqli_query($__connection,"update `auctions` set `soldStatus` = '1', `soldPrice`='".$data_1['value']."' ,`winner`='".$data_1['userId']."' where `id` = '$aid'");

        $PUr = new Purchases($__connection);
        $PUr->add([$data_1['userId'],$aid,$data_1['value']]);

        $Usr = new Users($__connection);
        $Usr->updateCredit(-$data_1['value'],$data_1['userId']);

        $output = ['result'=>true, 'message'=>'', 'areYouWinner'=>($data_1['userId'] == $uid) ? true : false];
    }
    else
    {
        $query_1 = "select `winner`,`winnerSeen` from `auctions` where `id`='$aid' limit 1";
        $select_1 = mysqli_query($__connection,$query_1);
        $data_1 = mysqli_fetch_array($select_1);

        if($data_1['winner'] == $uid && $data_1['winnerSeen'] != 1){
            mysqli_query($__connection,"update `auctions` set `winnerSeen` = '1' where `id`='$aid'");
        }
        $output = ['result'=>true, 'message'=>'','seen'=>$data_1['winnerSeen'],'winner'=>($data_1['winner'] == $uid) ? true : false];
    }
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
