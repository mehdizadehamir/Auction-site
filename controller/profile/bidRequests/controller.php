<?php
session_start();
$output = ['result'=>false, 'message'=>'Warning: biding failed!, please try again later.'];
// request check

// include requirements
include_once __DIR__.'/../../config.php';
include_once __DIR__.'/../../../model/users/users.php';

$users = new Users($__connection);
$data  = $users->check(['username',$_SESSION[$__USER_DATA_SESSION_INDEX]['username']]);


if($data != null){

    if(empty($_POST['value']))
    {
        $output = ['result'=>false, 'message'=>'Warning: biding failed!, please send all needed parameters.'];
    }
    else
    {
        $val = mysqli_real_escape_string($__connection,intval($_POST['value']));
        $aid = $_SESSION['__CURRENT_AUCTION_ID'];
        $uid = $_SESSION[$__USER_DATA_SESSION_INDEX]['id'];

        $data_expire = mysqli_fetch_array(mysqli_query($__connection,"select `expireDate`,`price` from `auctions` where `id`='$aid' limit 1"));
        $updateExp = false;
        $continueee = true;
        if(empty($data_expire['expireDate']) || $data_expire['expireDate'] == null)
        {
            $updateExp = true;
        }
        else
        {
            if($data_expire['expireDate'] < time())
            {
                $continueee = false;
                $output = ['result'=>false, 'message'=>'Time is over!'];
            }
        }

        if($data_expire['price'] > $val)
        {
            $continueee = false;
            $output = ['result'=>false, 'message'=>'Warning: the minimum of every bid must be more than $'.$data_expire['price']];
        }

        if($continueee)
        {
            $wallet = $users->getWallet($_SESSION[$__USER_DATA_SESSION_INDEX]['id']);
            if($wallet-1 < $val)
            {
                $output = ['result'=>false, 'message'=>'Warning: your wallet credits is not enough to make this bid!'];
            }
            else
            {
                $checkAtLeast_query = mysqli_query($__connection,"select max(`value`) as atleast from `bids` where `auctionId` = '$aid' limit 1");
                $checkAtLeast = mysqli_fetch_array($checkAtLeast_query);
                if($val <= $checkAtLeast['atleast'])
                {
                    $output = ['result'=>false, 'message'=>'Warning: your bid must be more than ($'.$checkAtLeast['atleast'].') at least!'];
                }
                else
                {
                    $bidReqStatus = mysqli_query($__connection,"insert into `bids` (`userId`,`auctionId`,`value`) values ('$uid','$aid','$val')");
                    if($bidReqStatus)
                    {
                        $updatedStatus = $users->updateCredit(-1,$uid);
                        if($updatedStatus)
                        {
                            if($updateExp)
                            {
                                $exp = time() + (5 * 60);
                                mysqli_query($__connection,"update `auctions` set `expireDate` = '$exp' where `id`='$aid'");
                            }

                            $output = ['result'=>true, 'message'=>'-$1 deducted of your wallet.','exp'=>date('M d, Y H:i:s',$exp)];
                        }
                        else
                        {
                            $output = ['result'=>false, 'message'=>'Warning: biding failed!, please try again later.'];
                        }
                    }
                    else
                    {
                        $output = ['result'=>false, 'message'=>'Warning: biding failed!, please try again later.'];
                    }
                }
            }
        }

    }
}
else
{
    $output = ['result'=>false, 'message'=>'Warning: biding failed!, please try again later.'];
}

// out put
header('Content-Type: application/json');
echo json_encode($output);
