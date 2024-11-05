<?php
include 'user/user.php';
include 'catalog/catalog.php';
include 'cart/cart.php';

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'add':
            if (isset($_GET['id']) && isset($_GET['quantity'])) {
                $productId = $_GET['id'];
                $quantity = $_GET['quantity'];
                addToCart($productId, $quantity);
            } else {
                echo "Error: ID de producto o cantidad no especificados.";
            }
            break;

        case 'remove':
            if (isset($_GET['id'])) {
                $productId = $_GET['id'];
                removeFromCart($productId);
            } else {
                echo "Error: ID de producto no especificado.";
            }
            break;

        case 'view':
            viewCart();
            break;

        case 'update':
            if (isset($_GET['id']) && isset($_GET['quantity'])) {
                $productId = $_GET['id'];
                $quantity = $_GET['quantity'];
                updateCart($productId, $quantity);
            } else {
                echo "Error: ID de producto o cantidad no especificados.";
            }
            break;

        default:
            echo "Acción no válida.";
            break;
    }
} else {
    echo "Especifica una acción (add, remove, view, update) en la URL.";
}
