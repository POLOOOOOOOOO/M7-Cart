

<?php
$cart_file = 'C:\Xampp\htdocs\phpsqlserver\m7carrito\xmldatabase\cart.xml';
$catalog_file = 'C:\Xampp\htdocs\phpsqlserver\m7carrito\xmldatabase\catalog.xml';

///////////////////////////////////////////////////////////

function addToCart($item_id, $quantity)
{
    echo "addToCart called with item_id: $item_id and quantity: $quantity<br>";

    if (existsProduct($item_id)) {
        echo "Product exists<br>";
        executeAddToCart($item_id, $quantity);
    } else {
        echo 'No existe el producto<br>';
    }
}

function executeAddToCart($item_id, $quantity)
{
    global $cart_file;

    echo "executeAddToCart called with item_id: $item_id and quantity: $quantity<br>";

    $cart = getCart();

    $itemExists = false;
    foreach ($cart->item as $item) {
        if ((string)$item->id === (string)$item_id) {
            $item->quantity += $quantity; // Actualiza la cantidad
            $itemExists = true;
            break;
        }
    }

    if (!$itemExists) {
        // Agregar un nuevo producto al carrito
        $newItem = $cart->addChild('item');
        $newItem->addChild('id', $item_id);
        $newItem->addChild('quantity', $quantity);
    }

    // Guardar el carrito actualizado
    $cart->asXML($cart_file);
    echo 'Producto añadido al carrito correctamente.<br>';
}

// Manejo de acciones
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'add':
            addToCart($_GET['prod_id'], $_GET['quantity']);
            break;
        case 'remove':
            removeFromCart($_GET['prod_id']);
            break;
        case 'view':
            viewCart();
            break;
        case 'update':
            updateCart($_GET['prod_id'], $_GET['quantity']);
            break;
        default:
            echo "Acción no reconocida.<br>";
            break;
    }
} else {
    echo "No se ha especificado ninguna acción.<br>";
}
