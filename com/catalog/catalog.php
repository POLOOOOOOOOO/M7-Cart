<?php
function checkStock($productId, $quantity)
{
    $xml = simplexml_load_file('catalog.xml');
    foreach ($xml->product as $product) {
        if ($product['id'] == $productId && $product->stock >= $quantity) {
            return true;
        }
    }
    return false;
}

function getProductInfo($productId)
{
    $xml = simplexml_load_file('catalog.xml');
    foreach ($xml->product as $product) {
        if ($product['id'] == $productId) {
            return [
                'name' => (string)$product->name,
                'price' => (float)$product->price
            ];
        }
    }
    return null;
}
