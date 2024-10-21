
<?php
// Si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Cargar el archivo XML
    $xml = simplexml_load_file('C:\Xampphtdocs\phpsqlserver\m7carrito\xmldatabase\users.xml');

    // Obtener datos del formulario
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verificar las credenciales
    foreach ($xml->user as $user) {
        if ($user->username == $username && $user->password == $password) {
            echo "Login exitoso. Bienvenido, " . htmlspecialchars($username) . "!";
            exit;  // Salir si el login es correcto
        }
    }

    // Si no coinciden
    echo "Usuario o contraseña incorrectos.";
}
?>

