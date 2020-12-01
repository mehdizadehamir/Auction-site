<?php
session_start();
include_once "controller/config.php";

$user_login_data = userLoginData();


include_once "model/auctions/auctions.php";
$auctions = new Auctions($__connection);
$auctionId=get('id');
$auctionData = $auctions->selectOne();

$_SESSION['__CURRENT_AUCTION_ID'] = $auctionId;
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php include_once "view/main/meta.php"; ?>
    <title>xAuction | <?=$auctionData['name'];?></title>
    <!-- Bootstrap core CSS -->
    <link href="resources/bootstrap_4.5/css/bootstrap.min.css" rel="stylesheet">
    <link href="resources/css/pricing.css" rel="stylesheet">
    <link href="resources/css/style.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="resources/js/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="resources/js/scripts.js"></script>
</head>
<body>

<div class="fixed-bottom p-3 d-none" style="background: red; color: #ffffff" id="warningMessages">
    <div class="col-12 text-center col-md-6 mx-auto" style="font-size: 18px;"></div>
</div>

<?php include_once "view/main/navbar.php"; ?>
<?php include_once "view/main/header_auction.php"; ?>

<div class="px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center col-6">
    <?
        $freeToBid = true;
        $showBids = true;
        if(!empty($user_login_data['id'])){
            if(($user_login_data['id'] == $auctionData['userId']) || ($auctionData['soldStatus'] == 1)){
                $freeToBid = false;
            }
        }else{
            $freeToBid = false;
            $showBids = false;
        }
    ?>

    <div class="row mb-3">
        <div class="col-12 pl-0 pr-0">
            <div id="bidSenderBox" class="alert shadow" style="overflow: hidden;">
                <div id="bidSenderBoxLock" style="background: rgba(255,255,255,.8);z-index:2;position: absolute; width: 100%; height: 100%; top: 0; left: 0;overflow: hidden; <?= ($freeToBid) ? 'display:none;' : 'display:block;';?>"></div>
                <div class="row">
                    <div class="col-4 text-left">
                        <input id="valueForBidInput" type="text" class="form-control" placeholder="$0.00  (your bid value)" data-toggle="tooltip" data-placement="top" title="Tooltip on top">
                    </div>
                    <div class="col-2 text-left">
                        <button id="btnSendBid" onclick="send();" class="form-control btn btn-success">
                            <span>Send</span>
                        </button>
                    </div>
                    <div class="col-6 text-right">
                        <div class="form-control" style="background: none;border: none; font-size: 16px;">
                            <span>Your Credit</span>
                            &nbsp;
                            <span>($)</span>
                            <span class="font-weight-bold" id="myCredit">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="table-responsive" style="max-height: 400px;">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>($) Bid</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody id="tBodyT">
                    <tr id="loadingTr">
                        <td colspan="4" id="loadingTd"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    const _ajax_path_auctions_bids = '<?=$__CONTROLLERS.'main/auction/bids.php';?>';
    const aId = '<?=$auctionId;?>';

    $(document).ready(function () {
        $('#loadingTr > #loadingTd').html('<div style="color: #999;">' + __LOADING_SPAN + '&nbsp;<span style="font-size: 16px; color: #999;">Please wait to loading all the bids...</span></div>');
        callPostAJAX(_ajax_path_auctions_bids,{'aId':aId},function (response) {
            if(!response.result){
                $('#loadingTr > #loadingTd').html('<span style="font-size: 16px; color: #999;">'+ response.message +'</span>');
            }else{
                for(var i=0; i < response.data.length; i++){
                    const item = response.data[i];
                    addTableChild(getTableTrChild(item));
                    flashElement("#flash_id_"+ item.id);
                }
                $('#loadingTr > #loadingTd').html('');
            }
        });
    });

    function newBid(response) {

        $('#tBodyT > tr#loadingTr').remove();
        const cc = $('#tBodyT > tr').length;

        var item = response;
        item.id = (cc == 0) ? 0 : cc + 1;
        addTableChild(getTableTrChild(item));
        flashElement("#flash_id_"+ item.id);

        checkExpireDate(item.exp);
    }

    function addTableChild(child) {
        $('#tBodyT').prepend(child);
    }
    function getTableTrChild(item) {
        var child = '<tr id="flash_id_'+ item.id +'">';

        child       += '<td>';
        child       += item.id + 1;
        child       += '</td>';

        child       += '<td>';
        child       += item.username;
        child       += '</td>';

        child       += '<td>';
        child       += item.value;
        child       += '</td>';

        child       += '<td>';
        child       += item.bidDate;
        child       += '</td>';

        child    += '</tr>';

        return child;
    }
</script>

<?php include_once "view/main/footer.php"; ?>
<?php include_once "view/modals/messages.php"; ?>

</body>
<script src="resources/bootstrap_4.5/js/bootstrap.min.js"></script>

<script>
    const ajaxPathBidRequest = '<?=$__CONTROLLERS.'profile/bidRequests/controller.php';?>';
    const ajaxPathWalletRefresh = '<?=$__CONTROLLERS.'profile/wallet/controller.php';?>';
    const ajaxPathCheckWinner = '<?=$__CONTROLLERS.'profile/auction/controller.php';?>';
    var _requestCalling = false;

    function checkWinner() {
        console.log('---------- Start Cheking Winner ----------');
        callPostAJAX(ajaxPathCheckWinner,null,function (data) {
            console.log(data);
            if(data.result && data.winner && data.seen == 0){
                var bdy = '<div class="font-weight-bold pb-3" style="font-size: 16px;">Wow let`s celebrate!, you win this auction.</div>';
                bdy += '<div><img src="resources/images/winner.gif" style="width: 100%;" /></div>';
                showModal('#msgModal','Congratulation!',bdy,'#warnIdModal',null);
            }
        });
    }

    function refreshWalletValue() {
        callPostAJAX(ajaxPathWalletRefresh,null,function (data) {
            $('#myCredit').html(data.value);
        });
    }

    function requestForBid(value,callback){

        $('#valueForBidInput').tooltip('disable');
        $('#valueForBidInput').prop('title',"");
        $('#valueForBidInput').attr('data-original-title',"");

        const btnSend = $('#btnSendBid');
        const oldVal = btnSend.html();
        _requestCalling = true;
        btnSend.prop('disabled','disabled');
        btnSend.html(__LOADING_SPAN);
        callPostAJAX(ajaxPathBidRequest,{'value':value},function (data) {
            //alert(data);
            _requestCalling = false;
            if(!data.result){
                $('#valueForBidInput').tooltip('enable');
                $('#valueForBidInput').prop('title',data.message);
                $('#valueForBidInput').attr('data-original-title',data.message);
                $('#valueForBidInput').tooltip('show');

                btnSend.html(oldVal);
                btnSend.prop('disabled','');

            }else{
                expDateHaveToSend = data.exp;
                callback();
                refreshWalletValue();
                checkExpireDate(data.exp);
                btnSend.html(oldVal);
                setTimeout(function () {
                    btnSend.prop('disabled','');
                },3000);
            }
        });
    }
</script>

<script>
    var expDateHaveToSend = '';
    var warningObject;
    var warningContentObject;
    var bidSenderBox;
    var bidSenderBoxLock;
    var bidSenderBoxInputPrice;
    var isConnected = false;
    var _socket = null;

    $(document).ready(function() {

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });

        $('#valueForBidInput').tooltip('disable');
        $('#valueForBidInput').prop('title',"");
        $('#valueForBidInput').attr('data-original-title',"");

        refreshWalletValue();

        warningObject = $('#warningMessages');
        warningContentObject = $('#warningMessages > div');
        bidSenderBox = $('#bidSenderBox');
        bidSenderBoxLock = $('#bidSenderBoxLock');
        bidSenderBoxInputPrice = $('#bidSenderBox #valueForBidInput');

        if(!("WebSocket" in window))
        {
            warningContentObject.html('Oh no, you need a browser that supports WebSockets. How about <a style="color: #FFF;text-decoration: underline;" href="http://www.google.com/chrome">Google Chrome</a>?');
            warningObject.attr('class','fixed-bottom p-3');
        }
        else
        {
            //The user has WebSockets
            <? if($freeToBid): ?>
            connect();
            <? endif; ?>
            function connect() {
                try{
                    const host = "<?=$__SOCKET_SERVER;?>";
                    _socket = new WebSocket(host);

                    _socket.onopen = function(){
                        bidSenderBoxLock.hide();
                        isConnected = true;
                        console.log('--------------------> Socket server is Run.')
                    };

                    _socket.onerror = function () {
                        isConnected = false;
                        warningContentObject.html('Error: socket server is down!, contact server admin please');
                        warningObject.attr('class','fixed-bottom p-3');
                        console.log('--------------------> Socket server is down!');
                    };

                    _socket.onmessage = function(msg){
                        message(msg.data);
                    };
                    _socket.onclose = function(){
                        console.log('--------------------> Socket server is Closed.');
                    };

                } catch(exception){
                    console.log('--------------------> Error: ' + exception);
                }

            }// connect function
        }
    });
    function message(msg){
        console.log('Message: '+ msg);
        var jso = JSON.parse(msg);
        if(jso != null){
            if(jso.bidDate !== undefined){
                <? if($showBids): ?>
                newBid(jso);
                <? endif; ?>
            }
        }
    }// end message function
    function send(){
        <? if(!$freeToBid): ?>
        return;
        <? endif; ?>
        if(!isConnected || _socket == null)
            return;

        var bid = parseFloat(bidSenderBoxInputPrice.val());
        if(bid.toString() == 'NaN'){
            return;
        }

        const bidDate = new Date();

        requestForBid(bid,function () {
            try{

                var params = JSON.stringify({'exp':expDateHaveToSend,'id':0,'username':'<?=$user_login_data['username'];?>','value':bid,'bidDate':bidDate.getHours() + ':' + bidDate.getMinutes() + ':' + bidDate.getSeconds()});

                _socket.send(params);
                message(params);
                expDateHaveToSend = '';
            } catch(exception){
                message('Error:' + exception);
            }

            bidSenderBoxInputPrice.val('');
        });

    }
</script>

</html>
