<?php
session_start();
$output = ['result'=>false, 'message'=>'Warning: sign-in failed, please try again later!'];

// request check
if(empty($_POST))
{
    header('Content-Type: application/json');
    echo json_encode($output);
    return;
}

// include requirements
include_once __DIR__.'/../../config.php';
include_once __DIR__.'/../../../model/users/users.php';

// code statement
$userData = (!empty($_SESSION[$__USER_DATA_SESSION_INDEX])) ? $_SESSION[$__USER_DATA_SESSION_INDEX] : null;

if(empty($userData)){
    $output = ['result'=>false, 'message'=>'Warning: to show and make bids as well, you have to CreateAccount/Login to the site!'];
    header('Content-Type: application/json');
    echo json_encode($output);
    return;
}

$aId = mysqli_real_escape_string($__connection,intval($_POST['aId']));
$query = "select `auctions`.price as mainPrice, `users`.username, `bids`.* from `bids` left join `users` on (`users`.id = `bids`.userId) left join `auctions` on (`auctions`.id = `bids`.auctionId) where `bids`.auctionId = '$aId'";
$select = mysqli_query($__connection,$query);
if(mysqli_num_rows($select) <= 0){
    $output = ['result'=>false, 'message'=>'No one has made a bid yet! be the first.'];
    header('Content-Type: application/json');
    echo json_encode($output);
    return;
}

$bids = [];
while($row=mysqli_fetch_array($select))
{
    array_push($bids,$row);
}

// out put
header('Content-Type: application/json');
$output = ['result'=>true, 'message'=>'','data'=>$bids];
echo json_encode($output);
return;
