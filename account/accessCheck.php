<?php
session_start();
ob_start();

if(!isset($_SESSION['fallow'])) {
    header('HTTP/1.1 404 Not Found');
    exit();
}

$_SESSION['access_allow'] = true;
header('location: user.php');
exit();
?>