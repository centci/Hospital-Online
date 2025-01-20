-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 21, 2025 at 12:19 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `HospitalOnline`
--

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `id` int(11) NOT NULL,
  `bill_to` varchar(255) NOT NULL,
  `userId` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cashierSaveds`
--

CREATE TABLE `cashierSaveds` (
  `id` int(255) NOT NULL,
  `cashierSavedReceiptNo` varchar(255) NOT NULL,
  `cashierSavedPendingPayId` varchar(255) NOT NULL,
  `cashierSavedTestCode` varchar(255) NOT NULL,
  `cashierSavedBy` varchar(255) NOT NULL,
  `cashierSavedStatus` varchar(20) NOT NULL DEFAULT 'not saved',
  `cashierSavedDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cashierSaveds`
--

INSERT INTO `cashierSaveds` (`id`, `cashierSavedReceiptNo`, `cashierSavedPendingPayId`, `cashierSavedTestCode`, `cashierSavedBy`, `cashierSavedStatus`, `cashierSavedDate`) VALUES
(1, '21578118202', '9658373555', 'LAB0002', '1', 'saved', '2024-11-20 15:39:51'),
(2, '21578118202', '9658373555', 'LAB0003', '1', 'saved', '2024-11-20 15:39:51'),
(3, '0846020053', '3924373457', 'LAB0001', '1', 'saved', '2025-01-02 22:26:03'),
(4, '0846020053', '3924373457', 'LAB0003', '1', 'saved', '2025-01-02 22:26:03'),
(5, '7996049986', '6429499345', 'LAB0001', '1', 'saved', '2025-01-02 23:52:18'),
(6, '7996049986', '6429499345', 'LAB0002', '1', 'saved', '2025-01-02 23:52:18'),
(7, '7996049986', '6429499345', 'LAB0003', '1', 'saved', '2025-01-02 23:52:18'),
(8, '3450744905', '2954080778', 'LAB0002', '1', 'saved', '2025-01-03 00:30:18'),
(9, '3450744905', '2954080778', 'LAB0003', '1', 'saved', '2025-01-03 00:30:18'),
(10, '3450744905', '2954080778', 'LAB0001', '1', 'saved', '2025-01-03 00:30:18');

-- --------------------------------------------------------

--
-- Table structure for table `containers`
--

CREATE TABLE `containers` (
  `id` int(11) NOT NULL,
  `containerId` varchar(100) NOT NULL,
  `containername` varchar(255) NOT NULL,
  `containerUserId` varchar(100) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `containers`
--

INSERT INTO `containers` (`id`, `containerId`, `containername`, `containerUserId`, `date`) VALUES
(1, 'CON-001', 'Red Topd', 'USR-0001', '2020-11-17 00:02:09'),
(2, 'CON-002', 'Purple Top', 'USR-0002', '2020-11-17 00:03:21'),
(3, 'CON-003', 'Urine Container', 'USR-0003', '2020-11-17 00:03:35'),
(4, 'CON-004', 'blue top', 'USR-0001', '2022-09-08 00:06:57'),
(5, 'CON-005', 'sputum mug', 'USR-0001', '2022-09-16 18:26:36'),
(8, 'CON-006', 'cup', 'USR-0001', '2025-01-15 23:39:30');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `deptId` varchar(100) NOT NULL,
  `department` varchar(255) NOT NULL,
  `deptUserId` varchar(100) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `deptId`, `department`, `deptUserId`, `date`) VALUES
(2, 'DEP-001', 'pharmacy', 'USR-0001', '2022-10-31 22:27:46'),
(3, 'DEP-002', 'laboratory', 'USR-0001', '2022-11-23 10:09:24'),
(4, 'DEP-003', 'opd', 'USR-0001', '2022-11-23 10:16:27'),
(5, 'DEP-004', 'account', 'USR-0001', '2022-11-23 10:16:35'),
(6, 'DEP-005', 'radiology', 'USR-0001', '2022-11-23 10:16:50'),
(7, 'DEP-006', 'paediatric', 'USR-0001', '2023-02-21 18:49:58'),
(10, 'DEP-007', 'medical', 'USR-0001', '2023-02-21 18:58:27'),
(11, 'DEP-008', 'general ward 2', 'USR-0001', '2025-01-05 00:21:55'),
(12, 'DEP-009', 'general ward', 'USR-0001', '2025-01-05 23:20:40'),
(13, 'DEP-010', 'private 3', 'USR-0001', '2025-01-05 23:34:46'),
(14, 'DEP-011', 'private 4', 'USR-0001', '2025-01-15 13:52:09');

-- --------------------------------------------------------

--
-- Table structure for table `extratests`
--

CREATE TABLE `extratests` (
  `id` int(11) NOT NULL,
  `xtraTestCode` varchar(100) DEFAULT NULL,
  `subTestCode` varchar(100) NOT NULL,
  `xtraTestName` varchar(100) DEFAULT NULL,
  `xtraRefRanges` varchar(100) DEFAULT NULL,
  `xtraUnitid` varchar(100) DEFAULT NULL,
  `xtraUserId` varchar(100) DEFAULT NULL,
  `xtraTestDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `extratests`
--

INSERT INTO `extratests` (`id`, `xtraTestCode`, `subTestCode`, `xtraTestName`, `xtraRefRanges`, `xtraUnitid`, `xtraUserId`, `xtraTestDate`) VALUES
(1, 'LAB0001', 'LAB0001-1', 'cbc', '4-11', 'UNI-004', '1', '2024-03-15 21:48:54'),
(2, 'LAB0001', 'LAB0001-2', 'LYM', '10-100', 'UNI-007', '1', '2024-03-15 21:48:54'),
(3, 'LAB0001', 'LAB0001-3', 'RBC', '2-6', 'UNI-003', '1', '2024-03-15 21:48:54'),
(4, 'LAB0001', 'LAB0001-4', 'HB', '7-16', 'UNI-005', '1', '2024-03-15 21:48:54'),
(5, 'LAB0002', 'LAB0002-1', 'UREA', '10-100', 'UNI-007', '1', '2024-03-15 22:52:20'),
(6, 'LAB0002', 'LAB0002-2', 'CREATININE', '4-190', 'UNI-007', '1', '2024-03-15 22:52:20'),
(15, 'LAB0006', 'LAB0006-1', 'ALP', '1-9', 'UNI-003', 'USR-0001', '2025-01-19 11:41:51'),
(16, 'LAB0006', 'LAB0006-2', 'ALB', '3-8', 'UNI-003', 'USR-0001', '2025-01-19 11:41:51');

-- --------------------------------------------------------

--
-- Table structure for table `insurances`
--

CREATE TABLE `insurances` (
  `id` int(11) NOT NULL,
  `insuranceId` varchar(100) NOT NULL,
  `insuranceName` varchar(255) NOT NULL,
  `insuranceUserId` varchar(100) NOT NULL,
  `disabled` int(11) NOT NULL DEFAULT 0,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `insurances`
--

INSERT INTO `insurances` (`id`, `insuranceId`, `insuranceName`, `insuranceUserId`, `disabled`, `date`) VALUES
(2, 'INS-001', 'uap', 'USR-0001', 0, '2022-11-25 20:09:38'),
(3, 'INS-002', 'aar', 'USR-0001', 0, '2022-11-25 20:16:49'),
(4, 'INS-003', 'jubilee', 'USR-0001', 0, '2022-11-25 20:17:12'),
(5, 'INS-004', 'case care', 'USR-0001', 0, '2022-11-25 20:19:15'),
(6, 'INS-005', 'cash customer', 'USR-0001', 0, '2022-11-25 21:31:12'),
(7, 'INS-006', 'araf', 'USR-0001', 0, '2023-02-21 20:11:02'),
(8, 'INS-007', 'abiw', 'USR-0001', 0, '2023-02-21 20:11:28'),
(9, 'INS-008', 'Virika Hospital', 'USR-0001', 0, '2025-01-09 12:30:05');

-- --------------------------------------------------------

--
-- Table structure for table `labextratestreports`
--

CREATE TABLE `labextratestreports` (
  `id` int(11) NOT NULL,
  `extraTestReportId` bigint(100) NOT NULL,
  `extraTestReportSampId` bigint(100) NOT NULL,
  `extratestResults` varchar(250) NOT NULL,
  `extraTestReportTestCode` varchar(255) NOT NULL,
  `extraTestReportSubTestCode` varchar(255) NOT NULL,
  `extraTestReportBy` int(100) NOT NULL,
  `extraTestReportDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `labextratestreports`
--

INSERT INTO `labextratestreports` (`id`, `extraTestReportId`, `extraTestReportSampId`, `extratestResults`, `extraTestReportTestCode`, `extraTestReportSubTestCode`, `extraTestReportBy`, `extraTestReportDate`) VALUES
(1, 1810767439, 6483505577, '45', 'LAB0002', 'LAB0002-1', 1, '2024-12-04 18:09:05'),
(2, 1810767439, 6483505577, '78', 'LAB0002', 'LAB0002-2', 1, '2024-12-04 18:09:05'),
(3, 7270269886, 7439771708, '13.4', 'LAB0001', 'LAB0001-3', 1, '2025-01-03 00:02:47'),
(4, 7270269886, 7439771708, '7.8', 'LAB0001', 'LAB0001-1', 1, '2025-01-03 00:02:47'),
(5, 7270269886, 7439771708, '15.0', 'LAB0001', 'LAB0001-4', 1, '2025-01-03 00:02:47'),
(6, 7270269886, 7439771708, '5.1', 'LAB0001', 'LAB0001-2', 1, '2025-01-03 00:02:47'),
(7, 2909761585, 6528975520, '4.7', 'LAB0001', 'LAB0001-3', 1, '2025-01-03 00:11:03'),
(8, 2909761585, 6528975520, '5.8', 'LAB0001', 'LAB0001-1', 1, '2025-01-03 00:11:03'),
(9, 2909761585, 6528975520, '12.1', 'LAB0001', 'LAB0001-4', 1, '2025-01-03 00:11:03'),
(10, 2909761585, 6528975520, '0.7', 'LAB0001', 'LAB0001-2', 1, '2025-01-03 00:11:03'),
(11, 7764721954, 6528975520, '45', 'LAB0002', 'LAB0002-1', 1, '2025-01-03 00:12:00'),
(12, 7764721954, 6528975520, '78', 'LAB0002', 'LAB0002-2', 1, '2025-01-03 00:12:00'),
(13, 4702214590, 171910441, '23', 'LAB0002', 'LAB0002-1', 1, '2025-01-03 00:36:24'),
(14, 4702214590, 171910441, '34', 'LAB0002', 'LAB0002-2', 1, '2025-01-03 00:36:24'),
(15, 5840171565, 171910441, '6.0', 'LAB0001', 'LAB0001-3', 1, '2025-01-03 00:36:59'),
(16, 5840171565, 171910441, '5.8', 'LAB0001', 'LAB0001-1', 1, '2025-01-03 00:36:59'),
(17, 5840171565, 171910441, '13.9', 'LAB0001', 'LAB0001-4', 1, '2025-01-03 00:36:59'),
(18, 5840171565, 171910441, '4.9', 'LAB0001', 'LAB0001-2', 1, '2025-01-03 00:36:59');

-- --------------------------------------------------------

--
-- Table structure for table `labReports`
--

CREATE TABLE `labReports` (
  `id` bigint(11) NOT NULL,
  `labReportId` varchar(100) NOT NULL,
  `testResult` text NOT NULL,
  `reportLabReqSampleId` bigint(100) NOT NULL,
  `reportTestCode` varchar(100) DEFAULT NULL,
  `reportUserId` int(20) NOT NULL,
  `reportDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `labReports`
--

INSERT INTO `labReports` (`id`, `labReportId`, `testResult`, `reportLabReqSampleId`, `reportTestCode`, `reportUserId`, `reportDate`) VALUES
(1, '7891852414', '++ Mps Seen', 6483505577, 'LAB0003', 1, '2024-12-04 18:08:30'),
(2, '2859014995', '+5 mp see', 7439771708, 'LAB0003', 1, '2025-01-03 00:08:02'),
(3, '7305971635', '+2 mps', 6528975520, 'LAB0003', 1, '2025-01-03 00:19:11'),
(4, '4390930310', '+1 mps seen', 171910441, 'LAB0003', 1, '2025-01-03 00:36:38');

-- --------------------------------------------------------

--
-- Table structure for table `labRequests`
--

CREATE TABLE `labRequests` (
  `id` int(11) NOT NULL,
  `labReqSampleId` varchar(255) NOT NULL,
  `labReqPatientId` varchar(255) NOT NULL,
  `labReqVisitId` bigint(100) NOT NULL,
  `labReqTestCode` varchar(20) NOT NULL,
  `LabReqCashierSavedReceiptNo` varchar(100) NOT NULL,
  `labReqStatus` varchar(13) NOT NULL DEFAULT 'NotReported',
  `labReqSavedByUserId` varchar(100) NOT NULL,
  `DrawnDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `labRequests`
--

INSERT INTO `labRequests` (`id`, `labReqSampleId`, `labReqPatientId`, `labReqVisitId`, `labReqTestCode`, `LabReqCashierSavedReceiptNo`, `labReqStatus`, `labReqSavedByUserId`, `DrawnDate`) VALUES
(1, '6483505577', '202300001', 1108487034, 'LAB0002', '21578118202', 'Reported', 'USR-0001', '2024-11-20 16:11:54'),
(2, '6483505577', '202300001', 1108487034, 'LAB0003', '21578118202', 'Reported', 'USR-0001', '2024-11-20 16:11:54'),
(5, '7439771708', '202200003', 6583197162, 'LAB0001', '0846020053', 'Reported', 'USR-0001', '2025-01-02 23:09:19'),
(6, '7439771708', '202200003', 6583197162, 'LAB0003', '0846020053', 'Reported', 'USR-0001', '2025-01-02 23:09:19'),
(21, '6528975520', '202200001', 1108487034, 'LAB0001', '7996049986', 'Reported', 'USR-0001', '2025-01-03 00:02:12'),
(22, '6528975520', '202200001', 1108487034, 'LAB0002', '7996049986', 'Reported', 'USR-0001', '2025-01-03 00:02:12'),
(23, '6528975520', '202200001', 1108487034, 'LAB0003', '7996049986', 'Reported', 'USR-0001', '2025-01-03 00:02:12'),
(24, '0171910441', '202300002', 1108487032, 'LAB0002', '3450744905', 'Reported', 'USR-0001', '2025-01-03 00:30:33'),
(25, '0171910441', '202300002', 1108487032, 'LAB0003', '3450744905', 'Reported', 'USR-0001', '2025-01-03 00:30:33'),
(26, '0171910441', '202300002', 1108487032, 'LAB0001', '3450744905', 'Reported', 'USR-0001', '2025-01-03 00:30:33');

-- --------------------------------------------------------

--
-- Table structure for table `labsections`
--

CREATE TABLE `labsections` (
  `id` int(11) NOT NULL,
  `labSectionId` varchar(100) NOT NULL,
  `labname` varchar(255) NOT NULL,
  `labSectionUserId` varchar(100) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `labsections`
--

INSERT INTO `labsections` (`id`, `labSectionId`, `labname`, `labSectionUserId`, `date`) VALUES
(4, 'LSC-001', 'Biochemistry', 'USR-0001', '2022-09-03 22:57:37'),
(5, 'LSC-002', 'Microbiology', 'USR-0001', '2022-09-03 22:59:10'),
(7, 'LSC-003', 'Histopathology', 'USR-0001', '2022-09-03 23:00:36'),
(8, 'LSC-004', 'Parasitology', 'USR-0001', '2022-10-13 20:04:47'),
(9, 'LSC-005', 'cyto', 'USR-0001', '2023-02-21 20:40:37'),
(10, 'LSC-006', 'Haematology', 'USR-0001', '2024-03-15 21:53:44'),
(11, 'LSC-007', 'blood Tans', 'USR-0001', '2025-01-09 13:18:26'),
(12, 'LSC-008', 'blood Tans u', 'USR-0001', '2025-01-15 23:21:44');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `patientId` varchar(255) NOT NULL,
  `title` varchar(100) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `middlename` varchar(30) DEFAULT NULL,
  `lastname` varchar(30) NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(7) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `nok` varchar(70) NOT NULL,
  `nokphone` varchar(15) DEFAULT NULL,
  `country` varchar(70) NOT NULL,
  `district` varchar(70) NOT NULL,
  `county` varchar(70) NOT NULL,
  `subcounty` varchar(70) NOT NULL,
  `village` varchar(70) NOT NULL,
  `userId` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `patientId`, `title`, `firstname`, `middlename`, `lastname`, `dob`, `gender`, `image`, `phone`, `nok`, `nokphone`, `country`, `district`, `county`, `subcounty`, `village`, `userId`, `date`) VALUES
(1, '202200001', 'mrs.', 'apio', 'jackline', 'ojera', '2003-11-09', 'female', NULL, '0782559683', 'auma eva', '0392589687', 'uganda', 'lira', 'erute', 'lira', 'angwet', 1, '2022-11-18 22:22:05'),
(2, '202200002', 'mr.', 'obong', 'john', 'ojenge', '2003-09-01', 'male', NULL, '0786456789', 'juli', '0258963147', 'zimbabwe', 'oniam', 'pana', 'pana', 'bipana', 1, '2022-11-18 22:45:26'),
(3, '202200003', 'mrs.', 'kiwanuka', 'john', 'brunu', '2023-01-17', 'male', NULL, '90', 'kwezi', '0786245789', 'uganda', 'masaka', 'kigo', 'karbiro', 'beyoyo', 1, '2023-01-29 13:13:54'),
(4, '202200004', 'ms.', 'jenifer', '', 'akidi', '1983-02-09', 'female', NULL, '345678900', 'abeja', '09876654', 'rwanda', 'bikai', 'obinua', 'bgweno', 'gatuna', 1, '2023-01-29 13:17:14'),
(5, '202300001', 'mrs.', 'mirembe', 'grace', 'mwebe', '2022-12-27', 'male', NULL, '7876544', 'jko', '9876543', 'uganda', 'gh', 'hy', 'asd', 'zxcv', 1, '2023-01-29 22:24:48'),
(6, '202300002', 'rev.', 'kabonge', '', 'james', '1989-12-20', 'male', NULL, '123456789', 'patrick', '1234567890', 'uganda', 'jinja', 'central division', 'city', 'fatima', 1, '2023-01-29 22:30:22');

-- --------------------------------------------------------

--
-- Table structure for table `pendingPayments`
--

CREATE TABLE `pendingPayments` (
  `id` int(11) NOT NULL,
  `pendingPayId` varchar(255) NOT NULL,
  `pendingPayVisitId` bigint(100) NOT NULL,
  `patientNo` varchar(255) NOT NULL,
  `itemCode` varchar(11) NOT NULL,
  `departmentId` int(11) NOT NULL,
  `sentBy` int(11) NOT NULL,
  `pymt_status` varchar(10) NOT NULL DEFAULT 'not paid',
  `pendingPayDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pendingPayments`
--

INSERT INTO `pendingPayments` (`id`, `pendingPayId`, `pendingPayVisitId`, `patientNo`, `itemCode`, `departmentId`, `sentBy`, `pymt_status`, `pendingPayDate`) VALUES
(1, '9658373555', 1108487034, '202200001', 'LAB0002', 2, 1, 'not paid', '2024-11-27 23:09:17'),
(2, '9658373555', 1108487034, '202200001', 'LAB0003', 2, 1, 'not paid', '2024-11-27 23:09:17'),
(3, '3924373457', 6583197162, '202200003', 'LAB0001', 2, 1, 'paid', '2025-01-02 22:25:39'),
(4, '3924373457', 6583197162, '202200003', 'LAB0003', 2, 1, 'paid', '2025-01-02 22:25:39'),
(5, '6429499345', 1108487034, '202200001', 'LAB0001', 2, 1, 'paid', '2025-01-02 23:49:00'),
(6, '6429499345', 1108487034, '202200001', 'LAB0002', 2, 1, 'paid', '2025-01-02 23:49:00'),
(7, '6429499345', 1108487034, '202200001', 'LAB0003', 2, 1, 'paid', '2025-01-02 23:49:00'),
(8, '2954080778', 1108487032, '202300002', 'LAB0002', 7, 1, 'paid', '2025-01-03 00:29:57'),
(9, '2954080778', 1108487032, '202300002', 'LAB0003', 7, 1, 'paid', '2025-01-03 00:29:57'),
(10, '2954080778', 1108487032, '202300002', 'LAB0001', 7, 1, 'paid', '2025-01-03 00:29:57');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `roleId` varchar(100) NOT NULL,
  `role` varchar(60) NOT NULL,
  `roleUserId` varchar(100) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `roleId`, `role`, `roleUserId`, `date`) VALUES
(1, 'ROL-001', 'admin', 'USR-0001', '2022-10-31 21:05:52'),
(2, 'ROL-002', 'supervisor', 'USR-0001', '2022-10-31 22:00:02'),
(3, 'ROL-003', 'nurse', 'USR-0001', '2022-11-23 10:04:37'),
(4, 'ROL-004', 'laboratory technician', 'USR-0001', '2022-11-23 10:05:18'),
(5, 'ROL-005', 'radiologist', 'USR-0001', '2022-11-23 10:05:41'),
(6, 'ROL-006', 'pharmacist', 'USR-0001', '2022-11-23 10:07:15'),
(7, 'ROL-007', 'human resource manager', 'USR-0001', '2022-11-23 10:07:42'),
(8, 'ROL-008', 'doctor', 'USR-0001', '2022-11-23 10:07:52'),
(9, 'ROL-009', 'director', 'USR-0001', '2022-11-23 10:08:07'),
(10, 'ROL-010', 'acountant', 'USR-0001', '2022-11-23 10:08:22'),
(11, 'ROL-011', 'record manager', 'USR-0001', '2022-11-23 10:08:58'),
(14, 'ROL-012', 'secretary', 'USR-0001', '2025-01-06 23:57:46');

-- --------------------------------------------------------

--
-- Table structure for table `samples`
--

CREATE TABLE `samples` (
  `id` int(11) NOT NULL,
  `sampleId` varchar(255) NOT NULL,
  `samplename` varchar(255) NOT NULL,
  `sampleUserId` varchar(30) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `samples`
--

INSERT INTO `samples` (`id`, `sampleId`, `samplename`, `sampleUserId`, `date`) VALUES
(1, 'SAM-001', 'Blood', '1', '2022-09-04 17:02:41'),
(2, 'SAM-002', 'Urine', '1', '2022-09-04 17:04:05'),
(4, 'SAM-003', 'Sputum', '1', '2022-09-04 17:17:29'),
(5, 'SAM-004', 'blood o', 'USR-0001', '2025-01-15 20:18:59'),
(6, 'SAM-005', 'stool', 'USR-0001', '2025-01-15 23:21:04');

-- --------------------------------------------------------

--
-- Table structure for table `specializations`
--

CREATE TABLE `specializations` (
  `id` int(11) NOT NULL,
  `specializeId` varchar(100) NOT NULL,
  `specialized` varchar(255) NOT NULL,
  `specializeUserId` varchar(100) NOT NULL,
  `disabled` int(11) NOT NULL DEFAULT 0,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `specializations`
--

INSERT INTO `specializations` (`id`, `specializeId`, `specialized`, `specializeUserId`, `disabled`, `date`) VALUES
(1, 'SPC-001', 'surgion', 'USR-0001', 0, '2022-11-03 14:20:53'),
(2, 'SPC-002', 'physician', 'USR-0001', 0, '2022-11-25 15:49:04'),
(3, 'SPC-003', 'gynocologist', 'USR-0001', 0, '2022-11-25 15:49:28'),
(4, 'SPC-004', 'peadriatrician', 'USR-0001', 0, '2022-11-25 15:49:48'),
(5, 'SPC-005', 'haematologist', 'USR-0001', 0, '2025-01-09 00:43:15'),
(6, 'SPC-006', 'Cyto Technologist ', 'USR-0001', 0, '2025-01-09 11:42:13');

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` int(11) NOT NULL,
  `testCode` varchar(255) NOT NULL,
  `testname` varchar(255) NOT NULL,
  `cost` varchar(255) NOT NULL DEFAULT '0',
  `insurance_cost` varchar(255) NOT NULL DEFAULT '0',
  `testsLabSectionId` varchar(100) DEFAULT NULL,
  `testsSampleId` varchar(100) DEFAULT NULL,
  `testsContainerId` varchar(100) DEFAULT NULL,
  `refRanges` varchar(255) DEFAULT NULL,
  `testsUnitId` varchar(100) DEFAULT NULL,
  `testsUserId` varchar(100) NOT NULL,
  `testStatus` varchar(55) NOT NULL,
  `toggleswitch` varchar(10) DEFAULT NULL,
  `testDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`id`, `testCode`, `testname`, `cost`, `insurance_cost`, `testsLabSectionId`, `testsSampleId`, `testsContainerId`, `refRanges`, `testsUnitId`, `testsUserId`, `testStatus`, `toggleswitch`, `testDate`) VALUES
(1, 'LAB0001', 'CBC', '15000', '25000', 'LSC-003', 'SAM-001', 'CON-002', NULL, ' ', 'USR-0001', 'enabled', 'checked', '2024-03-15 21:48:54'),
(2, 'LAB0002', 'RFT', '15000', '20000', 'LSC-001', 'SAM-001', 'CON-001', NULL, NULL, 'USR-0001', 'enabled', 'checked', '2024-03-15 22:52:20'),
(3, 'LAB0003', 'BS', '5000', '9000', 'LSC-004', 'SAM-004', 'CON-006', 'No Mps Seen', 'UNI-001', 'USR-0001', 'enabled', '', '2024-03-15 23:44:24'),
(4, 'LAB0004', 'RPR', '5678', '6789', 'LSC-007', 'SAM-005', 'CON-006', 'NA', 'UNI-008', 'USR-0001', 'enabled', NULL, '2025-01-16 14:22:55'),
(5, 'LAB0005', 'RFT', '5678', '6789', 'LSC-001', 'SAM-001', 'CON-001', NULL, ' ', 'USR-0001', 'enabled', 'checked', '2025-01-17 22:10:31'),
(6, 'LAB0006', 'LFT', '500', '700', 'LSC-001', 'SAM-001', 'CON-001', NULL, NULL, 'USR-0001', 'enabled', 'checked', '2025-01-18 14:19:15');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int(11) NOT NULL,
  `unitId` varchar(100) NOT NULL,
  `unitname` varchar(255) NOT NULL,
  `unitUserId` varchar(100) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `unitId`, `unitname`, `unitUserId`, `date`) VALUES
(1, 'UNI-001', 'N/A', '1', '2020-11-17 00:10:40'),
(2, 'UNI-002', 'mg/dl', '2', '2020-11-17 00:10:48'),
(3, 'UNI-003', 'Mmol/l', '7', '2020-11-17 00:10:58'),
(4, 'UNI-004', 'U/L', '2', '2020-11-17 00:11:27'),
(5, 'UNI-005', 'g/dl', '3', '2020-11-17 00:11:46'),
(6, 'UNI-006', 'ng/ml', '1', '2022-09-08 16:56:17'),
(7, 'UNI-007', 'g/ml', '1', '2022-11-03 14:13:44'),
(8, 'UNI-008', 'm/mil', 'USR-0001', '2025-01-16 00:01:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `userId` varchar(255) NOT NULL,
  `firstname` varchar(60) NOT NULL,
  `lastname` varchar(60) NOT NULL,
  `username` varchar(255) NOT NULL,
  `slugs` varchar(255) DEFAULT NULL,
  `gender` varchar(6) NOT NULL DEFAULT '''male''',
  `email` varchar(255) NOT NULL,
  `usersRoleId` varchar(20) NOT NULL,
  `usersSpecializeId` int(100) NOT NULL,
  `deletable` tinyint(1) NOT NULL DEFAULT 1,
  `image` varchar(500) DEFAULT NULL,
  `about` text DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `twitterlink` varchar(255) DEFAULT NULL,
  `facebooklink` varchar(255) DEFAULT NULL,
  `instagramlink` varchar(255) DEFAULT NULL,
  `linkedinlink` varchar(255) DEFAULT NULL,
  `userSaveBy` int(100) NOT NULL,
  `date` datetime NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `userId`, `firstname`, `lastname`, `username`, `slugs`, `gender`, `email`, `usersRoleId`, `usersSpecializeId`, `deletable`, `image`, `about`, `company`, `country`, `address`, `phone`, `twitterlink`, `facebooklink`, `instagramlink`, `linkedinlink`, `userSaveBy`, `date`, `password`) VALUES
(1, 'USR-0001', 'cent', 'ci', 'centci', 'cent-ci', 'male', 'centci@gmail.com', '2', 0, 1, 'uploads/images/1735306147_IMG_20191214_201716_3.jpg', 'hey Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ', 'Holy Family Virika Hospital', 'kenya', 'Kachwamba', '0782559487', 'https://www.twitter.com', 'https://www.facebook.com', 'https://www.instagram.com', 'https://www.linkedin.com', 0, '2022-07-23 21:15:32', '$2y$10$nh6e6L8XD4hg9f0Dm01TgeywpRedp/iv68WF8E8DXkB7UfTCFMo4W'),
(2, 'USR-0002', 'PAMELA', 'LIZA', 'AJ', NULL, 'female', 'mary@gmail.com', '1', 0, 1, NULL, '                                                                                                                                                                        medical officer, special grade\r\nThis is the first item\'s accordion body. It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It\'s also worth noting that just about any HTML can go within the. accordion-body, though the transition does limit overflow.                                                                                                                                                          ', 'Rippon', 'uganda', 'Magwa', '0783987564', '', '', '', '', 0, '2022-07-26 15:12:56', '$2y$10$VibbwLrOaSh4i31ulik8L.cBopAk060WkucIXw/6YjoDE9DTL.AM.'),
(3, 'USR-0003', 'opio', 'paul', 'opio', NULL, 'male', 'paul@gmail.com', '1', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2022-08-04 19:04:28', '$2y$10$OLPo3ju7QZUn4Xcgk/kL7OHC49qFaaY0VZO6knubfcQYpNywoRWRC'),
(4, 'USR-0004', 'adoch', 'mary', 'adoch', NULL, 'female', 'adoch@gmail.com', '10', 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2022-08-04 21:39:43', '$2y$10$tI3hwkkSthQ6naTnUPtSo.Cq2.ZujJJUbIiEhRUgMG0LpbiHsWYXS'),
(7, 'USR-0005', 'odongo', 'patrick', 'patrikos', NULL, 'male', 'patrikos@gmail.com', '3', 0, 1, NULL, NULL, 'Oyam district LG', 'uganda', 'Atapara', '000256784353535', NULL, NULL, NULL, NULL, 0, '2022-08-14 13:55:36', '$2y$10$8Pc1pmLrQq6A0KKiR0WAr.IW0fm3ozY72UvuStTHLz9Ug1xaSztsK'),
(8, 'USR-0006', 'ogola', 'james', 'ogola', NULL, 'male', 'ogola@gmail.com', '3', 0, 1, NULL, NULL, NULL, 'uganda', NULL, '012478596', NULL, NULL, NULL, NULL, 0, '2022-08-21 14:10:04', '$2y$10$G1FkUP.3hu/mXr9ouhybrOKNoO9mPpTDK6BuCi990uKoyziL8TmvO'),
(9, 'USR-0007', 'omara', 'omara', 'boniface', NULL, 'male', 'boniface@gmail.com', '4', 0, 1, NULL, NULL, NULL, 'uganda', NULL, '078255948778', NULL, NULL, NULL, NULL, 0, '2022-08-21 14:43:24', '$2y$10$QJw9NKkmdgNTAyyOCUWyS.CaWG3X1SwPO6QLnGkJ33HCEIxvAZVoa'),
(10, 'USR-0008', 'jeni', 'jane', 'jane', NULL, 'female', 'jane@gmail.com', '3', 0, 1, NULL, NULL, NULL, 'uganda', NULL, '078255948778', NULL, NULL, NULL, NULL, 0, '2022-08-21 14:46:59', '$2y$10$KykzA0OpPNmgXx18pBAmtOyjUrFBoJvVRVjY.0d9.XHKduzEUpZhC'),
(11, 'USR-0009', 'molo', 'tom', 'tom', NULL, 'male', 'jas@gmail.com', '2', 0, 1, NULL, NULL, NULL, 'uganda', NULL, '078255948778', NULL, NULL, NULL, NULL, 0, '2022-08-21 23:38:46', '$2y$10$pzLyzhAI9tX8INZZ5IhI0OR7eKG0Iyw13tVttX3JjhbZab3U/htVW'),
(12, 'USR-0010', 'juli', 'juli', 'juli', NULL, 'female', 'juli@gmail.com', '1', 0, 1, NULL, NULL, NULL, 'uganda', NULL, '078255948778', NULL, NULL, NULL, NULL, 0, '2022-08-21 23:40:37', '$2y$10$auyJTSkjNmYCCCTFRNlLoeGXN3A1ci5OpJffUml7xNNHIyPAoGvvO'),
(13, 'USR-0011', 'centboy', 'james', 'boniface', NULL, 'male', 'bonifacey@gmail.com', '1', 0, 1, NULL, NULL, NULL, 'uganda', NULL, '078255948778', NULL, NULL, NULL, NULL, 0, '2022-08-21 23:42:06', '$2y$10$Qv1MoJw09o0tDamCWVk6ZuYIP3AqHXcNr78I7tDgkkG5Ve7YsjlDi'),
(24, 'USR-0012', 'cent', 'james', 'centci', NULL, 'male', 'centci9@gmail.com', '6', 3, 1, NULL, NULL, NULL, 'kenya', NULL, '078255948778', NULL, NULL, NULL, NULL, 0, '2024-12-25 08:31:48', '$2y$10$UaKVsRS6RN5LjCWhTQUSgez25K..asIX.gpp68CJ.JStkCn6lqeou'),
(33, 'USR-0013', 'centboy', 'cih', 'centcib', NULL, 'male', 'centcik9@gmail.com', '11', 3, 1, NULL, NULL, NULL, 'uganda', NULL, '078255948778', NULL, NULL, NULL, NULL, 0, '2024-12-26 21:35:56', '$2y$10$Y8XirufsHAxFOv/BgT540OCxoqNelxmXgeBgBjurGt0y.0XNvj.XK'),
(34, 'USR-0014', 'centboy', 'boniface', 'boniface5', NULL, 'male', 'ogolak@gmail.com', '11', 3, 1, NULL, NULL, NULL, 'uganda', NULL, '078255948778', NULL, NULL, NULL, NULL, 0, '2024-12-26 21:37:28', '$2y$10$waRELW5xxfXMnSebJKBeEeDe/QZmJAsgeRWM.JUY4MtcnPh/kec1S');

-- --------------------------------------------------------

--
-- Table structure for table `visits`
--

CREATE TABLE `visits` (
  `id` int(11) NOT NULL,
  `visit_Id` bigint(100) NOT NULL,
  `patientId` varchar(100) NOT NULL,
  `visitCat` varchar(255) NOT NULL,
  `billMode` varchar(255) NOT NULL,
  `billTo` varchar(255) NOT NULL,
  `insuranceNo` int(11) DEFAULT NULL,
  `drSpeclizId` varchar(100) DEFAULT NULL,
  `drUserId` varchar(20) DEFAULT NULL,
  `userId` varchar(100) NOT NULL,
  `departmentId` varchar(100) DEFAULT NULL,
  `visitPriority` varchar(255) NOT NULL,
  `VisitDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `visits`
--

INSERT INTO `visits` (`id`, `visit_Id`, `patientId`, `visitCat`, `billMode`, `billTo`, `insuranceNo`, `drSpeclizId`, `drUserId`, `userId`, `departmentId`, `visitPriority`, `VisitDate`) VALUES
(1, 1108487033, '202300002', 'self request', 'Cash', '6', NULL, NULL, NULL, '1', '2', 'normal', '2023-08-17 17:16:19'),
(2, 1108487034, '202200001', 'self request', 'Cash', '6', NULL, NULL, NULL, '1', '2', 'normal', '2023-09-23 00:01:00'),
(3, 1108487035, '202300001', 'self request', 'Cash', '6', NULL, NULL, NULL, '1', '2', 'normal', '2023-09-23 00:24:50'),
(4, 1108487032, '202300002', 'self request', 'Cash', '5', NULL, NULL, NULL, '1', '7', 'normal', '2024-11-27 11:04:38'),
(5, 6583197162, '202200003', 'self request', 'Cash', '5', NULL, NULL, NULL, '1', '2', 'normal', '2025-01-02 22:23:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cashierSaveds`
--
ALTER TABLE `cashierSaveds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `containers`
--
ALTER TABLE `containers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `deptId` (`deptId`);

--
-- Indexes for table `extratests`
--
ALTER TABLE `extratests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `insurances`
--
ALTER TABLE `insurances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `labextratestreports`
--
ALTER TABLE `labextratestreports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `labReports`
--
ALTER TABLE `labReports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `labRequests`
--
ALTER TABLE `labRequests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `labsections`
--
ALTER TABLE `labsections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `catName` (`labname`),
  ADD KEY `date` (`date`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pendingPayments`
--
ALTER TABLE `pendingPayments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `samples`
--
ALTER TABLE `samples`
  ADD PRIMARY KEY (`id`),
  ADD KEY `catName` (`samplename`),
  ADD KEY `date` (`date`);

--
-- Indexes for table `specializations`
--
ALTER TABLE `specializations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role` (`usersRoleId`),
  ADD KEY `email` (`email`),
  ADD KEY `date` (`date`),
  ADD KEY `firstname` (`firstname`),
  ADD KEY `lastname` (`lastname`),
  ADD KEY `company` (`company`),
  ADD KEY `country` (`country`),
  ADD KEY `phone` (`phone`);

--
-- Indexes for table `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cashierSaveds`
--
ALTER TABLE `cashierSaveds`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `containers`
--
ALTER TABLE `containers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `extratests`
--
ALTER TABLE `extratests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `insurances`
--
ALTER TABLE `insurances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `labextratestreports`
--
ALTER TABLE `labextratestreports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `labReports`
--
ALTER TABLE `labReports`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `labRequests`
--
ALTER TABLE `labRequests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `labsections`
--
ALTER TABLE `labsections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pendingPayments`
--
ALTER TABLE `pendingPayments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `samples`
--
ALTER TABLE `samples`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `specializations`
--
ALTER TABLE `specializations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `visits`
--
ALTER TABLE `visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
