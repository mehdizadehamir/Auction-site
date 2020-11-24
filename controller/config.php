<?php

$__PATH         = "http://localhost:8080/auction/";
$__CONTROLLERS         = $__PATH."controller/";
$__USER_DATA_SESSION_INDEX = "user-data";
$__TABLE_MAX_COUNT_PER_PAGE = 20;

$__HOST_ADR     = "localhost";
$__HOST_USER    = "root";
$__HOST_PASS    = "";
$__HOST_DB_NAME = "xAuction";

$__connection = mysqli_connect($__HOST_ADR, $__HOST_USER, $__HOST_PASS, $__HOST_DB_NAME) or die('Connection lost!');

function checkP($name,$class='active'){
    if(!empty($_GET['p'])){
        if($_GET['p'] == $name){
            return $class;
        }else{
            return '';
        }
    }else{
        return '';
    }
}

function get($param_id){
    if(!empty($_GET[$param_id])){
        return $_GET[$param_id];
    }else{
        return '';
    }
}

function strongPassword($password){
    return base64_encode(md5('-_-A34@vb'.$password.'*-Plghh4B'));
}

function userLoginData(){
    if(!empty($_SESSION[$GLOBALS['__USER_DATA_SESSION_INDEX']])){
        return $_SESSION[$GLOBALS['__USER_DATA_SESSION_INDEX']];
    }else{
        return null;
    }
}

function logOutUser(){
    if(!empty($_SESSION[$GLOBALS['__USER_DATA_SESSION_INDEX']])){
        unset($_SESSION[$GLOBALS['__USER_DATA_SESSION_INDEX']]);
        session_destroy();
    }
}


function redirectToHomeIfIsLoggedIn($userData){
    if($userData != null){
        header('location: index.php');
    }
}
function redirectToHomeAfterLoggedOut(){
    header('location: index.php');
}

function redirectToHomeIfNotIsLoggedIn($userData){
    if(empty($userData)){
        header('location: index.php');
    }
}

function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }

    }

    return rmdir($dir);
}
