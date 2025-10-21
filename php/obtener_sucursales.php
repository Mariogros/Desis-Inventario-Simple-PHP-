<?php
header('Content-Type: application/json');
require_once 'config.php';

$bodega_id = isset($_GET['bodega_id']) ? intval($_GET['bodega_id']) : 0;

$conn = getConnection();

$query = "SELECT id, nombre FROM sucursales WHERE bodega_id = $1 ORDER BY nombre";
$result = pg_query_params($conn, $query, array($bodega_id));

$sucursales = array();

if ($result) {
    while ($row = pg_fetch_assoc($result)) {
        $sucursales[] = $row;
    }
    pg_free_result($result);
}

closeConnection($conn);

echo json_encode($sucursales);
?>
