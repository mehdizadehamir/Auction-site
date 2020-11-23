<?php
session_start();
include_once "controller/config.php";

logOutUser();
redirectToHomeAfterLoggedOut();