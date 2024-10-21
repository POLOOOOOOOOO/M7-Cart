<?php
session_start();

// iniciar carrito si no existe
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Cargar productos desde XML
function loadProducts()
{
    $catalog_file = 'C:\Xampp\htdocs\phpsqlserver\m7carrito\xmldatabase\catalog.xml';

    if (file_exists($catalog_file)) {
        $products_xml = simplexml_load_file($catalog_file);
        $products = [];

        foreach ($products_xml->product as $product) {
            $products[] = [
                'id' => (string)$product->id,
                'name' => (string)$product->name,
                'price' => (float)$product->price,
                'stock' => (int)$product->stock,
            ];
        }

        return $products;
    } else {
        echo "No se encontró el archivo de catálogo.";
        return [];
    }
}

// Guardar el carrito en XML
function saveCartToXML()
{
    $cart_file = 'C:\Xampp\htdocs\phpsqlserver\m7carrito\xmldatabase\cart.xml';
    $cart_xml = new SimpleXMLElement('<cart></cart>');

    foreach ($_SESSION['cart'] as $prod_id => $item) {
        $product = $cart_xml->addChild('item');
        $product->addChild('id', $prod_id);
        $product->addChild('name', $item['name']);
        $product->addChild('price', $item['price']);
        $product->addChild('quantity', $item['quantity']);
    }

    $cart_xml->asXML($cart_file);
}

// añadir al carro
function addToCart($prod_id, $quantity)
{
    $products = loadProducts(); // Carga los productos 
    foreach ($products as $product) {
        if ($product['id'] == $prod_id) {
            if ($quantity <= $product['stock']) {
                $_SESSION['cart'][$prod_id] = [
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => $quantity
                ];
                echo "Producto añadido al carrito.<br>";
                saveCartToXML(); // Guardar carrito en XML
                return;
            } else {
                echo "No hay suficiente stock disponible.<br>";
                return;
            }
        }
    }
    echo "Producto no encontrado.<br>";
}

// Función para eliminar del carrito
function removeFromCart($prod_id)
{
    if (isset($_SESSION['cart'][$prod_id])) {
        unset($_SESSION['cart'][$prod_id]);
        echo "Producto eliminado del carrito.<br>";
        saveCartToXML();
    } else {
        echo "El producto no está en el carrito.<br>";
    }
}

// ver carro
function viewCart()
{
    if (empty($_SESSION['cart'])) {
        echo "El carrito está vacío.<br>";
        return;
    }

    echo "<h2>Contenido del Carrito:</h2>";
    echo "<table border='1'><tr><th>Producto</th><th>Cantidad</th><th>Precio Unitario</th><th>Total</th></tr>";
    $total = 0;

    foreach ($_SESSION['cart'] as $prod_id => $item) {
        $item_total = $item['price'] * $item['quantity'];
        echo "<tr>
                <td>{$item['name']}</td>
                <td>{$item['quantity']}</td>
                <td>€{$item['price']}</td>
                <td>€{$item_total}</td>
              </tr>";
        $total += $item_total;
    }

    echo "</table>";
    echo "<h3>Total Carrito: €$total</h3>";
}

// Función para actualizar la cantidad en el carrito
function updateCart($prod_id, $new_quantity)
{
    if (isset($_SESSION['cart'][$prod_id])) {
        if ($new_quantity > 0) {
            $_SESSION['cart'][$prod_id]['quantity'] = $new_quantity;
            echo "Cantidad actualizada.<br>";
            saveCartToXML(); // Guardar carrito 
        } else {
            removeFromCart($prod_id);
        }
    } else {
        echo "El producto no está en el carrito.<br>";
    }
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
