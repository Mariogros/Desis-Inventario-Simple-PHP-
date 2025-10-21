<?php
header('Content-Type: application/json');
require_once 'config.php';

$conn = getConnection();

$query = "SELECT id, nombre FROM bodegas ORDER BY nombre";
$result = pg_query($conn, $query);

$bodegas = array();

if ($result) {
    while ($row = pg_fetch_assoc($result)) {
        $bodegas[] = $row;
    }
    pg_free_result($result);
}

closeConnection($conn);

echo json_encode($bodegas);
?>
