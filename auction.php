<?php
session_start();
include_once "controller/config.php";

$user_login_data = userLoginData();


include_once "model/auctions/auctions.php";
$auctions = new Auctions($__connection);
$auctionId=get('id');
$auctionData = $auctions->selectOne();
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="http://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>
    <script src="resources/js/scripts.js"></script>
</head>
<body>
<?php include_once "view/main/navbar.php"; ?>
<?php include_once "view/main/header_auction.php"; ?>

<div class="px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center col-6">
    <div class="row mb-3">
        <div class="table-responsive" style="max-height: 600px;">
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
                var i = 0;
                for(i=0; i < response.data.length; i++){
                    const item = response.data[i];
                    var child = '<tr id="flash_id_'+ item.id +'">';

                    child       += '<td>';
                    child       += i + 1;
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

                    $('#tBodyT').prepend(child);
                    flashElement("#flash_id_"+ item.id);
                }
                $('#loadingTr > #loadingTd').html('');
            }
        });
    });
</script>

<?php include_once "view/main/footer.php"; ?>
</body>
<script src="resources/bootstrap_4.5/js/bootstrap.min.js"></script>
</html>
