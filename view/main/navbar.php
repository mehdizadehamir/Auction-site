<nav class="navbar navbar-expand-md navbar-light fixed-top bg-light">
    <div class="container">
        <a class="navbar-brand mr-0 mr-md-4 font-weight-bold" href="index.php">
            <div style="background: url('resources/images/logo.png') no-repeat center;background-size: 100%;width: 120px;height: 30px;"></div>
        </a>
        <button class="navbar-toggler" type="button" style="border: none;" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span id="icc" class="fa fa-bars" style="color: #000; font-size: 18px;"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item <?php if(!empty($_CURRENT)){if($_CURRENT=='new') echo 'active';};?>">
                    <a class="nav-link" href="new.php">What's new</a>
                </li>
                <li class="nav-item <?php if(!empty($_CURRENT)){if($_CURRENT=='about') echo 'active';};?>">
                    <a class="nav-link" href="about.php">About</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto mt-2 mt-md-0">
                <?php if($user_login_data != null): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Welcome!, <?=$user_login_data['username'];?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item <?=checkP('Credits'); ?>" href="profile.php?p=Credits">Credits</a>
                            <a class="dropdown-item <?=checkP('Purchases'); ?>" href="profile.php?p=Purchases">
                                <span>Purchases</span>
                                <span id="purchasesBadge" class="badge badge-danger float-right d-none">0</span>
                            </a>
                            <a class="dropdown-item <?=checkP('Sales'); ?>" href="profile.php?p=Sales">Sell</a>
                            <a class="dropdown-item <?=checkP('SalesList'); ?>" href="profile.php?p=SalesList">
                                <span>Sales list</span>
                                <span id="salesBadge" class="badge badge-danger float-right d-none">0</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="exit.php">Sign out</a>
                        </div>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="account.php"><span class="fa fa-user-circle"></span>&nbsp;Account</a>
                    </li>
                <?php endif;?>
            </ul>
        </div>
    </div>
</nav>

<script>
    var __menuIsOpen = false;
    const _ajax_path_badges = '<?=$__CONTROLLERS.'notifications/navbar/controller.php';?>';
    const _purchaseBadgeSpanElem         = $('#purchasesBadge');
    const _salesBadgeSpanElem            = $('#salesBadge');

    $(document).ready(function () {

        $('.navbar-toggler').click(function () {
            __menuIsOpen = !__menuIsOpen;

            if(__menuIsOpen){
                $('.navbar-toggler #icc').attr('class','fa fa-minus');
            }else{
                $('.navbar-toggler #icc').attr('class','fa fa-bars');
            }
        });

        refreshBadges(_ajax_path_badges,function () {
            if(__badges.badges.purchases > 0){
                _purchaseBadgeSpanElem.html(__badges.badges.purchases);
                _purchaseBadgeSpanElem.removeClass('d-none');
            }
            if(__badges.badges.sales > 0){
                _salesBadgeSpanElem.html(__badges.badges.sales);
                _salesBadgeSpanElem.removeClass('d-none');
            }
        });

    });
</script>