-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 09, 2021 at 04:46 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `HuaD_HIS`
--

-- --------------------------------------------------------

--
-- Table structure for table `Account`
--

CREATE TABLE `Account` (
  `accountID` varchar(15) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `accountType` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Account`
--

INSERT INTO `Account` (`accountID`, `username`, `password`, `accountType`) VALUES
('A0001', 'a', '123', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `Case_Has_Medicine`
--

CREATE TABLE `Case_Has_Medicine` (
  `caseID` varchar(15) NOT NULL,
  `medID` varchar(15) NOT NULL,
  `numDose` int(5) NOT NULL,
  `totalPrice` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Disease`
--

CREATE TABLE `Disease` (
  `diseaseID` varchar(10) NOT NULL,
  `diseaseName` int(11) NOT NULL,
  `description` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Medicine`
--

CREATE TABLE `Medicine` (
  `medID` varchar(15) NOT NULL,
  `medName` int(11) NOT NULL,
  `medType` int(11) NOT NULL,
  `priceperdose` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `cabinetID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Patient`
--

CREATE TABLE `Patient` (
  `patientID` varchar(15) NOT NULL,
  `patientTitle` varchar(5) NOT NULL,
  `patientFN` varchar(40) NOT NULL,
  `patientLN` varchar(40) NOT NULL,
  `patientIdenID` varchar(13) NOT NULL,
  `patientTel` varchar(10) NOT NULL,
  `patientAge` int(5) NOT NULL,
  `patientGender` varchar(10) NOT NULL,
  `patientDoB` date NOT NULL,
  `patientPic` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `PatientCase`
--

CREATE TABLE `PatientCase` (
  `caseID` varchar(15) NOT NULL,
  `patientID` varchar(15) NOT NULL,
  `weight` int(5) NOT NULL,
  `height` int(5) NOT NULL,
  `sbp` int(5) NOT NULL,
  `dbp` int(5) NOT NULL,
  `diseaseID` varchar(15) NOT NULL,
  `staffID` varchar(15) NOT NULL,
  `payAmount` int(11) NOT NULL,
  `payMethod` varchar(10) NOT NULL,
  `payStatus` varchar(10) NOT NULL,
  `regisTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Staff`
--

CREATE TABLE `Staff` (
  `staffID` varchar(15) NOT NULL,
  `staffTitle` varchar(5) NOT NULL,
  `staffFN` varchar(40) NOT NULL,
  `staffLN` varchar(40) NOT NULL,
  `staffIdenID` varchar(13) NOT NULL,
  `staffTel` varchar(10) NOT NULL,
  `staffAge` int(5) NOT NULL,
  `staffDoB` date NOT NULL,
  `staffGender` varchar(10) NOT NULL,
  `roleID` varchar(10) NOT NULL,
  `staffStatus` varchar(15) NOT NULL,
  `accountID` varchar(15) DEFAULT NULL,
  `staffPic` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Staff`
--

INSERT INTO `Staff` (`staffID`, `staffTitle`, `staffFN`, `staffLN`, `staffIdenID`, `staffTel`, `staffAge`, `staffDoB`, `staffGender`, `roleID`, `staffStatus`, `accountID`, `staffPic`) VALUES
('S00001', 'Mr.', 'Pasin', 'Harisadee', '1210101140246', '0981022251', 20, '2001-01-12', 'Male', 'R001', 'Active', NULL, 'asdasd');

-- --------------------------------------------------------

--
-- Table structure for table `StaffRole`
--

CREATE TABLE `StaffRole` (
  `roleID` varchar(15) NOT NULL,
  `roleName` varchar(40) NOT NULL,
  `salary` int(11) NOT NULL,
  `department` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `StaffRole`
--

INSERT INTO `StaffRole` (`roleID`, `roleName`, `salary`, `department`) VALUES
('R001', 'Management Director', 100000, 'Administration');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Account`
--
ALTER TABLE `Account`
  ADD PRIMARY KEY (`accountID`);

--
-- Indexes for table `Case_Has_Medicine`
--
ALTER TABLE `Case_Has_Medicine`
  ADD KEY `caseID` (`caseID`),
  ADD KEY `medID` (`medID`);

--
-- Indexes for table `Disease`
--
ALTER TABLE `Disease`
  ADD PRIMARY KEY (`diseaseID`);

--
-- Indexes for table `Medicine`
--
ALTER TABLE `Medicine`
  ADD PRIMARY KEY (`medID`);

--
-- Indexes for table `Patient`
--
ALTER TABLE `Patient`
  ADD PRIMARY KEY (`patientID`);

--
-- Indexes for table `PatientCase`
--
ALTER TABLE `PatientCase`
  ADD PRIMARY KEY (`caseID`),
  ADD KEY `diseaseID` (`diseaseID`),
  ADD KEY `patientID` (`patientID`),
  ADD KEY `staffID` (`staffID`);

--
-- Indexes for table `Staff`
--
ALTER TABLE `Staff`
  ADD PRIMARY KEY (`staffID`),
  ADD KEY `roleID` (`roleID`),
  ADD KEY `accountID` (`accountID`);

--
-- Indexes for table `StaffRole`
--
ALTER TABLE `StaffRole`
  ADD PRIMARY KEY (`roleID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Case_Has_Medicine`
--
ALTER TABLE `Case_Has_Medicine`
  ADD CONSTRAINT `caseID` FOREIGN KEY (`caseID`) REFERENCES `PatientCase` (`caseID`),
  ADD CONSTRAINT `medID` FOREIGN KEY (`medID`) REFERENCES `Medicine` (`medID`);

--
-- Constraints for table `PatientCase`
--
ALTER TABLE `PatientCase`
  ADD CONSTRAINT `diseaseID` FOREIGN KEY (`diseaseID`) REFERENCES `Disease` (`diseaseID`),
  ADD CONSTRAINT `patientID` FOREIGN KEY (`patientID`) REFERENCES `Patient` (`patientID`),
  ADD CONSTRAINT `staffID` FOREIGN KEY (`staffID`) REFERENCES `Staff` (`staffID`);

--
-- Constraints for table `Staff`
--
ALTER TABLE `Staff`
  ADD CONSTRAINT `accountID` FOREIGN KEY (`accountID`) REFERENCES `Account` (`accountID`),
  ADD CONSTRAINT `roleID` FOREIGN KEY (`roleID`) REFERENCES `StaffRole` (`roleID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
