-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 16, 2024 at 12:27 PM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ottoaqua`
--

-- --------------------------------------------------------

--
-- Table structure for table `batch`
--

DROP TABLE IF EXISTS `batch`;
CREATE TABLE IF NOT EXISTS `batch` (
  `batch_id` int NOT NULL AUTO_INCREMENT,
  `store_id` int NOT NULL,
  `meter_type` varchar(100) NOT NULL,
  `meter_model` varchar(100) NOT NULL,
  `meter_size` int NOT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`batch_id`),
  KEY `store_id` (`store_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `batch`
--

INSERT INTO `batch` (`batch_id`, `store_id`, `meter_type`, `meter_model`, `meter_size`, `quantity`) VALUES
(1, 2, 'Mechanical Meter - Brass Body & Piston Volumetric Type', 'PSM Volumetric 15mm', 15, 10);

-- --------------------------------------------------------

--
-- Table structure for table `lab_result`
--

DROP TABLE IF EXISTS `lab_result`;
CREATE TABLE IF NOT EXISTS `lab_result` (
  `test_id` int NOT NULL AUTO_INCREMENT,
  `serial_num` varchar(15) NOT NULL,
  `test_date` date NOT NULL,
  `result` varchar(6) NOT NULL,
  `defect_id` int DEFAULT NULL,
  PRIMARY KEY (`test_id`),
  KEY `serial_num` (`serial_num`),
  KEY `defect_id` (`defect_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `manufacturer`
--

DROP TABLE IF EXISTS `manufacturer`;
CREATE TABLE IF NOT EXISTS `manufacturer` (
  `manu_id` int NOT NULL AUTO_INCREMENT,
  `manu_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`manu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `manufacturer`
--

INSERT INTO `manufacturer` (`manu_id`, `manu_name`) VALUES
(1, 'George Kent Malaysia'),
(2, 'Aqua Flo Sdn. Bhd.'),
(3, 'Ningbo Water Meter');

-- --------------------------------------------------------

--
-- Table structure for table `meter`
--

DROP TABLE IF EXISTS `meter`;
CREATE TABLE IF NOT EXISTS `meter` (
  `serial_num` varchar(15) NOT NULL,
  `install_date` date DEFAULT NULL,
  `age` float(3,1) NOT NULL,
  `mileage` int NOT NULL,
  `batch_id` int DEFAULT NULL,
  `meter_status` varchar(20) NOT NULL,
  `install_address` varchar(150) DEFAULT NULL,
  `manufactured_year` int NOT NULL,
  `manu_id` int NOT NULL,
  PRIMARY KEY (`serial_num`),
  KEY `batch_id` (`batch_id`),
  KEY `manu_id` (`manu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `meter`
--

INSERT INTO `meter` (`serial_num`, `install_date`, `age`, `mileage`, `batch_id`, `meter_status`, `install_address`, `manufactured_year`, `manu_id`) VALUES
('AIS17BA0000001', NULL, 6.5, 41417, 1, 'IN STORE', NULL, 2017, 1),
('AIS17BA0000002', NULL, 6.6, 5015, 1, 'IN STORE', NULL, 2017, 1),
('AIS17BA0000003', '2024-04-02', 6.5, 41417, 1, 'INSTALLED', 'subang jaya, 47669, selangor', 2017, 1);

-- --------------------------------------------------------

--
-- Table structure for table `movement`
--

DROP TABLE IF EXISTS `movement`;
CREATE TABLE IF NOT EXISTS `movement` (
  `tracking_id` int NOT NULL AUTO_INCREMENT,
  `origin` int NOT NULL,
  `destination` int NOT NULL,
  `ship_date` date NOT NULL,
  `arrival_date` date DEFAULT NULL,
  `batch_id` int NOT NULL,
  PRIMARY KEY (`tracking_id`),
  KEY `batch_id` (`batch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `movement`
--

INSERT INTO `movement` (`tracking_id`, `origin`, `destination`, `ship_date`, `arrival_date`, `batch_id`) VALUES
(1, 1, 2, '2024-03-31', '2024-04-02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `region_store`
--

DROP TABLE IF EXISTS `region_store`;
CREATE TABLE IF NOT EXISTS `region_store` (
  `store_id` int NOT NULL AUTO_INCREMENT,
  `region` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `username` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`store_id`),
  KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `region_store`
--

INSERT INTO `region_store` (`store_id`, `region`, `username`) VALUES
(1, 'Air Selangor', 'paola'),
(2, 'Kuala Lumpur', 'yuna'),
(3, 'Petaling', 'alya');

-- --------------------------------------------------------

--
-- Table structure for table `useraccount`
--

DROP TABLE IF EXISTS `useraccount`;
CREATE TABLE IF NOT EXISTS `useraccount` (
  `username` varchar(16) NOT NULL,
  `password` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `emp_type` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `useraccount`
--

INSERT INTO `useraccount` (`username`, `password`, `name`, `emp_type`) VALUES
('alya', 'wooahae4', 'Alya Mastura', 'region store'),
('paola', 'pwr12345', 'Paola Wan', 'inventory department'),
('reyes', 'bing1234', 'Reyes Wong', 'contractor'),
('wendy', 'wlsi1234', 'Wendy Lai', 'lab tester'),
('yuna', 'yhms1234', 'Yuna Hee', 'region store');

-- --------------------------------------------------------

--
-- Table structure for table `warranty`
--

DROP TABLE IF EXISTS `warranty`;
CREATE TABLE IF NOT EXISTS `warranty` (
  `warranty_id` int NOT NULL AUTO_INCREMENT,
  `serial_num` varchar(15) NOT NULL,
  `receive_date` date NOT NULL,
  `check_date` date DEFAULT NULL,
  `warranty_status` varchar(12) DEFAULT NULL,
  `test_id` int DEFAULT NULL,
  PRIMARY KEY (`warranty_id`),
  KEY `test_id` (`test_id`),
  KEY `serial_num` (`serial_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `warranty_defect`
--

DROP TABLE IF EXISTS `warranty_defect`;
CREATE TABLE IF NOT EXISTS `warranty_defect` (
  `defect_id` int NOT NULL AUTO_INCREMENT,
  `defect` varchar(100) NOT NULL,
  PRIMARY KEY (`defect_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `warranty_defect`
--

INSERT INTO `warranty_defect` (`defect_id`, `defect`) VALUES
(1, 'INACCURATE METER READING'),
(2, 'PHYSICAL DAMAGE'),
(3, 'LEAKING THROUGH INDICATING DEVICE & PULSE OUTPUT'),
(4, 'LEAKING AT ANY PART OF METER BODY'),
(5, 'UNCALIBERATED METER'),
(6, 'IMPROPER INSTALLATION'),
(7, 'OLD METER'),
(8, 'METER STUCK');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `batch`
--
ALTER TABLE `batch`
  ADD CONSTRAINT `batch_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `region_store` (`store_id`);

--
-- Constraints for table `lab_result`
--
ALTER TABLE `lab_result`
  ADD CONSTRAINT `lab_result_ibfk_1` FOREIGN KEY (`serial_num`) REFERENCES `meter` (`serial_num`),
  ADD CONSTRAINT `lab_result_ibfk_2` FOREIGN KEY (`defect_id`) REFERENCES `warranty_defect` (`defect_id`);

--
-- Constraints for table `meter`
--
ALTER TABLE `meter`
  ADD CONSTRAINT `meter_ibfk_1` FOREIGN KEY (`batch_id`) REFERENCES `batch` (`batch_id`),
  ADD CONSTRAINT `meter_ibfk_2` FOREIGN KEY (`manu_id`) REFERENCES `manufacturer` (`manu_id`);

--
-- Constraints for table `movement`
--
ALTER TABLE `movement`
  ADD CONSTRAINT `movement_ibfk_1` FOREIGN KEY (`batch_id`) REFERENCES `batch` (`batch_id`);

--
-- Constraints for table `region_store`
--
ALTER TABLE `region_store`
  ADD CONSTRAINT `region_store_ibfk_1` FOREIGN KEY (`username`) REFERENCES `useraccount` (`username`);

--
-- Constraints for table `warranty`
--
ALTER TABLE `warranty`
  ADD CONSTRAINT `warranty_ibfk_1` FOREIGN KEY (`test_id`) REFERENCES `lab_result` (`test_id`),
  ADD CONSTRAINT `warranty_ibfk_2` FOREIGN KEY (`serial_num`) REFERENCES `meter` (`serial_num`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
