<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Registro de Productos</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Formulario de Producto</h1>
        
        <form id="formProducto">
            <div class="form-row">
                <div class="form-group">
                    <label for="codigo">Código</label>
                    <input type="text" id="codigo" name="codigo" maxlength="15">
                </div>

                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" maxlength="50">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="bodega">Bodega</label>
                    <select id="bodega" name="bodega">
                        <option value="">Seleccione una bodega</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="sucursal">Sucursal</label>
                    <select id="sucursal" name="sucursal">
                        <option value="">Seleccione una sucursal</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="moneda">Moneda</label>
                    <select id="moneda" name="moneda">
                        <option value="">Seleccione una moneda</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="precio">Precio</label>
                    <input type="text" id="precio" name="precio">
                </div>
            </div>

            <div class="form-group">
                <label>Material del Producto</label>
                <div class="checkbox-group">
                    <div class="checkbox-item">
                        <input type="checkbox" id="material_plastico" name="materiales[]" value="Plástico">
                        <label for="material_plastico">Plástico</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" id="material_metal" name="materiales[]" value="Metal">
                        <label for="material_metal">Metal</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" id="material_madera" name="materiales[]" value="Madera">
                        <label for="material_madera">Madera</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" id="material_vidrio" name="materiales[]" value="Vidrio">
                        <label for="material_vidrio">Vidrio</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" id="material_textil" name="materiales[]" value="Textil">
                        <label for="material_textil">Textil</label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="5" maxlength="1000"></textarea>
            </div>

            <div class="form-group">
                <button type="submit" class="btn-guardar">Guardar Producto</button>
            </div>
        </form>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
