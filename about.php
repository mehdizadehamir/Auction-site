<?php
session_start();
include_once "controller/config.php";

$user_login_data = userLoginData();
$_CURRENT = 'about';
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
        <img src="resources/images/aboutus.jpg" class="shadow-sm" style="width: 100%; border-radius: 4px;">
    </div>
    <div class="col-12 mt-5">
        <h1 class="pb-3">About us</h1>
        <p style="font-size: 16px;">
            We are 5 graduate students who doing the auction site project for higher layer protocols under the supervision of professor Glitho in Concordia university located in cosmopolitan city of Montreal and it takes roughly 3 month to implemented this project based on scrum methodology we divided the task into 3 sprint and each sprints takes between 3-4 weeks .
        </p>
        <div class="mt-5">
            <div class="font-weight-bold">Get in touch with Project owner</div>
            <a href="mailto:Amirhossein.MehdizadeMehrjoyAraghi@concordia.ca">Amirhossein.MehdizadeMehrjoyAraghi@concordia.ca</a>
        </div>
    </div>
</div>
<?php include_once "view/main/footer.php"; ?>
</body>
<script src="resources/bootstrap_4.5/js/bootstrap.min.js"></script>
</html>
