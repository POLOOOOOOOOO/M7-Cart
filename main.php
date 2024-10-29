<?php
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    switch ($action) {
        case 'add_to_cart':
            include 'cart.php';
            addToCart($_GET['product_id'], $_GET['quantity']);
            break;
        case 'remove_from_cart':
            include 'cart.php';
            removeFromCart($_GET['product_id']);
            break;
        case 'view_cart':
            include 'cart.php';
            viewCart();
            break;
        case 'update_cart':
            include 'cart.php';
            updateCart($_GET['product_id'], $_GET['quantity']);
            break;
    }
}
