<?php
    require_once 'config.php';

    class DataBase
    {
      protected $db;

      public function __construct()
      {
        try {
          $this->db = new PDO("mysql:host=" . MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
          $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $this->db->exec("CREATE DATABASE IF NOT EXISTS " . MYSQL_DB);
          $this->db = new PDO("mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DB . ";charset=utf8mb4", MYSQL_USER, MYSQL_PASS);
          $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $this->_deploy();
        } catch (PDOException $e) {

          echo "Error de conexión: " . $e->getMessage();
          exit;
        }
      }

      private function _deploy()

      {
        $query = $this->db->query('SHOW TABLES');
        $tables = $query->fetchAll();
        if (count($tables) == 0) {

          $sql = <<<END
                -- phpMyAdmin SQL Dump
                -- version 5.2.1
                -- https://www.phpmyadmin.net/
                --
                -- Servidor: 127.0.0.1
                -- Tiempo de generación: 18-11-2024 a las 00:22:28
                -- Versión del servidor: 10.4.32-MariaDB
                -- Versión de PHP: 8.0.30

                SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
                START TRANSACTION;
                SET time_zone = "+00:00";


                /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
                /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
                /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
                /*!40101 SET NAMES utf8mb4 */;

                --
                -- Base de datos: `g160_db_tienda_celulares`
                --

                -- --------------------------------------------------------

                --
                -- Estructura de tabla para la tabla `category`
                --

                CREATE TABLE `category` (
                  `id_category` int(11) NOT NULL,
                  `brand` varchar(60) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                --
                -- Volcado de datos para la tabla `category`
                --

                INSERT INTO `category` (`id_category`, `brand`) VALUES
                (1, 'samsung'),
                (2, 'sony'),
                (3, 'google'),
                (9, 'motorola'),
                (15, 'apple'),
                (16, 'huawei'),
                (18, 'xiaomi');

                -- --------------------------------------------------------

                --
                -- Estructura de tabla para la tabla `order_phone`
                --

                CREATE TABLE `order_phone` (
                  `id_order` int(11) NOT NULL,
                  `id_product` int(11) NOT NULL,
                  `id_user` int(11) NOT NULL,
                  `purchase_date` date NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                -- --------------------------------------------------------

                --
                -- Estructura de tabla para la tabla `product`
                --

                CREATE TABLE `product` (
                  `id` int(11) NOT NULL,
                  `img` varchar(250) NOT NULL,
                  `name` varchar(200) NOT NULL,
                  `description` text NOT NULL,
                  `camera` double NOT NULL,
                  `system` varchar(30) NOT NULL,
                  `screen` double NOT NULL,
                  `id_brand` int(60) NOT NULL,
                  `gamma` varchar(10) NOT NULL,
                  `price` double NOT NULL,
                  `offer` int(11) NOT NULL,
                  `offer_price` double NOT NULL,
                  `stock` tinyint(1) NOT NULL,
                  `quota` int(11) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                --
                -- Volcado de datos para la tabla `product`
                --

                INSERT INTO `product` (`id`, `img`, `name`, `description`, `camera`, `system`, `screen`, `id_brand`, `gamma`, `price`, `offer`, `offer_price`, `stock`, `quota`) VALUES
                (45, 'https://www.cordobadigital.net/wp-content/uploads/2024/05/A55-5G.png', 'Samsung A55 5G', 'Smartphone de gama alta con cámara de 42 MP', 42, 'Android 12', 6.5, 1, 'high', 5000, 50, 2500, 1, 12),
                (46, 'https://multipoint.com.ar/Image/0/750_750-A5.jpg', 'Samsung A5', 'Smartphone con cámara de 40 MP y pantalla AMOLED', 40, 'Android 11', 6.2, 1, 'medium', 3500, 20, 2800, 1, 6),
                (47, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTgSDExn3w0bkbKHfdCsVZbHP-vQPiTRr3JTg&s', 'Samsung Galaxy S20', 'Teléfono de alta gama con cámara de 64 MP', 64, 'Android 10', 6.7, 1, 'high', 8000, 30, 5600, 1, 12),
                (48, 'https://static.hendel.com/media/catalog/product/cache/0c3e9ac8430b5a3e77d1544ae1698a10/4/8/48229-min_1.jpg', 'Samsung Galaxy M32', 'Smartphone con cámara de 64 MP y pantalla FHD+', 64, 'Android 11', 6.4, 1, 'low', 4500, 0, 4500, 0, 0),
                (49, 'https://http2.mlstatic.com/D_NQ_NP_864844-MLM51559388062_092022-O.webp', 'Apple iPhone 13', 'iPhone 13 con cámara de 12 MP y procesador A15', 12, 'iOS', 6.1, 15, 'high', 12000, 15, 10200, 1, 6),
                (50, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS7drR5U44Gm3PJEdkFG-Yj08FqxDLs5lPs4g&s', 'Apple iPhone SE', 'iPhone SE con cámara de 12 MP y procesador A13', 12, 'iOS', 4.7, 15, 'medium', 8000, 10, 7200, 1, 12),
                (51, 'https://http2.mlstatic.com/D_939427-MLU79132024637_092024-C.jpg', 'Apple iPhone 14', 'iPhone 14 con cámara de 48 MP y pantalla OLED', 48, 'iOS', 6.7, 15, 'high', 15000, 20, 12000, 1, 6),
                (52, 'https://www.molex.com.ar/wp-content/uploads/2024/06/6942103123924-001-750Wx750H.webp', 'Huawei P40', 'Smartphone Huawei P40 con cámara de 50 MP', 50, 'Android 10', 6.1, 16, 'high', 7000, 30, 4900, 1, 6),
                (53, 'https://i.ebayimg.com/images/g/SxQAAOSwScVhGpoE/s-l1600.webp', 'Huawei Nova 9', 'Huawei Nova 9 con cámara de 50 MP y pantalla OLED', 50, 'Android 11', 6.57, 16, 'medium', 4500, 15, 3825, 1, 12),
                (54, 'https://m.media-amazon.com/images/I/616+kGLMqJL.jpg', 'Huawei Mate 40 Pro', 'Huawei Mate 40 Pro con cámara de 50 MP y 8 GB de RAM', 50, 'Android 10', 6.76, 16, 'low', 11000, 0, 11000, 0, 6),
                (55, 'https://http2.mlstatic.com/D_NQ_NP_626285-MLA72983925890_112023-O.webp', 'Google Pixel 7', 'Google Pixel 7 con cámara de 50 MP y Android 13', 50, 'Android 13', 6.3, 3, 'high', 9000, 25, 6750, 1, 12),
                (56, 'https://celularesindustriales.com.ar/wp-content/uploads/71h9zq4viSL._AC_UF8941000_QL80_.jpg', 'Google Pixel 6 Pro', 'Pixel 6 Pro con cámara de 50 MP y pantalla OLED', 50, 'Android 12', 6.7, 3, 'high', 10000, 20, 8000, 1, 6),
                (57, 'https://gadgetward.com.mx/cdn/shop/products/GooglePixel6Pro128GB12GB_RAM_StormyBlack_64096629-a2e6-4410-a5ac-078e24c8b5e2_1200x1200.jpg?v=1649076865', 'Google Pixel 6', 'Smartphone Google Pixel 6 con cámara de 12 MP', 12, 'Android 12', 6.4, 3, 'medium', 6500, 0, 6500, 0, 6),
                (58, 'https://celularesindustriales.com.ar/wp-content/uploads/white_815c8a82-139f-422d-85d0-96e174cb4e55_800x.webp', 'Sony Xperia 5 V', 'Sony Xperia 5 V con cámara de 12 MP y pantalla OLED', 12, 'Android 11', 6.1, 2, 'high', 7000, 30, 4900, 1, 6),
                (59, 'https://http2.mlstatic.com/D_Q_NP_886236-MLA48708038326_122021-O.webp', 'Sony Xperia 1 II', 'Sony Xperia 1 II con cámara de 12 MP y procesador Snapdragon 865', 12, 'Android 10', 6.5, 2, 'medium', 8500, 15, 7225, 1, 12),
                (60, 'https://img.pccomponentes.com/articles/1078/10789719/1432-sony-xperia-5-v-5g-61-oled-8-128gb-negro-libre.jpg', 'Sony Xperia 5 II', 'Smartphone Sony Xperia 5 II con cámara de 12 MP y pantalla OLED', 12, 'Android 10', 6.1, 2, 'low', 6500, 0, 6500, 0, 6),
                (61, 'https://http2.mlstatic.com/D_939427-MLU79132024637_092024-C.jpg', 'Apple iPhone 14', 'iPhone 14 con cámara de 48 MP y pantalla OLED', 48, 'iOS', 6.7, 15, 'high', 15000, 0, 15000, 1, 6);

                -- --------------------------------------------------------

                --
                -- Estructura de tabla para la tabla `user`
                --

                CREATE TABLE `user` (
                  `id` int(11) NOT NULL,
                  `img_profile` varchar(250) DEFAULT NULL,
                  `name` varchar(60) NOT NULL,
                  `email` varchar(250) NOT NULL,
                  `password` varchar(60) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                --
                -- Volcado de datos para la tabla `user`
                --

                INSERT INTO `user` (`id`, `img_profile`, `name`, `email`, `password`) VALUES
                (1, 'https://plus.unsplash.com/premium_photo-1661405578751-dc9d663710bd?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8YWRtaW58ZW58MHx8MHx8fDA%3D', 'webadmin', 'admin123@hotmail.com.ar', '$2y$10$4PVsW.OOhRJ.rcyMtk90feBM0kPFGOjvdwEuNem9VSG1UX.ck/eui');

                --
                -- Índices para tablas volcadas
                --

                --
                -- Indices de la tabla `category`
                --
                ALTER TABLE `category`
                  ADD PRIMARY KEY (`id_category`);

                --
                -- Indices de la tabla `order_phone`
                --
                ALTER TABLE `order_phone`
                  ADD PRIMARY KEY (`id_order`),
                  ADD KEY `id_product` (`id_product`),
                  ADD KEY `id_product_2` (`id_product`);

                --
                -- Indices de la tabla `product`
                --
                ALTER TABLE `product`
                  ADD PRIMARY KEY (`id`),
                  ADD KEY `id_brand` (`id_brand`);

                --
                -- Indices de la tabla `user`
                --
                ALTER TABLE `user`
                  ADD PRIMARY KEY (`id`),
                  ADD UNIQUE KEY `email` (`email`),
                  ADD UNIQUE KEY `name` (`name`);

                --
                -- AUTO_INCREMENT de las tablas volcadas
                --

                --
                -- AUTO_INCREMENT de la tabla `category`
                --
                ALTER TABLE `category`
                  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

                --
                -- AUTO_INCREMENT de la tabla `order_phone`
                --
                ALTER TABLE `order_phone`
                  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT;

                --
                -- AUTO_INCREMENT de la tabla `product`
                --
                ALTER TABLE `product`
                  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

                --
                -- AUTO_INCREMENT de la tabla `user`
                --
                ALTER TABLE `user`
                  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

                --
                -- Restricciones para tablas volcadas
                --

                --
                -- Filtros para la tabla `order_phone`
                --
                ALTER TABLE `order_phone`
                  ADD CONSTRAINT `order_phone_ibfk_1` FOREIGN KEY (`id_product`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

                --
                -- Filtros para la tabla `product`
                --
                ALTER TABLE `product`
                  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`id_brand`) REFERENCES `category` (`id_category`) ON DELETE CASCADE ON UPDATE CASCADE;
                COMMIT;

                /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
                /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
                /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

                END;


          $this->db->exec($sql);
        }
      }
    }