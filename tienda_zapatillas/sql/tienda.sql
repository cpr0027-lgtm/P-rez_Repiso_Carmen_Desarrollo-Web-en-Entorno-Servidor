CREATE DATABASE tienda_zapatillas;
USE tienda_zapatillas;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    rol ENUM('ADMIN','USER') DEFAULT 'USER'
);

CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL,
    imagen VARCHAR(255)
);

INSERT INTO productos (nombre, descripcion, precio, stock, imagen) VALUES
('Nike deportiva negra','Zapatillas Nike negras cómodas',110,20,'img/productos/nike_negra.jpg'),
('Zapatillas beige','Zapatillas beige ligeras',75,15,'img/productos/zapatillas_beige.jpg'),
('Skechers negra','Skechers negras urbanas',90,10,'img/productos/skechers_negra.jpg'),
('Adidas coral','Adidas coral running',95,12,'img/productos/adidas_coral.jpg'),
('Adidas negras','Adidas negras deportivas',100,18,'img/productos/adidas_negras.webp');

CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    fecha DATETIME,
    total DECIMAL(8,2),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);

CREATE TABLE pedido_producto (
    id_pedido INT,
    id_producto INT,
    cantidad INT,
    PRIMARY KEY (id_pedido, id_producto),
    FOREIGN KEY (id_pedido) REFERENCES pedidos(id),
    FOREIGN KEY (id_producto) REFERENCES productos(id)
);