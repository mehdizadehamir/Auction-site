<?php
session_start();
include_once "controller/config.php";

$user_login_data = userLoginData();
$_CURRENT = 'new';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php include_once "view/main/meta.php"; ?>
    <title>xAuction | About</title>
    <!-- Bootstrap core CSS -->
    <link href="resources/bootstrap_4.5/css/bootstrap.min.css" rel="stylesheet">
    <link href="resources/css/pricing.css" rel="stylesheet">
    <link href="resources/css/style.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="resources/js/jquery-3.5.1.min.js"></script>
    <script src="resources/js/scripts.js"></script>
</head>
<body>
<?php include_once "view/main/navbar.php"; ?>
<div class="container card-body shadow-lg" style="margin-top: 100px;">
    <div class="col-12">
        <img src="resources/images/new.jpg" class="shadow-sm" style="width: 100%; border-radius: 4px;">
    </div>
    <div class="col-12 mt-5">
        <h1 class="pb-3">What's new</h1>
        <div>
            <h3><span style="font-size: 18px; font-weight: bold; padding: 5px;" class="alert-success">Upcoming version</span> &nbsp;<span style="font-size: 11px;">Future goals</span></h3>
            <p style="font-size: 16px;">
                in the future, it's gonna use A.I to train the system for giving the best suggestions<br>
                In the bidding and also it will learn the client's behaviors to help them have great deals in the xAuction system.
            </p>
        </div>
        <div class="dropdown-divider"></div>
        <div>
            <h3><span style="font-size: 18px; font-weight: bold; padding: 5px;" class="alert-success">Latest release</span> &nbsp;<span style="font-size: 11px;">Dec 13 2020</span></h3>
            <p style="font-size: 16px;">
                In this version, some syntax warning about short_open_tag in php version >= 7 have been fixed
                <br>And also many products added to the system for testing.
            </p>
        </div>
        <div class="dropdown-divider"></div>
        <div>
            <h3><span style="font-size: 18px; font-weight: bold; padding: 5px;" class="alert-warning">New feature</span> &nbsp;<span style="font-size: 11px;">Dec 8 2020</span></h3>
            <p style="font-size: 16px;">
                for the specific part of the project in every auction page we've used RatChat library<br>To handle WebSocket connection and send/receive data between clients and server.
            </p>
        </div>
        <div class="dropdown-divider"></div>
        <div>
            <h3><span style="font-size: 18px; font-weight: bold; padding: 5px;" class="alert-info">First release</span> &nbsp;<span style="font-size: 11px;">Dec 1 2020</span></h3>
            <p style="font-size: 16px;">
                after some days finally we made an stable release of the project and push that on the GitHub repository<br>
                This version is just a prototype of the main project and we're trying to complete the features.
            </p>
        </div>
    </div>
</div>
<?php include_once "view/main/footer.php"; ?>
</body>
<script src="resources/bootstrap_4.5/js/bootstrap.min.js"></script>
</html>
