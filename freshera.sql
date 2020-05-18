-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2020 at 10:07 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `freshera`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `phone` varchar(13) NOT NULL,
  `address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `phone`, `address`) VALUES
(3, 'Muhammad Harits Fadlilah', 'fadilzteria@gmail.com', '$2y$10$ME1NaXpaZGJnNTZ3WlN0YuHbSlJQ2iwHz/4bpSXuYGgGbRTCCWEga', '081234567890', 'Jl. Jendral Akhmad Yani');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `user`
  ADD COLUMN `is_admin` bool DEFAULT NULL;

INSERT INTO `user` (`id`, `name`, `email`, `password`, `phone`, `address`, `is_admin`) VALUES
(99, 'Admin', 'admin@admin.com', '$2y$10$SU5raFVMeVdNRThZSkFsW.VYATtUoDrlgiFuXXEz1thHDGafEVeFa', '081234567890', 'Jl. Jendral Akhmad Yani', '1');

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

-- ITEM

CREATE TABLE `item` (
  `item_id` int(11) NOT NULL,
  `item_nama` varchar(50) NOT NULL,
  `item_deskripsi` varchar(50) NOT NULL,
  `item_kategori` varchar(200) NOT NULL,
  `item_harga` varchar(13) NOT NULL,
  `item_stock` varchar(100) NOT NULL,
  `item_lokasi` varchar(100) NOT NULL,
  `item_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `item_foto` longblob
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `item`
  ADD PRIMARY KEY (`item_id`);
ALTER TABLE `item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;


INSERT INTO `item` (`item_id`, `item_nama`, `item_deskripsi`, `item_kategori`, `item_harga`, `item_stock`, `item_lokasi` ) VALUES
(1, 'Wortel', 'Wortel asli Indonesia', 'Sayur', '5000', '20', 'Pasar Keputih');


-- CART & ORDER

create table scOrder (
sc_id int auto_increment,
sc_date datetime,
sc_alamat varchar(30),
primary key(sc_id)
);


create table `order` (
order_id int auto_increment,
productid int,
-- orderid int,
userid int,
order_quantity int,
order_subtotal decimal(18,3),
order_foto longblob,
primary key(order_id),
foreign key(productid) references item(item_id),
-- foreign key(orderid) references scOrder(sc_id)
foreign key(userid) references user(id)
);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
