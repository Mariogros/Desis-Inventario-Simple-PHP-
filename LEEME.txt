SISTEMA DE REGISTRO DE PRODUCTOS

Sistema web para el registro de productos con validaciones, conexión a base 
de datos PostgreSQL y tecnologías nativas (HTML, CSS, JavaScript y PHP).

INSTALACIÓN
================================================================================

1. CONFIGURAR BASE DE DATOS
   
   Crear la base de datos en PostgreSQL:
   
   CREATE DATABASE registro_productos;
   
   Importar el esquema y datos:
   
   psql -U postgres -d registro_productos -f sql/crear_base_datos.sql

2. CONFIGURAR CONEXIÓN
   
   Editar php/config.php con sus credenciales de PostgreSQL:
   
   define('DB_HOST', 'localhost');
   define('DB_PORT', '5432');
   define('DB_NAME', 'registro_productos');
   define('DB_USER', 'postgres');
   define('DB_PASSWORD', 'su_contraseña');

3. HABILITAR EXTENSIÓN PHP-PGSQL
   
   En php.ini, descomentar:
   
   extension=pgsql
   extension=pdo_pgsql
   
   Configurar extension_dir con la ruta correcta.

4. INICIAR SERVIDOR
   
   php -S localhost:8000
   
   Acceder a: http://localhost:8000/index.php

FUNCIONALIDADES
================================================================================

- Registro de productos con 8 campos validados
- Validaciones JavaScript con mensajes personalizados
- Carga dinámica de selects mediante AJAX
- Verificación de código único en tiempo real
- Sucursales dependientes de bodega seleccionada
- Guardado en base de datos con transacciones

VALIDACIONES
================================================================================

Código: 5-15 caracteres, alfanumérico, único
Nombre: 2-50 caracteres
Precio: Número positivo, máximo 2 decimales
Materiales: Mínimo 2 seleccionados
Bodega, Sucursal, Moneda: Obligatorios
Descripción: 10-1000 caracteres
