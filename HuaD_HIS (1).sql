-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 17, 2021 at 07:35 PM
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

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `ShowPatientInfo` (IN `PID` VARCHAR(30))  SELECT * FROM Patient WHERE Patient.patientID=PID$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ShowPatientTreatment` (IN `PID` VARCHAR(15))  SELECT c.*,d.* FROM PatientCase c,Disease d WHERE c.patientID=PID AND d.diseaseID=c.diseaseID ORDER BY regisTime ASC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ShowStaffInfo` (`SID` VARCHAR(30))  BEGIN
	SELECT r.*,s.* FROM Staff s,StaffRole r WHERE s.staffID=SID AND r.roleID=s.roleID;
END$$

DELIMITER ;

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
('A0001', 'Admin', '1234', 'Admin'),
('A0002', 'Doctor', '1234', 'Doctor'),
('A0003', 'Pharmacist1', '1234', 'Pharmacist'),
('A0004', 'HR1', '1234', 'HR');

-- --------------------------------------------------------

--
-- Table structure for table `Disease`
--

CREATE TABLE `Disease` (
  `diseaseID` varchar(10) NOT NULL,
  `diseaseName` varchar(100) NOT NULL,
  `description` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Disease`
--

INSERT INTO `Disease` (`diseaseID`, `diseaseName`, `description`) VALUES
('D0001', 'Covid-19', 'Covid-19 is .......\r\n'),
('D0002', 'Diarrhea', 'Diarrhea is .........'),
('D0003', 'Lung Cancer', 'Lung Cancer is .......'),
('D0004', 'Open Wound', 'Open Wound is .....');

-- --------------------------------------------------------

--
-- Table structure for table `Medicine`
--

CREATE TABLE `Medicine` (
  `medID` varchar(15) NOT NULL,
  `medName` varchar(100) NOT NULL,
  `brand` varchar(100) NOT NULL,
  `medType` varchar(40) NOT NULL,
  `priceperdose` int(11) NOT NULL,
  `gramperdose` int(11) NOT NULL,
  `amountdose` int(11) NOT NULL,
  `cabinetID` varchar(15) NOT NULL,
  `medPic` varchar(255) NOT NULL,
  `annotation` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Medicine`
--

INSERT INTO `Medicine` (`medID`, `medName`, `brand`, `medType`, `priceperdose`, `gramperdose`, `amountdose`, `cabinetID`, `medPic`, `annotation`) VALUES
('M0001', 'Paracetamol', 'Sara', 'Tablet', 5, 30, 770, 'C0001', 'MedImage/Sara-Paracetamol.png', 'Paracetamol is used for ..........'),
('M0002', 'Paracetamol', 'Paracap', 'Tablet', 6, 50, 150, 'C0001', 'MedImage/Paracap-Paracetamol.png', 'Paracap Paracetamol is used for .........                              '),
('M0003', 'Bandage', '3M', 'Medical Disposables', 15, 50, 100, 'C0002', 'MedImage/3M-bandages.png', 'Premium bandage .......                                  ');

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

--
-- Dumping data for table `Patient`
--

INSERT INTO `Patient` (`patientID`, `patientTitle`, `patientFN`, `patientLN`, `patientIdenID`, `patientTel`, `patientAge`, `patientGender`, `patientDoB`, `patientPic`) VALUES
('P0001', 'Mr.', 'John', 'Doe', '1031356290578', '0812345679', 36, 'Male', '1985-08-09', 'PatientImage/John.png'),
('P0002', 'Mrs.', 'Somsri', 'Somsri', '1231231234321', '0813456789', 36, 'Female', '1985-11-04', 'PatientImage/Somsri.png'),
('P0003', 'Mr.', 'Somsak', 'Som', '1231234234567', '0981234567', 45, 'Male', '1976-09-14', 'PatientImage/Somsak.png'),
('P0004', 'Mr.', 'Teeraphat', 'Pinthongkham', '1031356290578', '0941872907', 28, 'Male', '1993-11-02', 'PatientImage/2021-07-15 (1).png');

-- --------------------------------------------------------

--
-- Table structure for table `PatientCase`
--

CREATE TABLE `PatientCase` (
  `caseID` varchar(15) NOT NULL,
  `patientID` varchar(15) DEFAULT NULL,
  `weight` int(5) NOT NULL,
  `height` int(5) NOT NULL,
  `sbp` int(5) NOT NULL,
  `dbp` int(5) NOT NULL,
  `diseaseID` varchar(15) NOT NULL,
  `staffID` varchar(15) DEFAULT NULL,
  `medCost` int(11) DEFAULT 0,
  `serviceCost` int(11) DEFAULT 0,
  `totalCost` int(11) DEFAULT 0,
  `payMethod` varchar(40) DEFAULT NULL,
  `payStatus` varchar(40) DEFAULT NULL,
  `regisTime` datetime NOT NULL,
  `annotation` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `PatientCase`
--

INSERT INTO `PatientCase` (`caseID`, `patientID`, `weight`, `height`, `sbp`, `dbp`, `diseaseID`, `staffID`, `medCost`, `serviceCost`, `totalCost`, `payMethod`, `payStatus`, `regisTime`, `annotation`) VALUES
('C0002', 'P0002', 55, 156, 120, 80, 'D0003', 'S0002', 120, 7000, 7120, 'Cash', 'Completed', '2021-11-17 23:01:06', 'saafsdfsadfas\r\n                                    '),
('C0003', 'P0003', 67, 175, 125, 78, 'D0002', 'S0002', 180, 5000, 5180, 'Cash', 'Completed', '2021-11-17 23:02:28', 'DSASDasdSADFAS\r\n                                    '),
('C0004', 'P0001', 60, 175, 120, 80, 'D0001', 'S0001', 100, 1500, 1600, 'Cash', 'Completed', '2021-11-18 01:33:34', 'dfsgdfgsdfg\r\n                                    ');

-- --------------------------------------------------------

--
-- Table structure for table `Prescription`
--

CREATE TABLE `Prescription` (
  `prescriptionID` varchar(15) NOT NULL,
  `caseID` varchar(15) NOT NULL,
  `medID` varchar(15) NOT NULL,
  `numDose` int(5) NOT NULL,
  `totalPrice` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Prescription`
--

INSERT INTO `Prescription` (`prescriptionID`, `caseID`, `medID`, `numDose`, `totalPrice`) VALUES
('I0002', 'C0002', 'M0002', 20, 120),
('I0003', 'C0003', 'M0002', 30, 180),
('I0004', 'C0004', 'M0001', 20, 100);

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
  `staffGender` varchar(10) NOT NULL,
  `staffDoB` date NOT NULL,
  `roleID` varchar(10) NOT NULL,
  `accountID` varchar(15) DEFAULT NULL,
  `staffPic` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Staff`
--

INSERT INTO `Staff` (`staffID`, `staffTitle`, `staffFN`, `staffLN`, `staffIdenID`, `staffTel`, `staffAge`, `staffGender`, `staffDoB`, `roleID`, `accountID`, `staffPic`) VALUES
('S0001', 'Mr.', 'Pasin', 'Harisadee', '1210101140246', '0981022251', 20, 'Male', '2001-01-11', 'R0001', 'A0001', 'StaffImage/Pasin.png'),
('S0002', 'Mrs.', 'Jane', 'Doe', '1234567891011', '0812345678', 34, 'Female', '1987-11-02', 'R0002', 'A0002', 'StaffImage/Jane.png'),
('S0003', 'Mr.', 'Pisarn', 'Saetung', '1234324123578', '0972367910', 43, 'Male', '1978-08-09', 'R0006', 'A0004', 'StaffImage/Pisarn.png'),
('S0004', 'Mrs.', 'Weeraya', 'Kittipakwong', '1092383425759', '0824891738', 30, 'Female', '1991-11-04', 'R0004', NULL, 'StaffImage/Weeraya.png'),
('S0005', 'Mr.', 'Pataphon', 'Wongsamran', '2134891038295', '0872938410', 20, 'Male', '2001-11-01', 'R0005', 'A0003', 'StaffImage/2021-07-15.png');

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
('R0001', 'Managing Director', 100000, 'Administration'),
('R0002', 'Doctor', 100000, 'Medical'),
('R0003', 'Nurse', 15000, 'Nursing'),
('R0004', 'Physiotherapist', 40000, 'Rehabilitation'),
('R0005', 'Pharmacist', 25000, 'Pharmacy'),
('R0006', 'Human Resource', 15000, 'Human Resource'),
('R0007', 'Housekeeping', 15000, 'Housekeeping');

-- --------------------------------------------------------

--
-- Table structure for table `Stocking`
--

CREATE TABLE `Stocking` (
  `stockID` varchar(15) NOT NULL,
  `medID` varchar(15) NOT NULL,
  `staffID` varchar(15) NOT NULL,
  `amount` int(11) NOT NULL,
  `regisTime` datetime NOT NULL,
  `Type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Stocking`
--

INSERT INTO `Stocking` (`stockID`, `medID`, `staffID`, `amount`, `regisTime`, `Type`) VALUES
('L0001', 'M0001', 'S0001', 500, '2021-11-09 00:00:00', 'Add'),
('L0002', 'M0001', 'S0001', 300, '2021-11-16 16:32:13', 'Add'),
('L0003', 'M0002', 'S0001', 200, '2021-11-16 16:45:13', 'Add'),
('L0004', 'M0003', 'S0005', 100, '2021-11-17 23:11:31', 'Add'),
('L0005', 'M0001', 'S0001', 10, '2021-11-17 23:21:47', 'Drop(Prescription)'),
('L0006', 'M0002', 'S0001', 20, '2021-11-17 23:22:17', 'Drop(Prescription)'),
('L0007', 'M0002', 'S0001', 30, '2021-11-17 23:22:41', 'Drop(Prescription)'),
('L0008', 'M0001', 'S0001', 20, '2021-11-18 01:33:44', 'Drop(Prescription)');

-- --------------------------------------------------------

--
-- Stand-in structure for view `view1`
-- (See below for the actual view)
--
CREATE TABLE `view1` (
`staffID` varchar(15)
,`staffTitle` varchar(5)
,`staffFN` varchar(40)
,`staffLN` varchar(40)
,`staffIdenID` varchar(13)
,`staffTel` varchar(10)
,`staffAge` int(5)
,`staffGender` varchar(10)
,`staffDoB` date
,`roleID` varchar(10)
,`accountID` varchar(15)
,`staffPic` varchar(250)
,`roleName` varchar(40)
,`department` varchar(40)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view2`
-- (See below for the actual view)
--
CREATE TABLE `view2` (
`staffID` varchar(15)
,`staffTitle` varchar(5)
,`staffFN` varchar(40)
,`staffLN` varchar(40)
,`staffIdenID` varchar(13)
,`staffTel` varchar(10)
,`staffAge` int(5)
,`staffGender` varchar(10)
,`staffDoB` date
,`roleID` varchar(10)
,`accountID` varchar(15)
,`staffPic` varchar(250)
,`roleName` varchar(40)
,`department` varchar(40)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view3`
-- (See below for the actual view)
--
CREATE TABLE `view3` (
`staffID` varchar(15)
,`staffTitle` varchar(5)
,`staffFN` varchar(40)
,`staffLN` varchar(40)
,`staffIdenID` varchar(13)
,`staffTel` varchar(10)
,`staffAge` int(5)
,`staffGender` varchar(10)
,`staffDoB` date
,`roleID` varchar(10)
,`accountID` varchar(15)
,`staffPic` varchar(250)
,`roleName` varchar(40)
,`department` varchar(40)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view4`
-- (See below for the actual view)
--
CREATE TABLE `view4` (
`medID` varchar(15)
,`medName` varchar(100)
,`brand` varchar(100)
,`medType` varchar(40)
,`priceperdose` int(11)
,`gramperdose` int(11)
,`amountdose` int(11)
,`cabinetID` varchar(15)
,`medPic` varchar(255)
,`annotation` longtext
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view5`
-- (See below for the actual view)
--
CREATE TABLE `view5` (
`patientID` varchar(15)
,`patientTitle` varchar(5)
,`patientFN` varchar(40)
,`patientLN` varchar(40)
,`patientIdenID` varchar(13)
,`patientTel` varchar(10)
,`patientAge` int(5)
,`patientGender` varchar(10)
,`patientDoB` date
,`patientPic` varchar(250)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view6`
-- (See below for the actual view)
--
CREATE TABLE `view6` (
`staffID` varchar(15)
,`staffTitle` varchar(5)
,`staffFN` varchar(40)
,`staffLN` varchar(40)
,`staffIdenID` varchar(13)
,`staffTel` varchar(10)
,`staffAge` int(5)
,`staffGender` varchar(10)
,`staffDoB` date
,`roleID` varchar(10)
,`accountID` varchar(15)
,`staffPic` varchar(250)
,`roleName` varchar(40)
,`department` varchar(40)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view7`
-- (See below for the actual view)
--
CREATE TABLE `view7` (
);

-- --------------------------------------------------------

--
-- Structure for view `view1`
--
DROP TABLE IF EXISTS `view1`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view1`  AS  select `Staff`.`staffID` AS `staffID`,`Staff`.`staffTitle` AS `staffTitle`,`Staff`.`staffFN` AS `staffFN`,`Staff`.`staffLN` AS `staffLN`,`Staff`.`staffIdenID` AS `staffIdenID`,`Staff`.`staffTel` AS `staffTel`,`Staff`.`staffAge` AS `staffAge`,`Staff`.`staffGender` AS `staffGender`,`Staff`.`staffDoB` AS `staffDoB`,`Staff`.`roleID` AS `roleID`,`Staff`.`accountID` AS `accountID`,`Staff`.`staffPic` AS `staffPic`,`StaffRole`.`roleName` AS `roleName`,`StaffRole`.`department` AS `department` from (`Staff` join `StaffRole` on(`Staff`.`roleID` = `StaffRole`.`roleID`)) ;

-- --------------------------------------------------------

--
-- Structure for view `view2`
--
DROP TABLE IF EXISTS `view2`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view2`  AS  select `view1`.`staffID` AS `staffID`,`view1`.`staffTitle` AS `staffTitle`,`view1`.`staffFN` AS `staffFN`,`view1`.`staffLN` AS `staffLN`,`view1`.`staffIdenID` AS `staffIdenID`,`view1`.`staffTel` AS `staffTel`,`view1`.`staffAge` AS `staffAge`,`view1`.`staffGender` AS `staffGender`,`view1`.`staffDoB` AS `staffDoB`,`view1`.`roleID` AS `roleID`,`view1`.`accountID` AS `accountID`,`view1`.`staffPic` AS `staffPic`,`view1`.`roleName` AS `roleName`,`view1`.`department` AS `department` from `view1` where `view1`.`staffID` like '%%' ;

-- --------------------------------------------------------

--
-- Structure for view `view3`
--
DROP TABLE IF EXISTS `view3`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view3`  AS  select `view2`.`staffID` AS `staffID`,`view2`.`staffTitle` AS `staffTitle`,`view2`.`staffFN` AS `staffFN`,`view2`.`staffLN` AS `staffLN`,`view2`.`staffIdenID` AS `staffIdenID`,`view2`.`staffTel` AS `staffTel`,`view2`.`staffAge` AS `staffAge`,`view2`.`staffGender` AS `staffGender`,`view2`.`staffDoB` AS `staffDoB`,`view2`.`roleID` AS `roleID`,`view2`.`accountID` AS `accountID`,`view2`.`staffPic` AS `staffPic`,`view2`.`roleName` AS `roleName`,`view2`.`department` AS `department` from `view2` where `view2`.`staffFN` like '%%' or `view2`.`staffLN` like '%%' ;

-- --------------------------------------------------------

--
-- Structure for view `view4`
--
DROP TABLE IF EXISTS `view4`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view4`  AS  select `Medicine`.`medID` AS `medID`,`Medicine`.`medName` AS `medName`,`Medicine`.`brand` AS `brand`,`Medicine`.`medType` AS `medType`,`Medicine`.`priceperdose` AS `priceperdose`,`Medicine`.`gramperdose` AS `gramperdose`,`Medicine`.`amountdose` AS `amountdose`,`Medicine`.`cabinetID` AS `cabinetID`,`Medicine`.`medPic` AS `medPic`,`Medicine`.`annotation` AS `annotation` from `Medicine` ;

-- --------------------------------------------------------

--
-- Structure for view `view5`
--
DROP TABLE IF EXISTS `view5`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view5`  AS  select `Patient`.`patientID` AS `patientID`,`Patient`.`patientTitle` AS `patientTitle`,`Patient`.`patientFN` AS `patientFN`,`Patient`.`patientLN` AS `patientLN`,`Patient`.`patientIdenID` AS `patientIdenID`,`Patient`.`patientTel` AS `patientTel`,`Patient`.`patientAge` AS `patientAge`,`Patient`.`patientGender` AS `patientGender`,`Patient`.`patientDoB` AS `patientDoB`,`Patient`.`patientPic` AS `patientPic` from `Patient` ;

-- --------------------------------------------------------

--
-- Structure for view `view6`
--
DROP TABLE IF EXISTS `view6`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view6`  AS  select `Staff`.`staffID` AS `staffID`,`Staff`.`staffTitle` AS `staffTitle`,`Staff`.`staffFN` AS `staffFN`,`Staff`.`staffLN` AS `staffLN`,`Staff`.`staffIdenID` AS `staffIdenID`,`Staff`.`staffTel` AS `staffTel`,`Staff`.`staffAge` AS `staffAge`,`Staff`.`staffGender` AS `staffGender`,`Staff`.`staffDoB` AS `staffDoB`,`Staff`.`roleID` AS `roleID`,`Staff`.`accountID` AS `accountID`,`Staff`.`staffPic` AS `staffPic`,`StaffRole`.`roleName` AS `roleName`,`StaffRole`.`department` AS `department` from (`Staff` join `StaffRole` on(`Staff`.`roleID` = `StaffRole`.`roleID`)) ;

-- --------------------------------------------------------

--
-- Structure for view `view7`
--
DROP TABLE IF EXISTS `view7`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view7`  AS  select `view5`.`patientID` AS `patientID`,`view5`.`patientTitle` AS `patientTitle`,`view5`.`patientFN` AS `patientFN`,`view5`.`patientLN` AS `patientLN`,`view5`.`patientIdenID` AS `patientIdenID`,`view5`.`patientTel` AS `patientTel`,`view5`.`patientAge` AS `patientAge`,`view5`.`patientGender` AS `patientGender`,`view5`.`patientDoB` AS `patientDoB`,`view5`.`patientPic` AS `patientPic`,`view6`.`LastVisited` AS `LastVisited` from (`view5` left join `view6` on(`view5`.`patientID` = `view6`.`patientID`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Account`
--
ALTER TABLE `Account`
  ADD PRIMARY KEY (`accountID`);

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
  ADD KEY `staffID` (`staffID`),
  ADD KEY `patientID` (`patientID`);

--
-- Indexes for table `Prescription`
--
ALTER TABLE `Prescription`
  ADD PRIMARY KEY (`prescriptionID`),
  ADD KEY `medID` (`medID`),
  ADD KEY `caseID` (`caseID`);

--
-- Indexes for table `Staff`
--
ALTER TABLE `Staff`
  ADD PRIMARY KEY (`staffID`),
  ADD KEY `accountID` (`accountID`),
  ADD KEY `roleID` (`roleID`);

--
-- Indexes for table `StaffRole`
--
ALTER TABLE `StaffRole`
  ADD PRIMARY KEY (`roleID`);

--
-- Indexes for table `Stocking`
--
ALTER TABLE `Stocking`
  ADD PRIMARY KEY (`stockID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `PatientCase`
--
ALTER TABLE `PatientCase`
  ADD CONSTRAINT `diseaseID` FOREIGN KEY (`diseaseID`) REFERENCES `Disease` (`diseaseID`),
  ADD CONSTRAINT `patientID` FOREIGN KEY (`patientID`) REFERENCES `Patient` (`patientID`) ON DELETE CASCADE,
  ADD CONSTRAINT `staffID` FOREIGN KEY (`staffID`) REFERENCES `Staff` (`staffID`) ON DELETE SET NULL;

--
-- Constraints for table `Prescription`
--
ALTER TABLE `Prescription`
  ADD CONSTRAINT `caseID` FOREIGN KEY (`caseID`) REFERENCES `PatientCase` (`caseID`) ON DELETE CASCADE,
  ADD CONSTRAINT `medID` FOREIGN KEY (`medID`) REFERENCES `Medicine` (`medID`);

--
-- Constraints for table `Staff`
--
ALTER TABLE `Staff`
  ADD CONSTRAINT `accountID` FOREIGN KEY (`accountID`) REFERENCES `Account` (`accountID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `roleID` FOREIGN KEY (`roleID`) REFERENCES `StaffRole` (`roleID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
