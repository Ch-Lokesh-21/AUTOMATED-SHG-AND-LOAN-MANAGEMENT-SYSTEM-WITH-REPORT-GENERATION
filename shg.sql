-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2024 at 06:21 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shg`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `password`) VALUES
('umL2F+s=', 'ukLWN8s+LJoK1g==');

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `BrCode` int(11) NOT NULL,
  `BrName` varchar(1000) NOT NULL,
  `ifsc` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`BrCode`, `BrName`, `ifsc`) VALUES
(6, 'Tirupati', 'umL3FJlOLZgI0s4='),
(26, 'Governorpet', 'umL3FJlOLZgI0M4='),
(61, 'Brundavan Gardens', 'umL3FJlOLZgJ0ss='),
(62, 'Gannavaram', 'umL3FJlOLZgJ0sw='),
(63, 'KR Market', 'umL3FJlOLZgJ0s4='),
(64, 'Ramavarappadu', 'umL3FJlOLZgJ0s8='),
(65, 'Gollapudi', 'umL3FJlOLZgJ0s0='),
(66, 'Venugopala Nagar', 'umL3FJlOLZgJ0sA='),
(67, 'Rayapudi', 'umL3FJlOLZgJ0sE='),
(68, 'Kanuru', 'umL3FJlOLZgJ08g='),
(69, 'Currency Nagar', 'umL3FJlOLZgJ08k='),
(70, 'Mangalagiri', 'umL3FJlOLZgJ08o='),
(71, 'Moghalrajapuram', 'umL3FJlOLZgJ08s='),
(72, 'Chenchupeta', 'umL3FJlOLZgJ08w='),
(73, 'AT Agraharam', 'umL3FJlOLZgJ080='),
(74, 'Hanuman Junction', 'umL3FJlOLZgJ084='),
(75, 'Challapalli', 'umL3FJlOLZgJ088=');

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE `loan` (
  `accNo` bigint(20) NOT NULL,
  `loo` varchar(1000) NOT NULL,
  `date` date NOT NULL,
  `lc` varchar(3) NOT NULL,
  `CIF` bigint(20) NOT NULL,
  `purpose` varchar(1000) NOT NULL,
  `accSt` varchar(3) NOT NULL,
  `adate` date DEFAULT NULL,
  `sdate` date DEFAULT NULL,
  `odate` date NOT NULL,
  `cdate` date DEFAULT NULL,
  `amtSanc` bigint(20) NOT NULL,
  `Tamt` bigint(20) NOT NULL,
  `noi` bigint(20) NOT NULL,
  `repFrq` varchar(3) NOT NULL,
  `minAmtDue` bigint(20) NOT NULL,
  `curBal` bigint(20) NOT NULL,
  `amtOvr` bigint(20) NOT NULL,
  `dpd` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loan`
--

INSERT INTO `loan` (`accNo`, `loo`, `date`, `lc`, `CIF`, `purpose`, `accSt`, `adate`, `sdate`, `odate`, `cdate`, `amtSanc`, `Tamt`, `noi`, `repFrq`, `minAmtDue`, `curBal`, `amtOvr`, `dpd`) VALUES
(110001058774, 'Branch manager', '2024-06-30', 'T04', 410000217559, 'Loans to SHG members', 'S04', '0000-00-00', '0000-00-00', '2023-07-28', '0000-00-00', 1980000, 1980000, 0, 'F07', 0, 1576460, 0, 0),
(110001155280, 'Branch manager', '2024-06-30', 'T04', 410000234799, 'Loans to SHG members', 'S04', '0000-00-00', '0000-00-00', '2023-10-05', '0000-00-00', 768000, 768000, 0, 'F07', 0, 595249, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `memberdetails`
--

CREATE TABLE `memberdetails` (
  `mcif` bigint(20) NOT NULL,
  `CIF` bigint(20) NOT NULL,
  `name` varchar(1000) NOT NULL,
  `dob` date NOT NULL,
  `age` int(11) NOT NULL,
  `gender` varchar(1) NOT NULL,
  `marital` varchar(3) NOT NULL,
  `kpn` varchar(1000) NOT NULL,
  `kpr` varchar(3) NOT NULL,
  `nname` varchar(1000) DEFAULT NULL,
  `nrel` varchar(3) DEFAULT NULL,
  `nage` int(11) DEFAULT NULL,
  `vid` varchar(1000) DEFAULT NULL,
  `uid` varchar(1000) NOT NULL,
  `pan` varchar(1000) DEFAULT NULL,
  `ration` varchar(1000) DEFAULT NULL,
  `telind` varchar(3) DEFAULT NULL,
  `telphn` bigint(20) DEFAULT NULL,
  `accBankName` varchar(1000) DEFAULT NULL,
  `accBranchName` varchar(1000) DEFAULT NULL,
  `accAccNo` varchar(1000) DEFAULT NULL,
  `occ` varchar(1000) DEFAULT NULL,
  `mincome` bigint(20) NOT NULL,
  `mexp` bigint(20) NOT NULL,
  `caste` varchar(1000) DEFAULT NULL,
  `gli` varchar(1) DEFAULT NULL,
  `padd` longtext NOT NULL,
  `psc` varchar(1000) NOT NULL,
  `ppc` int(11) NOT NULL,
  `cadd` longtext NOT NULL,
  `csc` varchar(1000) NOT NULL,
  `cpc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `memberdetails`
--

INSERT INTO `memberdetails` (`mcif`, `CIF`, `name`, `dob`, `age`, `gender`, `marital`, `kpn`, `kpr`, `nname`, `nrel`, `nage`, `vid`, `uid`, `pan`, `ration`, `telind`, `telphn`, `accBankName`, `accBranchName`, `accAccNo`, `occ`, `mincome`, `mexp`, `caste`, `gli`, `padd`, `psc`, `ppc`, `cadd`, `csc`, `cpc`) VALUES
(250490921153, 410000234799, 'BANDIKALLAYESUMMA', '2003-07-10', 21, 'F', 'M05', 'YARRAMALARATNAKUMARI', 'K15', '', '', 0, '', '250490921153', '', '', '', 0, '', '', '', '', 15000, 8000, '', '', '6-76/1-RAYAPUDI', 'AP', 522237, '6-76/1-RAYAPUDI', 'AP', 522237),
(410000216453, 410000217559, 'PEMMADI AADILAKSHMI', '1996-03-26', 28, 'F', 'M01', 'DARMADIBABY', 'K15', '', '', 0, '', '784839371442', '', '', '', 0, '', '', '', '', 20000, 10000, '', '', '6-131-RAYAPUDI', 'AP', 522237, '6-131-RAYAPUDI', 'AP', 522237),
(410000216623, 410000217559, 'PANTHADI NAGAMANI', '1995-01-01', 29, 'F', 'M01', 'DARMADIBABY', 'K15', '', '', 0, '', '545586102202', '', '', '', 0, '', '', '', '', 20000, 10000, '', '', '8-113/2-RAYAPUDI', 'AP', 522237, '8-113/2-RAYAPUDI', 'AP', 522237),
(410000216645, 410000217559, 'RACHA VENKATALAKSHMI', '1994-01-01', 30, 'F', 'M01', 'DARMADIBABY', 'K15', '', '', 0, '', '542964870533', '', '', '', 0, '', '', '', '', 20000, 10000, '', '', '6-119-RAYAPUDI', 'AP', 522237, '6-119-RAYAPUDI', 'AP', 522237),
(410000216667, 410000217559, 'PANTADI VARALAKSHMI', '1994-01-01', 30, 'F', 'M01', 'DARMADIBABY', 'K15', '', '', 0, '', '332064767647', '', '', '', 0, '', '', '', '', 20000, 10000, '', '', '6-135-RAYAPUDI', 'AP', 522237, '6-135-RAYAPUDI', 'AP', 522237),
(410000216678, 410000217559, 'PANTHADI BHU LAKSHMI', '1998-01-01', 26, 'F', 'M01', 'DARMADIBABY', 'K15', '', '', 0, '', '224961381879', '', '', '', 0, '', '', '', '', 20000, 10000, '', '', '6-135-RAYAPUDI', 'AP', 522237, '6-135-RAYAPUDI', 'AP', 522237),
(410000216689, 410000217559, 'PINAPOTHU DEVI', '1991-01-01', 33, 'F', 'M01', 'DARMADIBABY', 'K15', '', '', 0, '', '997041224088', '', '', '', 0, '', '', '', '', 20000, 10000, '', '', '6-119-RAYAPUDI', 'AP', 522237, '6-119-RAYAPUDI', 'AP', 522237),
(410000216714, 410000217559, 'RACHHA KUMARI', '1991-01-01', 33, 'F', 'M01', 'DARMADIBABY', 'K15', '', '', 0, '', '705694912817', '', '', '', 0, '', '', '', '', 20000, 10000, '', '', '6-119/1-RAYAPUDI', 'AP', 522237, '6-119/1-RAYAPUDI', 'AP', 522237),
(410000216781, 410000217559, 'RACHA RAMA TULASI', '1991-01-01', 33, 'F', 'M01', 'DARMADIBABY', 'K15', '', '', 0, '', '362519568094', '', '', '', 0, '', '', '', '', 20000, 10000, '', '', '6-119-RAYAPUDI', 'AP', 522237, '6-119-RAYAPUDI', 'AP', 522237),
(410000216792, 410000217559, 'DHARMADI SURYAKUMARI', '1992-01-01', 32, 'F', 'M01', 'DARMADIBABY', 'K15', '', '', 0, '', '866061254245', '', '', '', 0, '', '', '', '', 20000, 10000, '', '', '14-24-RAYAPUDI', 'AP', 522237, '14-24-RAYAPUDI', 'AP', 522237),
(410000216805, 410000217559, 'PAMTHADI DURGA', '1992-01-01', 32, 'F', 'M01', 'DARMADIBABY', 'K15', '', '', 0, '', '454358944444', '', '', '', 0, '', '', '', '', 20000, 10000, '', '', '6-135-RAYAPUDI', 'AP', 522237, '6-135-RAYAPUDI', 'AP', 522237),
(410000218825, 410000217559, 'DARMADI BABY', '1996-01-01', 28, 'F', 'M01', 'DARMADIBABY', 'K15', '', '', 0, '', '266129021800', '', '', '', 0, '', '', '', '', 20000, 10000, '', '', '6-123-RAYAPUDI', 'AP', 522237, '6-123-RAYAPUDI', 'AP', 522237),
(410000231380, 410000234799, 'RENTAPALLI PRIYANKA', '1991-04-17', 33, 'F', 'M01', 'YARRAMALARATNAKUMARI', 'K15', '', '', 0, '', '938376175759', '', '', '', 0, '', '', '', '', 15000, 8000, '', '', '01--19-RAYAPUDI', 'AP', 522237, '01--19-RAYAPUDI', 'AP', 522237),
(410000231391, 410000234799, 'SARIGALA NAGALAKSHMI', '1992-10-12', 31, 'F', 'M01', 'YARRAMALARATNAKUMARI', 'K15', '', '', 0, '', '445920142574', '', '', '', 0, '', '', '', '', 15000, 8000, '', '', '1-35-RAYAPUDI', 'AP', 522237, '1-35-RAYAPUDI', 'AP', 522237),
(410000231404, 410000234799, 'SARIGALA ANUSHA 2', '1993-11-08', 30, 'F', 'M01', 'YARRAMALARATNAKUMARI', 'K15', '', '', 0, '', '363456073729', '', '', '', 0, '', '', '', '', 15000, 8000, '', '', '1-39-1-RAYAPUDI', 'AP', 522237, '1-39-1-RAYAPUDI', 'AP', 522237),
(410000231415, 410000234799, 'DAARLA RANI', '1989-01-01', 35, 'F', 'M01', 'YARRAMALARATNAKUMARI', 'K15', '', '', 0, '', '490417745849', '', '', '', 0, '', '', '', '', 15000, 8000, '', '', '310/1-RAYAPUDI', 'AP', 522237, '310/1-RAYAPUDI', 'AP', 522237),
(410000231426, 410000234799, 'SARIGALA VENKATARATHANAM', '1971-01-01', 53, 'F', 'M01', 'YARRAMALARATNAKUMARI', 'K15', '', '', 0, '', '808577994997', '', '', '', 0, '', '', '', '', 15000, 8000, '', '', '01--35-RAYAPUDI', 'AP', 522237, '01--35-RAYAPUDI', 'AP', 522237),
(410000231437, 410000234799, 'JONNAKUTI SIRISHA', '1997-03-21', 27, 'F', 'M01', 'YARRAMALARATNAKUMARI', 'K15', '', '', 0, '', '703926454858', '', '', '', 0, '', '', '', '', 15000, 8000, '', '', '7-14/112-RAYAPUDI', 'AP', 522237, '7-14/112-RAYAPUDI', 'AP', 522237),
(410000231448, 410000234799, 'VELAGALETI MARIYAMMA', '1984-01-01', 40, 'F', 'M01', 'YARRAMALARATNAKUMARI', 'K15', '', '', 0, '', '235005975981', '', '', '', 0, '', '', '', '', 15000, 8000, '', '', '1-6-RAYAPUDI', 'AP', 522237, '1-6-RAYAPUDI', 'AP', 522237),
(410000231459, 410000234799, 'SARIGALA AHALYA', '1996-08-09', 28, 'F', 'M01', 'YARRAMALARATNAKUMARI', 'K15', '', '', 0, '', '919855712800', '', '', '', 0, '', '', '', '', 15000, 8000, '', '', '6-86-RAYAPUDI', 'AP', 522237, '6-86-RAYAPUDI', 'AP', 522237),
(810006160428, 410000234799, 'YARRAMALA RATNAKUMARI', '1993-01-01', 31, 'F', 'M01', 'YARRAMALARATNAKUMARI', 'K15', '', '', 0, '', '250400548192', '', '', '', 0, '', '', '', '', 15000, 8000, '', '', '1-26-RAYAPUDI', 'AP', 522237, '1-26-RAYAPUDI', 'AP', 522237),
(810006220219, 410000234799, 'RENTAPALLI MANIKYAM', '1973-01-01', 51, 'F', 'M01', 'YARRAMALARATNAKUMARI', 'K15', '', '', 0, '', '798400630302', '', '', '', 0, '', '', '', '', 15000, 8000, '', '', '01--19-RAYAPUDI', 'AP', 522237, '01--19-RAYAPUDI', 'AP', 522237),
(810006290594, 410000234799, 'SARIGALA NAVANEETHAM', '1976-01-01', 48, 'F', 'M01', 'YARRAMALARATNAKUMARI', 'K15', '', '', 0, '', '633969624817', '', '', '', 0, '', '', '', '', 15000, 8000, '', '', '6-86-RAYAPUDI', 'AP', 522237, '6-86-RAYAPUDI', 'AP', 522237);

-- --------------------------------------------------------

--
-- Table structure for table `shgdetails`
--

CREATE TABLE `shgdetails` (
  `BrCode` int(11) NOT NULL,
  `CIF` bigint(20) NOT NULL,
  `SHGName` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `shgdetails`
--

INSERT INTO `shgdetails` (`BrCode`, `CIF`, `SHGName`) VALUES
(65, 123456, 'umHxHu42'),
(67, 410000217559, 'tlPdMcQfUMlRi5SpOJOR'),
(67, 410000234799, 'ukLaN9sIfOVYipGkCoieGw==');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ifsc` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ifsc`, `password`) VALUES
('umL3FJlOLZgI0M4=', 'yQQ='),
('umL3FJlOLZgI0s4=', 'zQ=='),
('umL3FJlOLZgJ080=', 'zAE='),
('umL3FJlOLZgJ084=', 'zAY='),
('umL3FJlOLZgJ088=', 'zAc='),
('umL3FJlOLZgJ08g=', 'zQo='),
('umL3FJlOLZgJ08k=', 'zQs='),
('umL3FJlOLZgJ08o=', 'zAI='),
('umL3FJlOLZgJ08s=', 'zAM='),
('umL3FJlOLZgJ08w=', 'zAA='),
('umL3FJlOLZgJ0s0=', 'zQc='),
('umL3FJlOLZgJ0s4=', 'zQE='),
('umL3FJlOLZgJ0s8=', 'zQY='),
('umL3FJlOLZgJ0sA=', 'zQQ='),
('umL3FJlOLZgJ0sE=', 'zQU='),
('umL3FJlOLZgJ0ss=', 'zQM='),
('umL3FJlOLZgJ0sw=', 'zQA=');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`BrCode`);

--
-- Indexes for table `loan`
--
ALTER TABLE `loan`
  ADD PRIMARY KEY (`CIF`);

--
-- Indexes for table `memberdetails`
--
ALTER TABLE `memberdetails`
  ADD PRIMARY KEY (`mcif`),
  ADD KEY `fk_for_mem` (`CIF`);

--
-- Indexes for table `shgdetails`
--
ALTER TABLE `shgdetails`
  ADD PRIMARY KEY (`CIF`),
  ADD KEY `fk_codes` (`BrCode`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ifsc`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `loan`
--
ALTER TABLE `loan`
  ADD CONSTRAINT `lk_fk_constraint_name` FOREIGN KEY (`CIF`) REFERENCES `shgdetails` (`CIF`);

--
-- Constraints for table `memberdetails`
--
ALTER TABLE `memberdetails`
  ADD CONSTRAINT `fk_for_mem` FOREIGN KEY (`CIF`) REFERENCES `shgdetails` (`CIF`);

--
-- Constraints for table `shgdetails`
--
ALTER TABLE `shgdetails`
  ADD CONSTRAINT `fk_codes` FOREIGN KEY (`BrCode`) REFERENCES `branches` (`BrCode`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
