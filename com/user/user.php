<?php
function saveCart($userId, $cartItems)
{
    $xml = simplexml_load_file('users.xml');
    foreach ($xml->user as $user) {
        if ($user['id'] == $userId) {
            $user->cart = $cartItems;
            $xml->asXML('users.xml');
            break;
        }
    }
}

function loadCart($userId)
{
    $xml = simplexml_load_file('users.xml');
    foreach ($xml->user as $user) {
        if ($user['id'] == $userId) {
            return $user->cart;
        }
    }
    return null;
}
