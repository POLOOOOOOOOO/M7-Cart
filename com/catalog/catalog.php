<?php

function getCatalogFile()
{
    $catalogFile = 'C:\Xampphtdocs\phpsqlserver\m7carrito\xmldatabase';
    if (!file_exists($catalogFile)) {
        $catalog = new SimpleXMLElement('<products></products>');
        $catalog->asXML($catalogFile);
    }
    return simplexml_load_file($catalogFile);
}

function viewCatalog()
{
    $catalog = getCatalogFile();
    echo "<h2>Catálogo de Venta:</h2>";
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>ID</th><th>Nombre</th><th>Precio (€)</th><th>Stock</th></tr>";
    foreach ($catalog->product as $item) {
        echo "<tr>";
        echo "<td>{$item->id}</td>";
        echo "<td>{$item->name}</td>";
        echo "<td>{$item->price}</td>";
        echo "<td>{$item->stock}</td>";
        echo "</tr>";
    }
    echo "</table><br>";
    echo "Para añadir productos al carrito, usa la barra de búsqueda:<br>";
    echo "?action=add_to_cart&amp;prod_id=1&amp;quantity=2<br>";
}

// Ejemplo de uso:
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action == 'view') {
        viewCatalog();
    } elseif ($action == 'add_stock' && isset($_GET['prod_id'], $_GET['quantity'])) {
        echo "El stock se ha añadido manualmente al XML.<br>";
    }
}
