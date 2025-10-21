<?php
header('Content-Type: application/json');
require_once 'config.php';

$response = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Método no permitido';
    echo json_encode($response);
    exit;
}

$codigo = isset($_POST['codigo']) ? trim($_POST['codigo']) : '';
$nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
$bodega_id = isset($_POST['bodega_id']) ? intval($_POST['bodega_id']) : 0;
$sucursal_id = isset($_POST['sucursal_id']) ? intval($_POST['sucursal_id']) : 0;
$moneda_id = isset($_POST['moneda_id']) ? intval($_POST['moneda_id']) : 0;
$precio = isset($_POST['precio']) ? trim($_POST['precio']) : '';
$descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '';
$materiales = isset($_POST['materiales']) ? json_decode($_POST['materiales'], true) : array();

if (empty($codigo) || empty($nombre) || $bodega_id <= 0 || $sucursal_id <= 0 || 
    $moneda_id <= 0 || empty($precio) || empty($descripcion) || count($materiales) < 2) {
    $response['message'] = 'Todos los campos son obligatorios y se deben seleccionar al menos dos materiales';
    echo json_encode($response);
    exit;
}

if (!preg_match('/^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9]{5,15}$/', $codigo)) {
    $response['message'] = 'El código del producto no cumple con el formato requerido';
    echo json_encode($response);
    exit;
}

if (!preg_match('/^\d+(\.\d{1,2})?$/', $precio) || floatval($precio) <= 0) {
    $response['message'] = 'El precio no tiene el formato correcto';
    echo json_encode($response);
    exit;
}

try {
    $conn = getConnection();
    
    pg_query($conn, "BEGIN");
    
    $queryVerificar = "SELECT COUNT(*) as count FROM productos WHERE codigo = $1";
    $resultVerificar = pg_query_params($conn, $queryVerificar, array($codigo));
    $rowVerificar = pg_fetch_assoc($resultVerificar);
    
    if ($rowVerificar['count'] > 0) {
        pg_query($conn, "ROLLBACK");
        $response['message'] = 'El código del producto ya está registrado';
        echo json_encode($response);
        closeConnection($conn);
        exit;
    }
    
    $queryProducto = "INSERT INTO productos (codigo, nombre, bodega_id, sucursal_id, moneda_id, precio, descripcion, fecha_registro) 
                      VALUES ($1, $2, $3, $4, $5, $6, $7, NOW()) RETURNING id";
    
    $resultProducto = pg_query_params($conn, $queryProducto, array(
        $codigo,
        $nombre,
        $bodega_id,
        $sucursal_id,
        $moneda_id,
        $precio,
        $descripcion
    ));
    
    if (!$resultProducto) {
        pg_query($conn, "ROLLBACK");
        $response['message'] = 'Error al insertar el producto: ' . pg_last_error($conn);
        echo json_encode($response);
        closeConnection($conn);
        exit;
    }
    
    $rowProducto = pg_fetch_assoc($resultProducto);
    $producto_id = $rowProducto['id'];
    
    foreach ($materiales as $material) {
        $queryMaterial = "INSERT INTO producto_materiales (producto_id, material) VALUES ($1, $2)";
        $resultMaterial = pg_query_params($conn, $queryMaterial, array($producto_id, $material));
        
        if (!$resultMaterial) {
            pg_query($conn, "ROLLBACK");
            $response['message'] = 'Error al insertar materiales: ' . pg_last_error($conn);
            echo json_encode($response);
            closeConnection($conn);
            exit;
        }
    }
    
    pg_query($conn, "COMMIT");
    
    $response['success'] = true;
    $response['message'] = 'Producto guardado exitosamente';
    $response['producto_id'] = $producto_id;
    
} catch (Exception $e) {
    if (isset($conn)) {
        pg_query($conn, "ROLLBACK");
    }
    $response['message'] = 'Error: ' . $e->getMessage();
}

if (isset($conn)) {
    closeConnection($conn);
}

echo json_encode($response);
?>
