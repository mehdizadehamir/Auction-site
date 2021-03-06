<header>
    <div class="container p-5">
        <div class="row">
            <div class="col-9 mx-auto mb-4 mb-sm-0 col-sm-5 col-md-4">
                <img src="resources/user-uploads/user-<?=$auctionData['username'];?>/<?=$auctionData['image'];?>" style="width: 100%;">
            </div>
            <div class="col-12 col-sm-7 col-md-8">
                <h1><?=$auctionData['name'];?></h1>
                <p><?=$auctionData['description'];?></p>
                <div class="header-bid-section">
                    <div id="streamStatusLabelClass" class="header-bid-section-item-without-color alert-success">
                        <span id="streamStatusLabelId">On Stream </span>
                    </div>
                    <div class="header-bid-section-item-without-color alert-dark <?= ($auctionData['expireDate'] == null) ? 'd-none' : 'd-inline-block'; ?>" id="count_down_div">
                        <span id="count-down-auction"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    function checkExpireDate(time) {
        if(time != ''){
            const count_down_div = $('#count_down_div');
            if(count_down_div.hasClass('d-none')){
                count_down_div.removeClass('d-none');
                count_down_div.hasClass('d-inline-block');
                countDownDate = new Date(time).getTime();
                countDownEnabled = true;
                startCountDown();
            }
        }
    }
    // Set the date we're counting down to
    var countDownEnabled = <?= ($auctionData['expireDate'] == null) ? 'false' : 'true'; ?>;
    var countDownDate = new Date("<?=date('M d, Y H:i:s',$auctionData['expireDate']);?>").getTime();

    function startCountDown() {
        // Update the count down every 1 second
        if(countDownDate != null){
            var x = setInterval(function() {
                // Get today's date and time
                var now = new Date().getTime();
                // Find the distance between now and the count down date
                var distance = countDownDate - now;
                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                // Display the result in the element with id="demo"
                document.getElementById("count-down-auction").innerHTML = days + "d " + hours + "h "
                    + minutes + "m " + seconds + "s ";
                // If the count down is finished, write some text
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("count-down-auction").innerHTML = "EXPIRED";
                    document.getElementById("streamStatusLabelId").innerHTML = "TimesOver";
                    document.getElementById("streamStatusLabelClass").setAttribute('class','header-bid-section-item-without-color alert-danger');
                    checkWinner();
                }
            }, 1000);
        }
    }

    if(countDownEnabled){
        startCountDown();
    }
</script>