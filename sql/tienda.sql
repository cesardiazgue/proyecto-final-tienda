USE tienda;

-- Si ya existen, se borran (primero las hijas y luego las padres)
DROP TABLE IF EXISTS historial_compras;
DROP TABLE IF EXISTS carrito;
DROP TABLE IF EXISTS productos;
DROP TABLE IF EXISTS usuarios;

-- Tabla de usuarios
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    tarjeta VARCHAR(19) NOT NULL,
    direccion VARCHAR(255) NOT NULL,
    rol VARCHAR(20) NOT NULL DEFAULT 'cliente'
);

-- Tabla de productos
CREATE TABLE productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT NOT NULL,
    foto VARCHAR(255) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    cantidad_almacen INT NOT NULL,
    fabricante VARCHAR(100) NOT NULL,
    origen VARCHAR(100) NOT NULL
);

-- Carrito: productos que el usuario está por comprar
CREATE TABLE carrito (
    id_carrito INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_producto INT NOT NULL,
    cantidad INT NOT NULL DEFAULT 1,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
);


-- Historial: productos que el usuario ya compró
CREATE TABLE historial_compras (
    id_compra INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_producto INT NOT NULL,
    cantidad INT NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
);