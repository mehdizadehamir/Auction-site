<?php
session_start();
include_once "controller/config.php";

$user_login_data = userLoginData();
redirectToHomeIfNotIsLoggedIn($user_login_data);

$_currentPage = '';
$_PAGE_HEADER = '';
$_PAGE_DESC = '';
$_PAGE_IMG_NAME = '';

if(!empty($_GET['p'])){
    $p = $_GET['p'];
    switch (strtolower($p)){
        case 'credits':
            $_currentPage = 'credits';
            $_PAGE_HEADER = 'Credits';
            $_PAGE_DESC = 'Charge your credit and make bids to buy everything<br>with affordable prices!';
            $_PAGE_IMG_NAME = 'top_header_img_02.jpg';
            break;
        case 'sales':
            $_currentPage = 'sales';
            $_PAGE_HEADER = 'Sell';
            $_PAGE_DESC = "At the moment, sell everything you'd like by the best price.";
            $_PAGE_IMG_NAME = 'top_header_img_05.jpg';
            break;
        case 'saleslist':
            $_currentPage = 'saleslist';
            $_PAGE_HEADER = 'Sales';
            $_PAGE_DESC = "The history of your sales in list bellow<br>will gave you convenient sales management.";
            $_PAGE_IMG_NAME = 'top_header_img_04.jpg';
            break;
        case 'purchases':
            $_currentPage = 'purchases';
            $_PAGE_HEADER = 'Purchases';
            $_PAGE_DESC = "The list bellow shows what exactly you have purchased.<br>and its profit will calculated for you as well.";
            $_PAGE_IMG_NAME = 'top_header_img_03.jpg';
            break;
        default :
            $_currentPage = '';
            break;
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php include_once "view/main/meta.php"; ?>
    <title>Pricing example · Bootstrap</title>
    <!-- Bootstrap core CSS -->
    <link href="resources/bootstrap_4.5/css/bootstrap.min.css" rel="stylesheet">
    <link href="resources/css/pricing.css" rel="stylesheet">
    <link href="resources/css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <script src="resources/js/jquery-3.5.1.min.js"></script>
    <script src="resources/js/scripts.js"></script>
</head>
<body>
<?php include_once "view/main/navbar.php"; ?>
<?php include_once "view/main/header_profile.php"; ?>

<?php
switch ($_currentPage)
{
    case 'credits':
        include_once "view/profile/credit.php";
        break;
    case 'sales':
        include_once "view/profile/sales.php";
        break;
    case 'saleslist':
        include_once "view/profile/saleslist.php";
        break;
    case 'purchases':
        include_once "view/profile/purchases.php";
        break;
}
?>

<?php include_once "view/main/footer.php"; ?>
<?php include_once "view/modals/confirmation.php"; ?>
</body>
<script src="resources/bootstrap_4.5/js/bootstrap.min.js"></script>
</html>
