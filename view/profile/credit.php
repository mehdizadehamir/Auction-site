<script>
    function purchase(id){

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
        var __MODAL_BODY_CREDIT = 'Are you sure you want to pay <span class="font-weight-bold">$'+ __MODAL_CREDIT_VALUE +'</span> ?<br>This value will added to your current wallet.';

        showModal('#confirmationModal',__MODAL_HEADER_CREDIT,__MODAL_BODY_CREDIT);
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