<?php

///////////////////////////////////////////////////////////
function AddtoCart($id_prod, $quantity)
{

    echo "AddtoCart <br>";
    echo $id_prod;
    $cart = GetCart();

    $item = $cart->addChild('product_item');
    $item->addChild('id_product', $id_prod);
    $item->addChild('quantity', $quantity);

    $item_price = $item->addChild('price_item');
    $item_price->addChild('price', '0');
    $item_price->addChild('currency', 'EU');

    $cart->asXML('xmldatabase/cart.xml');
}
///////////////////////////////////////////////////////////
function GetCart()
{

    $file = 'C:\Xampphtdocs\phpsqlserver\m7 carrito\xmldatabase';

    if (file_exists($file)) {

        echo 'existe el fichero <br>';
        $cart = simplexml_load_file($file);
    } else {
        echo 'no existe el fichero <br>';
        $cart = new SimpleXMLElement('<cart></cart>');
    }
    return $cart;
}
///////////////////////////////////////////////////////////
