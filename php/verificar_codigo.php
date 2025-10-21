<?php
header('Content-Type: application/json');
require_once 'config.php';

$codigo = isset($_GET['codigo']) ? trim($_GET['codigo']) : '';

$response = array('existe' => false);

if (!empty($codigo)) {
    $conn = getConnection();
    
    $query = "SELECT COUNT(*) as count FROM productos WHERE codigo = $1";
    $result = pg_query_params($conn, $query, array($codigo));
    
    if ($result) {
        $row = pg_fetch_assoc($result);
        $response['existe'] = ($row['count'] > 0);
        pg_free_result($result);
    }
    
    closeConnection($conn);
}

echo json_encode($response);
?>
