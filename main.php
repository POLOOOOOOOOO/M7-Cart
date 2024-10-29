<?php
session_start();
include_once('com/cart/cart.php');
include_once('com/user/user.php');
include_once('com/catalog/catalog.php');
include_once('com/')


if (isset($_GET['action'])) {
    $action = $_GET['action'];
    switch ($action) {
        case 'add_to_cart':
            addToCart($_GET['product_id'], $_GET['quantity']);
            break;
        case 'remove_from_cart':
            removeFromCart($_GET['product_id']);
            break;
        case 'view_cart':
            viewCart();
            break;
        case 'update_cart':
            updateCart($_GET['product_id'], $_GET['quantity']);
            break;
    }
}
