USE tienda;

-- Vacía la tabla y reinicia el contador de id (por si corres el script dos veces)
DELETE FROM productos;
ALTER TABLE productos AUTO_INCREMENT = 1;

INSERT INTO productos (nombre, descripcion, foto, precio, cantidad_almacen, fabricante, origen) VALUES
-- Dulces y botanas
('Chocolate Twix (6 piezas)', 'Galleta crujiente cubierta de caramelo y chocolate con leche. Paquete con 6 barras.', 'twix.jpg', 89.00, 120, 'Mars Wrigley', 'Estados Unidos'),
('Galletas Casino Chocolate', 'Galletas sándwich de chocolate rellenas de crema. Paquete individual.', 'casino.jpg', 22.00, 150, 'Gamesa', 'México'),
('Harina P.A.N. para Arepas 1 kg', 'Harina de maíz blanco precocida, ideal para preparar arepas caseras.', 'harina_pan.jpg', 65.00, 80, 'Empresas Polar', 'Venezuela'),
('Ferrero Rocher (12 piezas)', 'Bombones de avellana con chocolate y trozos de nuez. Caja de regalo.', 'ferrero_rocher.jpg', 159.00, 60, 'Ferrero', 'Italia'),
('Takis Fuego 280 g', 'Totopos enrollados con sabor a chile y limón, extra picantes.', 'takis.jpg', 52.00, 100, 'Barcel', 'México'),
('Pingüinos Marinela', 'Pastelitos de chocolate rellenos de crema. Paquete con 2 piezas.', 'pinguinos.jpg', 28.00, 90, 'Marinela', 'México'),
('Nutella 350 g', 'Crema untable de avellanas con cacao.', 'nutella.jpg', 99.00, 70, 'Ferrero', 'Italia'),
('Kinder Bueno', 'Barquillo relleno de crema de avellana cubierto de chocolate con leche.', 'kinder_bueno.jpg', 32.00, 110, 'Ferrero', 'Italia'),
('Pringles Original 124 g', 'Papas fritas apiladas en su clásico tubo.', 'pringles.jpg', 69.00, 85, 'Kellanova', 'Estados Unidos'),
('Café de Chiapas en grano 1 kg', 'Café arábica de altura con tueste medio y notas a chocolate.', 'cafe_chiapas.jpg', 289.00, 40, 'Finca Chiapaneca', 'México'),

-- Tecnología
('AirPods Pro 2', 'Audífonos inalámbricos con cancelación activa de ruido y estuche USB-C.', 'airpods_pro.jpg', 5499.00, 25, 'Apple', 'Estados Unidos'),
('Kindle Paperwhite', 'Lector de libros electrónicos de 7 pulgadas con luz ajustable y resistente al agua.', 'kindle.jpg', 3499.00, 20, 'Amazon', 'Estados Unidos'),
('Bocina JBL Flip 6', 'Bocina Bluetooth portátil a prueba de agua con 12 horas de batería.', 'jbl_flip6.jpg', 2799.00, 30, 'JBL', 'Estados Unidos'),
('Control DualSense PS5', 'Control inalámbrico con retroalimentación háptica y gatillos adaptativos.', 'dualsense.jpg', 1599.00, 35, 'Sony', 'Japón'),
('Mouse Logitech MX Master 3S', 'Mouse ergonómico inalámbrico con clics silenciosos y scroll ultrarrápido.', 'mx_master.jpg', 2199.00, 25, 'Logitech', 'Suiza'),
('Cargador Anker 65W', 'Cargador USB-C compacto para laptop, tablet y celular.', 'anker_65w.jpg', 899.00, 50, 'Anker', 'China'),
('Audífonos Sony WH-1000XM5', 'Audífonos de diadema con cancelación de ruido líder y 30 horas de batería.', 'sony_xm5.jpg', 6999.00, 15, 'Sony', 'Japón'),
('Lámpara LED de escritorio', 'Lámpara regulable con tres tonos de luz y brazo ajustable.', 'lampara_led.jpg', 799.00, 45, 'Xiaomi', 'China'),

-- Moda y accesorios
('Bolsa Saint Laurent Lou', 'Bolsa tipo cámara de piel acolchada con logo metálico y correa ajustable.', 'bolsa_ysl.jpg', 38900.00, 5, 'Yves Saint Laurent', 'Francia'),
('Tenis Nike Air Force 1', 'Tenis clásicos de piel blanca con suela de aire.', 'air_force_1.jpg', 2599.00, 30, 'Nike', 'Estados Unidos'),
('Lentes de sol Ray-Ban Wayfarer', 'Lentes con armazón negro y micas con protección UV.', 'rayban.jpg', 3290.00, 20, 'Ray-Ban', 'Italia'),
('Gorra New Era 59FIFTY', 'Gorra cerrada de visera plana color negro.', 'gorra_new_era.jpg', 899.00, 40, 'New Era', 'Estados Unidos'),
('Perfume Dior Sauvage 100 ml', 'Eau de toilette masculina con notas frescas de bergamota y pimienta.', 'dior_sauvage.jpg', 2950.00, 18, 'Dior', 'Francia'),
('Mochila Herschel Little America', 'Mochila con compartimento acolchado para laptop de 15 pulgadas.', 'herschel.jpg', 1999.00, 25, 'Herschel Supply Co.', 'Canadá'),
('Cartera Tommy Hilfiger', 'Cartera de piel con tarjetero y monedero.', 'cartera_tommy.jpg', 1099.00, 35, 'Tommy Hilfiger', 'Estados Unidos'),

-- Hogar y estilo de vida
('Termo Owala FreeSip 24 oz', 'Termo de acero inoxidable con popote integrado y boquilla para beber directo.', 'owala.jpg', 749.00, 40, 'Owala', 'Estados Unidos'),
('Vela aromática 3 mechas', 'Vela de 411 g con aroma a vainilla y hasta 45 horas de duración.', 'vela.jpg', 549.00, 30, 'Bath & Body Works', 'Estados Unidos'),
('Cafetera Nespresso Vertuo Pop', 'Cafetera de cápsulas compacta que prepara cinco tamaños de taza.', 'nespresso.jpg', 2499.00, 15, 'Nespresso', 'Suiza'),
('LEGO Bonsái', 'Set para armar un bonsái decorativo de 878 piezas.', 'lego_bonsai.jpg', 1199.00, 20, 'LEGO', 'Dinamarca'),
('Juego de cartas UNO', 'El clásico juego de cartas para 2 a 10 jugadores.', 'uno.jpg', 99.00, 60, 'Mattel', 'Estados Unidos');