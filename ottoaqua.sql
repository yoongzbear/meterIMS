-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 04, 2024 at 04:32 AM
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
  `meter_type` varchar(100) NOT NULL,
  `meter_model` varchar(100) NOT NULL,
  `meter_size` int NOT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`batch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `batch`
--

INSERT INTO `batch` (`batch_id`, `meter_type`, `meter_model`, `meter_size`, `quantity`) VALUES
(1, 'Mechanical Meter - Brass Body & Piston Volumetric Type', 'PSM Volumetric 15mm', 20, 0),
(2, 'Mechanical Meter - Brass Body & Piston Volumetric Type', 'PSM Volumetric 15mm', 20, 3),
(3, 'Mechanical Meter - Brass Body & Piston Volumetric Type', 'PSM Volumetric 15mm', 20, 2),
(4, 'Mechanical Meter - Brass Body & Piston Volumetric Type', 'PSM Volumetric 15mm', 20, 2),
(5, 'Mechanical Meter - Brass Body & Piston Volumetric Type', 'PSM Volumetric 15mm', 20, 0);

-- --------------------------------------------------------

--
-- Table structure for table `inbound`
--

DROP TABLE IF EXISTS `inbound`;
CREATE TABLE IF NOT EXISTS `inbound` (
  `inbound_id` int NOT NULL AUTO_INCREMENT,
  `location_id` int NOT NULL,
  PRIMARY KEY (`inbound_id`),
  KEY `location_id` (`location_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `inbound`
--

INSERT INTO `inbound` (`inbound_id`, `location_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `lab_result`
--

DROP TABLE IF EXISTS `lab_result`;
CREATE TABLE IF NOT EXISTS `lab_result` (
  `test_id` int NOT NULL AUTO_INCREMENT,
  `serial_num` varchar(15) NOT NULL,
  `receive_date` date DEFAULT NULL,
  `test_date` date DEFAULT NULL,
  `result` varchar(6) DEFAULT NULL,
  `defect_id` int DEFAULT NULL,
  PRIMARY KEY (`test_id`),
  KEY `serial_num` (`serial_num`),
  KEY `defect_id` (`defect_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `lab_result`
--

INSERT INTO `lab_result` (`test_id`, `serial_num`, `receive_date`, `test_date`, `result`, `defect_id`) VALUES
(1, 'AIS17BA0000001', '2024-01-02', '2024-01-10', 'PASSED', NULL),
(2, 'AIS17BA0000002', '2024-01-02', '2024-01-10', 'PASSED', NULL),
(3, 'AIS17BA0000003', '2024-01-02', '2024-01-10', 'PASSED', NULL),
(4, 'AIS17BA0000004', '2024-01-02', '2024-01-10', 'PASSED', NULL),
(5, 'AIS17BA0000005', '2024-01-02', '2024-01-10', 'PASSED', NULL),
(6, 'AIS17BA0000006', '2024-01-02', '2024-01-10', 'PASSED', NULL),
(7, 'AIS17BA0000008', '2024-01-02', '2024-01-10', 'PASSED', NULL),
(8, 'AIS17BA0000009', '2024-01-02', '2024-01-10', 'PASSED', NULL),
(9, 'AIS17BA0000010', '2024-01-02', '2024-01-10', 'FAILED', 1),
(15, 'AIS17BA0000001', '2024-04-02', '2024-04-26', 'FAILED', 3);

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

DROP TABLE IF EXISTS `location`;
CREATE TABLE IF NOT EXISTS `location` (
  `location_id` int NOT NULL AUTO_INCREMENT,
  `location_name` varchar(50) NOT NULL,
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`location_id`, `location_name`) VALUES
(1, 'Air Selangor Inventory Department'),
(2, 'Air Selangor Test Lab'),
(3, 'Shah Alam'),
(4, 'Subang Jaya');

-- --------------------------------------------------------

--
-- Table structure for table `manufacturer`
--

DROP TABLE IF EXISTS `manufacturer`;
CREATE TABLE IF NOT EXISTS `manufacturer` (
  `manu_id` int NOT NULL AUTO_INCREMENT,
  `manu_name` varchar(100) NOT NULL,
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
  `location_id` int DEFAULT NULL,
  PRIMARY KEY (`serial_num`),
  KEY `location_id` (`location_id`),
  KEY `manu_id` (`manu_id`),
  KEY `batch_id` (`batch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `meter`
--

INSERT INTO `meter` (`serial_num`, `install_date`, `age`, `mileage`, `batch_id`, `meter_status`, `install_address`, `manufactured_year`, `manu_id`, `location_id`) VALUES
('AIS17BA0000001', '2024-02-10', 1.0, 12, 5, 'FAILED', '21, USJ 17/B, 44329 Subang Jaya', 2023, 2, 4),
('AIS17BA0000002', '2024-02-10', 1.0, 14, 2, 'INSTALLED', '3, SS15/12A 31238 Subang Jaya', 2023, 2, 4),
('AIS17BA0000003', NULL, 1.4, 123, 2, 'TO BE INSTALLED', NULL, 2023, 2, 4),
('AIS17BA0000004', NULL, 1.3, 90, 2, 'IN STORE', NULL, 2023, 2, 4),
('AIS17BA0000005', NULL, 1.4, 127, 4, 'IN STORE', NULL, 2023, 2, 3),
('AIS17BA0000006', NULL, 1.7, 2345, 4, 'IN STORE', NULL, 2023, 2, 3),
('AIS17BA0000008', NULL, 2.0, 32314, 3, 'IN STORE', NULL, 2022, 2, 3),
('AIS17BA0000009', NULL, 1.2, 60, 3, 'IN STORE', NULL, 2023, 2, 3),
('AIS17BA0000010', NULL, 1.6, 1332, 1, 'FAILED', NULL, 2023, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `movement`
--

DROP TABLE IF EXISTS `movement`;
CREATE TABLE IF NOT EXISTS `movement` (
  `tracking_id` int NOT NULL AUTO_INCREMENT,
  `outbound_id` int NOT NULL,
  `inbound_id` int NOT NULL,
  `ship_date` date NOT NULL,
  `arrival_date` date DEFAULT NULL,
  `batch_id` int NOT NULL,
  PRIMARY KEY (`tracking_id`),
  KEY `outbound_id` (`outbound_id`),
  KEY `inbound_id` (`inbound_id`),
  KEY `batch_id` (`batch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `movement`
--

INSERT INTO `movement` (`tracking_id`, `outbound_id`, `inbound_id`, `ship_date`, `arrival_date`, `batch_id`) VALUES
(1, 1, 2, '2023-12-26', '2024-01-02', 1),
(2, 2, 1, '2024-01-11', '2024-01-15', 1),
(3, 1, 4, '2024-01-20', '2024-01-25', 2),
(4, 1, 3, '2024-01-20', '2024-01-24', 3),
(5, 4, 3, '2024-01-30', '2024-02-03', 4),
(6, 4, 2, '2024-03-29', '2024-04-02', 5);

-- --------------------------------------------------------

--
-- Table structure for table `outbound`
--

DROP TABLE IF EXISTS `outbound`;
CREATE TABLE IF NOT EXISTS `outbound` (
  `outbound_id` int NOT NULL AUTO_INCREMENT,
  `location_id` int NOT NULL,
  PRIMARY KEY (`outbound_id`),
  KEY `location_id` (`location_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `outbound`
--

INSERT INTO `outbound` (`outbound_id`, `location_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `useraccount`
--

DROP TABLE IF EXISTS `useraccount`;
CREATE TABLE IF NOT EXISTS `useraccount` (
  `username` varchar(16) NOT NULL,
  `password` varchar(16) NOT NULL,
  `name` varchar(50) NOT NULL,
  `emp_type` varchar(25) NOT NULL,
  `location_id` int DEFAULT NULL,
  PRIMARY KEY (`username`),
  KEY `location_id` (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `useraccount`
--

INSERT INTO `useraccount` (`username`, `password`, `name`, `emp_type`, `location_id`) VALUES
('alya', 'nam12345', 'Alya Mastura', 'region store', 4),
('paola', 'pwr12345', 'Paola Wan', 'inventory department', 1),
('reyes', 'bing1234', 'Reyes Wong', 'contractor', NULL),
('wendy', 'wlsi1234', 'Wendy Lai', 'lab tester', 2),
('yuna', 'yhms1234', 'Yuna Hee', 'region store', 3);

-- --------------------------------------------------------

--
-- Table structure for table `warranty`
--

DROP TABLE IF EXISTS `warranty`;
CREATE TABLE IF NOT EXISTS `warranty` (
  `warranty_id` int NOT NULL AUTO_INCREMENT,
  `warranty_status` varchar(12) DEFAULT NULL,
  `test_id` int NOT NULL,
  PRIMARY KEY (`warranty_id`),
  KEY `test_id` (`test_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `warranty`
--

INSERT INTO `warranty` (`warranty_id`, `warranty_status`, `test_id`) VALUES
(1, 'CAN CLAIM', 1);

-- --------------------------------------------------------

--
-- Table structure for table `warranty_defect`
--

DROP TABLE IF EXISTS `warranty_defect`;
CREATE TABLE IF NOT EXISTS `warranty_defect` (
  `defect_id` int NOT NULL AUTO_INCREMENT,
  `defect` varchar(100) NOT NULL,
  PRIMARY KEY (`defect_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `warranty_defect`
--

INSERT INTO `warranty_defect` (`defect_id`, `defect`) VALUES
(1, 'Digit jumping at indicating device or totalizer'),
(2, 'Indicating device/totalizer crack naturally'),
(3, 'Leaking through indicating device, totalizer or register window'),
(4, 'No meter serial number'),
(5, 'Unidentified meter serial number'),
(6, 'Duplication of meter serial number'),
(7, 'Gear drive train failure due to manufacturing defect'),
(8, 'Leaking at any part of meter body and/or indicating device/totalizer'),
(10, 'Pinch hole at upper and/or lower body of water meter'),
(11, 'Threading defects'),
(12, 'Condensation inside counter register'),
(13, 'Misalignment of the indicating device/totalizer digits'),
(14, 'Connector and/or nut material and/or thread defects due to manufacturing'),
(15, 'Unidentified, unreadable and/or damages of QR code sticker due to manufacturing'),
(16, 'Sticker meter serial number differ from physical body water meter serial number');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inbound`
--
ALTER TABLE `inbound`
  ADD CONSTRAINT `inbound_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `location` (`location_id`);

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
  ADD CONSTRAINT `meter_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `location` (`location_id`),
  ADD CONSTRAINT `meter_ibfk_2` FOREIGN KEY (`manu_id`) REFERENCES `manufacturer` (`manu_id`),
  ADD CONSTRAINT `meter_ibfk_3` FOREIGN KEY (`batch_id`) REFERENCES `batch` (`batch_id`);

--
-- Constraints for table `movement`
--
ALTER TABLE `movement`
  ADD CONSTRAINT `movement_ibfk_1` FOREIGN KEY (`outbound_id`) REFERENCES `outbound` (`outbound_id`),
  ADD CONSTRAINT `movement_ibfk_2` FOREIGN KEY (`inbound_id`) REFERENCES `inbound` (`inbound_id`),
  ADD CONSTRAINT `movement_ibfk_3` FOREIGN KEY (`batch_id`) REFERENCES `batch` (`batch_id`);

--
-- Constraints for table `outbound`
--
ALTER TABLE `outbound`
  ADD CONSTRAINT `outbound_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `location` (`location_id`);

--
-- Constraints for table `useraccount`
--
ALTER TABLE `useraccount`
  ADD CONSTRAINT `useraccount_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `location` (`location_id`);

--
-- Constraints for table `warranty`
--
ALTER TABLE `warranty`
  ADD CONSTRAINT `warranty_ibfk_1` FOREIGN KEY (`test_id`) REFERENCES `lab_result` (`test_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
