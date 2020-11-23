<header>
    <div class="container p-5">
        <div class="row">
            <div class="col-9 mx-auto mb-4 mb-sm-0 col-sm-5 col-md-4">
                <img src="resources/images/<?=$_PAGE_IMG_NAME;?>" style="width: 100%;margin-top: -40px;">
            </div>
            <div class="col-12 col-sm-7 col-md-8">
                <h1><?=$_PAGE_HEADER;?></h1>
                <p><?=$_PAGE_DESC;?></p>
                <?php if(strtolower($_PAGE_HEADER) == 'credits'):?>
                <div class="col-12 pr-0 pl-0">
                    <div style="display:inline-block;background: #000000;color: #ffffff; padding-left: 10px; padding-right: 10px;">
                        <span title="Your wallet value" style="font-size: 24px;">Your credit</span>
                        &nbsp;
                        <span id="currentWalletValue" class="font-weight-bold" style="font-size: 24px;">...</span>$
                    </div>
                </div>
                <?php endif;?>
            </div>
        </div>
    </div>
</header>