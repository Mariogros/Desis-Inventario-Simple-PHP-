-- Script de creación de base de datos (incluye dummy data para testeo de sucursales/bodegas)
-- PostgreSQL

CREATE TABLE IF NOT EXISTS bodegas (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    direccion VARCHAR(255),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS sucursales (
    id SERIAL PRIMARY KEY,
    bodega_id INTEGER NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    direccion VARCHAR(255),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (bodega_id) REFERENCES bodegas(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS monedas (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    codigo VARCHAR(10) NOT NULL,
    simbolo VARCHAR(5),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS productos (
    id SERIAL PRIMARY KEY,
    codigo VARCHAR(15) UNIQUE NOT NULL,
    nombre VARCHAR(50) NOT NULL,
    bodega_id INTEGER NOT NULL,
    sucursal_id INTEGER NOT NULL,
    moneda_id INTEGER NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    descripcion TEXT NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (bodega_id) REFERENCES bodegas(id) ON DELETE RESTRICT,
    FOREIGN KEY (sucursal_id) REFERENCES sucursales(id) ON DELETE RESTRICT,
    FOREIGN KEY (moneda_id) REFERENCES monedas(id) ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS producto_materiales (
    id SERIAL PRIMARY KEY,
    producto_id INTEGER NOT NULL,
    material VARCHAR(50) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE
);

CREATE INDEX IF NOT EXISTS idx_productos_codigo ON productos(codigo);
CREATE INDEX IF NOT EXISTS idx_sucursales_bodega ON sucursales(bodega_id);
CREATE INDEX IF NOT EXISTS idx_producto_materiales_producto ON producto_materiales(producto_id);

INSERT INTO bodegas (nombre, direccion) VALUES
('Bodega Central', 'Av. Principal 123, Santiago'),
('Bodega Norte', 'Calle Norte 456, Antofagasta'),
('Bodega Sur', 'Av. Sur 789, Puerto Montt');

INSERT INTO sucursales (bodega_id, nombre, direccion) VALUES
(1, 'Sucursal Centro', 'Centro comercial Plaza, Local 45'),
(1, 'Sucursal Oriente', 'Mall del Este, Piso 2'),
(1, 'Sucursal Poniente', 'Av. Libertador 567'),
(2, 'Sucursal Mall Norte', 'Mall Plaza Norte, Local 12'),
(2, 'Sucursal Aeropuerto', 'Terminal Aeropuerto, Zona A'),
(3, 'Sucursal Puerto', 'Costanera 890'),
(3, 'Sucursal Centro Sur', 'Calle Principal 234');

INSERT INTO monedas (nombre, codigo, simbolo) VALUES
('Peso Chileno', 'CLP', '$'),
('Dólar Estadounidense', 'USD', 'US$'),
('Euro', 'EUR', '€'),
('Peso Argentino', 'ARS', '$'),
('Sol Peruano', 'PEN', 'S/');
