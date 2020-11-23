<script>
    const ajaxPath = '<?=$__CONTROLLERS.'profile/credits/controller.php';?>';
    const ajaxPathWallet = '<?=$__CONTROLLERS.'profile/wallet/controller.php';?>';
    var _selected_plan_price = 0;
    var _requestCalling = false;

    function refreshWalletValue() {
        callPostAJAX(ajaxPathWallet,null,function (data) {
            $('#currentWalletValue').html(data.value);
        });
    }

    function purchase(id){
        _selected_plan_price = 0;
        const btnYes = $('#confirmationModal #modal_button');
        btnYes.prop('disabled','');
        btnYes.html("Yes, i'm sure");

        var __MODAL_HEADER_CREDIT = 'Confirmation';
        var __MODAL_CREDIT_VALUE;

        switch (id){
            case 1:
                __MODAL_CREDIT_VALUE = 200;
                break;
            case 2:
                __MODAL_CREDIT_VALUE = 500;
                break;
            case 3:
                __MODAL_CREDIT_VALUE = 1000;
                break;
        }
        _selected_plan_price = __MODAL_CREDIT_VALUE;
        var __MODAL_BODY_CREDIT = 'Are you sure you want to pay <span class="font-weight-bold">$'+ __MODAL_CREDIT_VALUE +'</span> ?<br>This value will added to your current wallet.';

        showModal('#confirmationModal',__MODAL_HEADER_CREDIT,__MODAL_BODY_CREDIT,'#warnIdModal',callback);
    }
    function callback(){

        _requestCalling = true;
        const btnYes = $('#confirmationModal #modal_button');
        const btnYesDefaultHTML = btnYes.html();
        const warnElementModal = $('#warnIdModal');

        btnYes.prop('disabled','disabled');
        btnYes.html(__LOADING_SPAN);

        const params = {
            'credit':_selected_plan_price
        };

        callPostAJAX(ajaxPath,params,function (data) {
            _requestCalling = false;
            if(!data.result){
                btnYes.html(btnYesDefaultHTML);
                btnYes.prop('disabled','');
                showWarnInside(warnElementModal,'alert-danger',data.message);
            }else{
                refreshWalletValue();
                showWarnInside(warnElementModal,'alert-success',data.message);
                setTimeout(function () {
                    $('#confirmationModal').modal('hide');
                },1500);
            }
        });
    }
</script>

<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
    <p class="lead">
        There are three plans for charging your wallet, you can choose a suitable plan from them.
        The purchases are not refundable, so please be ensure of the purchasing.
    </p>
</div>

<div class="container">
    <div class="card-deck mb-3 text-center">
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h4 class="my-0 font-weight-normal">Bronze</h4>
            </div>
            <div class="card-body">
                <h1 class="card-title pricing-card-title">$200</h1>
                <ul class="list-unstyled mt-3 mb-4">
                    <li>100 Total bid count</li>
                    <li>Expiration : 5/days</li>
                </ul>
                <button onclick="purchase(1);" type="button" class="btn btn-lg btn-block" style="background: var(--yellow-color)">Purchase</button>
            </div>
        </div>
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h4 class="my-0 font-weight-normal">Silver</h4>
            </div>
            <div class="card-body">
                <h1 class="card-title pricing-card-title">$500</h1>
                <ul class="list-unstyled mt-3 mb-4">
                    <li>500 Total bid count</li>
                    <li>Expiration : 30/days</li>
                </ul>
                <button onclick="purchase(2);" type="button" class="btn btn-lg btn-block" style="background: var(--yellow-color)">Purchase</button>
            </div>
        </div>
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h4 class="my-0 font-weight-normal">Gold</h4>
            </div>
            <div class="card-body">
                <h1 class="card-title pricing-card-title">$1000</h1>
                <ul class="list-unstyled mt-3 mb-4">
                    <li>1000 Total bid count</li>
                    <li>Expiration : unlimited</li>
                </ul>
                <button onclick="purchase(3);" type="button" class="btn btn-lg btn-block" style="background: var(--yellow-color)">Purchase</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        refreshWalletValue();
    });
</script>