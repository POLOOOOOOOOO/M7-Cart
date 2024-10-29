<?php
function addToCart($productId, $quantity)
{
    include 'catalog.php';
    if (checkStock($productId, $quantity)) {
        $cart = simplexml_load_file('cart.xml');
        $item = $cart->addChild('item');
        $item->addAttribute('id', $productId);
        $item->addAttribute('quantity', $quantity);
        $cart->asXML('cart.xml');
        echo "Producto añadido correctamente";
    } else {
        echo "Stock insuficiente";
    }
}

function removeFromCart($productId)
{
    $cart = simplexml_load_file('cart.xml');
    foreach ($cart->item as $index => $item) {
        if ($item['id'] == $productId) {
            unset($cart->item[$index]);
            $cart->asXML('cart.xml');
            echo "Producto eliminado";
            break;
        }
    }
}

function viewCart()
{
    $cart = simplexml_load_file('cart.xml');
    $total = 0;
    foreach ($cart->item as $item) {
        $productId = $item['id'];
        include 'catalog.php';
        $info = getProductInfo($productId);
        $quantity = $item['quantity'];
        $subtotal = $quantity * $info['price'];
        echo "{$info['name']} - Cantidad: {$quantity}, Subtotal: {$subtotal}\n";
        $total += $subtotal;
    }
    echo "Total: {$total}\n";
}

function updateCart($productId, $quantity)
{
    $cart = simplexml_load_file('cart.xml');
    foreach ($cart->item as $item) {
        if ($item['id'] == $productId) {
            $item['quantity'] = $quantity;
            $cart->asXML('cart.xml');
            echo "Cantidad actualizada";
            break;
        }
    }
}
