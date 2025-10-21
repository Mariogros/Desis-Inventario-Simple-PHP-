<?php
define('DB_HOST', 'localhost');
define('DB_PORT', '5451');
define('DB_NAME', 'registro_productos');
define('DB_USER', 'postgres');
define('DB_PASSWORD', 'YOURPASSWORD');

function getConnection() {
    $connectionString = sprintf(
        "host=%s port=%s dbname=%s user=%s password=%s",
        DB_HOST,
        DB_PORT,
        DB_NAME,
        DB_USER,
        DB_PASSWORD
    );
    
    $conn = pg_connect($connectionString);
    
    if (!$conn) {
        die("Error de conexión: " . pg_last_error());
    }
    
    return $conn;
}

function closeConnection($conn) {
    if ($conn) {
        pg_close($conn);
    }
}
?>
