# SISTEMA DE REGISTRO DE PRODUCTOS

Aplicación web para el registro y validación de productos, desarrollada con tecnologías nativas (HTML, CSS, JavaScript y PHP), y con conexión a base de datos PostgreSQL.

---

## Instalación

### 1. Crear la base de datos

En PostgreSQL:

```sql
CREATE DATABASE registro_productos;
```

Importar el esquema y los datos iniciales:

```bash
psql -U postgres -d registro_productos -f sql/crear_base_datos.sql
```

---

### 2. Configurar la conexión

Editar el archivo `php/config.php` con tus credenciales de PostgreSQL:

```php
define('DB_HOST', 'localhost');
define('DB_PORT', '5432');
define('DB_NAME', 'registro_productos');
define('DB_USER', 'postgres');
define('DB_PASSWORD', 'tu_contraseña');
```

---

### 3. Habilitar extensión PHP-PGSQL

En `php.ini`, descomentar las siguientes líneas:

```
extension=pgsql
extension=pdo_pgsql
```

Y asegurarse de que `extension_dir` apunte al directorio correcto.

---

### 4. Iniciar el servidor

```bash
php -S localhost:8000
```

Luego acceder en el navegador a:

[http://localhost:8000/index.php](http://localhost:8000/index.php)

---

## Funcionalidades

- Registro de productos con 8 campos validados  
- Validaciones en JavaScript con mensajes personalizados  
- Carga dinámica de selects mediante AJAX  
- Verificación de código único en tiempo real  
- Sucursales dependientes de la bodega seleccionada  
- Guardado en base de datos con transacciones  

---

## Validaciones

| Campo | Regla |
|-------|--------|
| Código | 5–15 caracteres, alfanumérico y único |
| Nombre | 2–50 caracteres |
| Precio | Número positivo, máximo 2 decimales |
| Materiales | Mínimo 2 seleccionados |
| Bodega, Sucursal, Moneda | Obligatorios |
| Descripción | 10–1000 caracteres |
