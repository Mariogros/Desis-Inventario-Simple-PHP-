<?php
header('Content-Type: application/json');
require_once 'config.php';

$conn = getConnection();

$query = "SELECT id, nombre, codigo FROM monedas ORDER BY nombre";
$result = pg_query($conn, $query);

$monedas = array();

if ($result) {
    while ($row = pg_fetch_assoc($result)) {
        $monedas[] = $row;
    }
    pg_free_result($result);
}

closeConnection($conn);

echo json_encode($monedas);
?>
