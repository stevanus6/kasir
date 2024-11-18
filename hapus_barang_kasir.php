<?php
session_start();

if(isset($_GET['key'])) {
    $key = $_GET['key'];
    if(array_key_exists($key, $_SESSION['cart'])) {
        unset($_SESSION['cart'][$key]);
    }
}

header('Location: kasir.php');
exit();
?>
