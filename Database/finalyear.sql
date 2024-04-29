-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 09, 2023 at 01:16 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `finalyear`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `ProductName` varchar(255) NOT NULL,
  `Category` varchar(255) NOT NULL,
  `SalesPrice` decimal(10,2) NOT NULL,
  `Profit` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `CategoryName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `CategoryName`) VALUES
(1, 'Foods and Beverages'),
(2, 'Computers'),
(3, 'Books and Magazines'),
(5, 'Shoes'),
(6, 'clothes'),
(7, 'gadgets'),
(8, 'Phones'),
(9, 'Candies');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `customerName` varchar(50) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `AmtSpent` decimal(10,2) NOT NULL,
  `servedBy` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customerName`, `phone`, `AmtSpent`, `servedBy`, `date`) VALUES
(26, 'Torpedo', '02378567', 280.00, 'Sara Hills', '2023-07-04'),
(27, 'Comango', '0345678923', 350.00, 'Sara Hills', '2023-07-31'),
(28, 'Comango', '0345678923', 350.00, 'Sara Hills', '2023-07-31'),
(29, 'Trending', '055874356', 140.00, 'Maggie Mills', '2023-07-31'),
(30, 'Trending', '055874356', 140.00, 'Maggie Mills', '2023-07-31'),
(31, 'Torpedo', '0567876548', 350.00, 'Emmanuel Yandoh', '2023-08-01'),
(32, 'Torpedo', '0567876548', 350.00, 'Emmanuel Yandoh', '2023-08-01'),
(33, 'Mex', '0245678909', 460.00, 'Mex Aperkoh', '2023-08-01'),
(34, 'Mex', '0245678909', 460.00, 'Mex Aperkoh', '2023-08-01'),
(35, 'Mex', '0245678909', 460.00, 'Mex Aperkoh', '2023-08-01'),
(36, 'Mex', '0245678909', 460.00, 'Mex Aperkoh', '2023-08-01'),
(37, 'Torpedo', '054376543', 450.00, '', '2023-08-17'),
(38, 'Torpedo', '054376543', 450.00, '', '2023-08-17'),
(39, 'Torpedo', '054376543', 450.00, '', '2023-08-17'),
(40, 'Torpedo', '054376543', 450.00, '', '2023-08-17'),
(41, 'John Turkson', '0245643093', 270.00, '', '2023-08-27'),
(42, 'John Turkson', '0245643093', 270.00, '', '2023-08-27'),
(43, 'John Turkson', '0245643093', 270.00, '', '2023-08-27'),
(44, 'Yaw Kwesi', '0000000002', 200.00, '', '2023-08-28'),
(45, 'Joe', '021455687', 600.00, '', '2023-08-28'),
(46, 'Joe', '021455687', 600.00, '', '2023-08-28'),
(47, 'Donald Hope', '0554789123', 450.00, '', '2023-08-28'),
(48, 'Donald Hope', '0554789123', 450.00, '', '2023-08-28'),
(49, 'Charlse Lamptey', '123333228', 530.00, 'Emmanuel Aperkoh', '2023-08-28'),
(50, 'Charlse Lamptey', '123333228', 530.00, 'Emmanuel Aperkoh', '2023-08-28'),
(51, 'John Turkson', '0245643093', 50.00, 'Emmanuel Aperkoh', '2023-08-29'),
(52, 'John Turkson', '0245643093', 50.00, 'Emmanuel Aperkoh', '2023-08-30'),
(53, 'Eric', '0245643093', 530.00, 'Emmanuel Aperkoh', '2023-08-31'),
(54, 'Eric', '0245643093', 530.00, 'Emmanuel Aperkoh', '2023-08-31'),
(55, 'Eric', '0245643093', 530.00, 'Emmanuel Aperkoh', '2023-08-31'),
(56, 'Eric', '0245643093', 440.00, 'Emmanuel Aperkoh', '2023-08-31'),
(57, 'Eric', '0245643093', 440.00, 'Emmanuel Aperkoh', '2023-08-31'),
(58, 'Eric', '0245643093', 440.00, 'Emmanuel Aperkoh', '2023-08-31'),
(59, 'Eric', '0245643093', 15765.00, 'Emmanuel Aperkoh', '2023-08-31'),
(60, 'Eric', '0245643093', 15765.00, 'Emmanuel Aperkoh', '2023-08-31'),
(61, 'Eric', '0245643093', 15765.00, 'Emmanuel Aperkoh', '2023-08-31'),
(62, 'Kwame', '0556069969', 620.00, 'Emmanuel Aperkoh', '2023-08-31'),
(63, 'Kwame', '0556069969', 620.00, 'Emmanuel Aperkoh', '2023-08-31'),
(64, 'Kwame', '0556069969', 620.00, 'Emmanuel Aperkoh', '2023-08-31'),
(65, 'Kwame', '0556069969', 620.00, 'Emmanuel Aperkoh', '2023-08-31'),
(66, 'Nasmik', '0445599699', 500.00, 'Emmanuel Aperkoh', '2023-08-31'),
(67, 'Nasmik', '0445599699', 500.00, 'Emmanuel Aperkoh', '2023-08-31'),
(68, 'potttrt', '0245643093', 625.00, 'Emmanuel Aperkoh', '2023-08-31'),
(69, 'potttrt', '0245643093', 625.00, 'Emmanuel Aperkoh', '2023-08-31'),
(70, 'hfjfk', '0345555588', 485.00, 'Emmanuel Aperkoh', '2023-08-31'),
(71, 'hfjfk', '0345555588', 485.00, 'Emmanuel Aperkoh', '2023-08-31'),
(72, 'John Turkson', '0123544444', 200.00, 'Emmanuel Aperkoh', '2023-08-31'),
(73, 'John Turkson', '0123544444', 200.00, 'Emmanuel Aperkoh', '2023-08-31'),
(74, 'John Turkson', '0245643093', 790.00, 'Emmanuel Aperkoh', '2023-08-31'),
(75, 'John Turkson', '0245643093', 250.00, '', '2023-09-06'),
(76, 'Charlse Lamptey', '123333228', 18810.00, '', '2023-09-06'),
(77, 'Eric', '0245643093', 210.00, 'Emmanuel Aperkoh', '2023-09-06');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `ID` int(11) NOT NULL,
  `EmpName` varchar(255) NOT NULL,
  `Gender` varchar(20) NOT NULL,
  `Address` text NOT NULL,
  `Phone` varchar(11) NOT NULL,
  `Hire_date` date NOT NULL,
  `Role` text NOT NULL,
  `SalaryPerMonth` decimal(10,2) NOT NULL,
  `Email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`ID`, `EmpName`, `Gender`, `Address`, `Phone`, `Hire_date`, `Role`, `SalaryPerMonth`, `Email`) VALUES
(24, 'Killerman hope', 'Male', 'BY 160', '0245678907', '2023-06-18', 'Packager', 2500.00, 'hope@gmail.com'),
(26, 'Moses Fliker', 'Male', 'TY/B2C/4', '0546789076', '2023-06-18', 'Manager', 500.00, 'moses@gmail.com'),
(27, 'dkjdsij', 'Male', '564/yuue', '9388474883', '2023-06-20', 'Packager', 500.00, 'yeoi@mail.com'),
(28, 'kjdkjalj', 'Male', 'vm-893', '0988848849', '2023-06-20', 'Cleaner', 2500.00, 'mn,d@email.com'),
(29, 'Alice Grayson', 'Female', '556/rty', '0348858589', '2023-06-20', 'Vendor', 6000.00, 'nM@email.com'),
(30, 'djflkdjsl', 'Male', 'dkdkjhakhfd', '8477448499', '2023-06-20', 'Checker', 2000.00, 'jkldjljsi@mail.com'),
(31, 'djliejliskdnf', 'Male', '567/awe', '3774984985', '2023-06-20', 'Checker', 5900.00, 'eir@email.com');

-- --------------------------------------------------------

--
-- Table structure for table `limit`
--

CREATE TABLE `limit` (
  `id` int(11) NOT NULL,
  `limitValue` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `limit`
--

INSERT INTO `limit` (`id`, `limitValue`) VALUES
(1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `date_time` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `message`, `date_time`) VALUES
(1, 'Digestive is running low on stock. Only 7 left.', '2023-09-06 17:36:18 PM'),
(2, 'The Calori is running low on stock. Only 8 left.', '2023-09-06 17:36:18 PM'),
(3, 'Digestive is running low on stock. Only 5 left.', '2023-09-06 18:42:09 PM'),
(4, 'Lenovo ideapad is running low on stock. Only 6 left.', '2023-09-06 18:42:09 PM'),
(5, 'sugar free cake will expire in less than a week.', '2023-09-06 18:43:36 PM'),
(6, 'M&M will expire in less than a week.', '2023-09-06 18:43:36 PM');

-- --------------------------------------------------------

--
-- Table structure for table `print`
--

CREATE TABLE `print` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `ID` int(11) NOT NULL,
  `ProductName` varchar(255) NOT NULL,
  `Category` varchar(128) NOT NULL,
  `CostPrice` decimal(10,2) NOT NULL,
  `SalesPrice` decimal(10,2) NOT NULL,
  `Profit` decimal(10,2) NOT NULL,
  `Quantity` int(100) NOT NULL,
  `Supplier` varchar(255) NOT NULL,
  `DateInStock` varchar(255) NOT NULL,
  `ExpireDate` varchar(255) NOT NULL DEFAULT 'None',
  `Description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ID`, `ProductName`, `Category`, `CostPrice`, `SalesPrice`, `Profit`, `Quantity`, `Supplier`, `DateInStock`, `ExpireDate`, `Description`) VALUES
(20, 'Digestive', 'Books and Magazines', 40.00, 50.00, 10.00, 18, 'Mini Mart', '2023-06-22', '2024-06-22', 'A new brand                 '),
(21, 'Grape Spring', 'Foods and Beverages', 50.00, 70.00, 20.00, 86, 'Mini Mart', '2023-06-22', '2024-07-22', ' Shampaigne is the best                                '),
(26, 'Digestive', 'Foods and Beverages', 40.60, 55.00, 14.40, 5, 'Mini Mart', '2023-08-28', '', ' red king crackers                                '),
(27, 'The Calori', 'Books and Magazines', 25.00, 50.00, 25.00, 8, 'MRS ', '2023-08-28', '', ' Shampagne is the best                             '),
(28, 'Lenovo ideapad', 'Computers', 2100.00, 3100.00, 1000.00, 6, 'Burmuda Company', '2023-08-28', '', 'ash colored                                 '),
(29, 'Apple Drink', 'Foods and Beverages', 10.00, 15.00, 5.00, 36, 'Mini Mart', '2023-08-28', '2023-08-28', ' green labelled                                 '),
(30, 'Sandaz bag', 'clothes', 57.63, 85.00, 27.37, 38, 'A&D clothings', '2023-08-28', '', 'black water proof                    '),
(31, 'adidas shirt', 'clothes', 52.50, 100.00, 47.50, 16, 'A&D clothings', '2023-08-28', '', ' blue and green colored shirt with adidas symbol in front                                '),
(32, 'The Descendants', 'Books and Magazines', 25.00, 50.00, 25.00, 13, 'Safe Supply ', '2023-08-28', '', 'a comic book                                  '),
(33, 'sugar free cake', 'Foods and Beverages', 50.00, 65.00, 15.00, 4, 'Safe Supply ', '2023-08-28', '2023-09-08', ' a white cake with pea nuts                                '),
(34, 'laptop stand', 'gadgets', 15.00, 20.00, 5.00, 8, 'Burmuda Company', '', '', ' a metallic square stand with white label                                '),
(35, 'phone holder', 'gadgets', 40.00, 50.00, 10.00, 35, 'Burmuda Company', '2023-08-28', '', 'metallic phone to laptop holder.                                 '),
(36, 'samsung galaxy X', 'Phones', 800.00, 1000.00, 200.00, 10, 'Burmuda Company', '2023-08-28', '', ' smart phone with curved screen                                '),
(37, 'M&M', 'Candies', 10.00, 15.00, 5.00, 25, 'Mini Mart', '2023-08-28', '2023-09-09', 'red package                                  '),
(38, 'iphone', 'Phones', 2000.00, 3000.00, 1000.00, 42, 'Safe Supply ', '2023-05-22', '', 'new brand X                               '),
(39, 'Asus laptop', 'Computers', 1400.00, 2500.00, 1100.00, 12, 'Safe Supply ', '2023-02-24', '', ' black and ash, largest size                                '),
(40, 'coca cola', 'Foods and Beverages', 14.00, 15.50, 1.50, 42, 'Mini Mart', '2023-08-09', '2023-08-29', 'new brand                                  '),
(41, 'peps', 'gadgets', 2.00, 4.50, 2.50, 60, 'Mini Mart', '2023-08-29', '', ' djsnxncbcuuye                                '),
(42, 'fast go', 'Shoes', 50.00, 65.80, 15.80, 20, 'A&D clothings', '2023-08-29', '', ' fjhhbvbuioeds                                '),
(43, 'sank sink', 'Books and Magazines', 452.00, 475.00, 23.00, 12, 'MRS ', '2023-08-29', '', ' sdfwwwert                                '),
(44, 'Sugar', 'Foods and Beverages', 5.00, 52.00, 47.00, 45, 'MRS ', '2023-08-30', '', 'llkkjnmmhg                               ');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `CustomerName` varchar(255) NOT NULL,
  `ProductName` varchar(255) NOT NULL,
  `Category` varchar(255) NOT NULL,
  `SalesPrice` decimal(10,2) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `TotalPrice` decimal(10,2) NOT NULL,
  `Profit` decimal(10,2) NOT NULL,
  `Date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `CustomerName`, `ProductName`, `Category`, `SalesPrice`, `Quantity`, `TotalPrice`, `Profit`, `Date`) VALUES
(27, 'Mex', 'Digestive', 'Books and Magazines', 50.00, 4, 200.00, 0.00, '2023-06-29'),
(28, 'Donald', 'Digestive', 'Books and Magazines', 50.00, 3, 150.00, 0.00, '2023-06-30'),
(29, 'Donald', 'Grape Spring', 'Foods and Beverages', 70.00, 3, 150.00, 0.00, '2023-06-30'),
(30, 'Torpedo', 'Grape Spring', 'Foods and Beverages', 70.00, 10, 0.00, 0.00, '2023-07-04'),
(31, 'Torpedo', 'Grape Spring', 'Foods and Beverages', 70.00, 4, 280.00, 80.00, '2023-07-04'),
(32, 'Comango', 'Grape Spring', 'Foods and Beverages', 70.00, 5, 350.00, 100.00, '2023-07-31'),
(33, 'Trending', 'Grape Spring', 'Foods and Beverages', 70.00, 2, 140.00, 40.00, '2023-07-31'),
(34, 'Torpedo', 'Grape Spring', 'Foods and Beverages', 70.00, 5, 350.00, 100.00, '2023-08-01'),
(35, 'Mex', 'Grape Spring', 'Foods and Beverages', 70.00, 2, 140.00, 40.00, '2023-08-01'),
(36, 'Mex', 'The Calori', 'Books and Magazines', 80.00, 2, 140.00, 40.00, '2023-08-01'),
(38, 'Torpedo', 'Grape Spring', 'Foods and Beverages', 70.00, 2, 100.00, 20.00, '2023-08-17'),
(40, 'John Turkson', 'Grape Spring', 'Foods and Beverages', 70.00, 1, 50.00, 10.00, '2023-08-27'),
(41, 'John Turkson', 'The Calori', 'Books and Magazines', 80.00, 1, 50.00, 10.00, '2023-08-27'),
(44, 'Joe', 'Grape Spring', 'Foods and Beverages', 70.00, 4, 320.00, 40.00, '2023-08-28'),
(49, 'John Turkson', 'Digestive', 'Books and Magazines', 50.00, 1, 50.00, 10.00, '2023-08-29'),
(50, 'John Turkson', 'Digestive', 'Books and Magazines', 50.00, 1, 50.00, 10.00, '2023-08-30'),
(51, 'Eric', 'Digestive', 'Books and Magazines', 50.00, 1, 50.00, 10.00, '2023-08-31'),
(52, 'Eric', 'Grape Spring', 'Foods and Beverages', 70.00, 1, 50.00, 10.00, '2023-08-31'),
(53, 'Eric', 'The Calori', 'Books and Magazines', 50.00, 1, 50.00, 10.00, '2023-08-31'),
(54, 'Eric', 'Digestive', 'Books and Magazines', 50.00, 3, 150.00, 30.00, '2023-08-31'),
(55, 'Eric', 'Grape Spring', 'Foods and Beverages', 70.00, 3, 150.00, 30.00, '2023-08-31'),
(56, 'Eric', 'The Calori', 'Books and Magazines', 50.00, 3, 150.00, 30.00, '2023-08-31'),
(57, 'Eric', 'Digestive', 'Foods and Beverages', 55.00, 3, 165.00, 43.20, '2023-08-31'),
(58, 'Eric', 'The Calori', 'Books and Magazines', 50.00, 3, 165.00, 43.20, '2023-08-31'),
(59, 'Eric', 'Lenovo ideapad', 'Computers', 3100.00, 3, 165.00, 43.20, '2023-08-31'),
(60, 'Kwame', 'Digestive', 'Books and Magazines', 50.00, 4, 200.00, 40.00, '2023-08-31'),
(61, 'Kwame', 'Grape Spring', 'Foods and Beverages', 70.00, 4, 200.00, 40.00, '2023-08-31'),
(62, 'Nasmik', 'Grape Spring', 'Foods and Beverages', 70.00, 5, 350.00, 100.00, '2023-08-31'),
(63, 'Nasmik', 'The Calori', 'Books and Magazines', 50.00, 5, 350.00, 100.00, '2023-08-31'),
(64, 'potttrt', 'The Descendants', 'Books and Magazines', 50.00, 6, 300.00, 150.00, '2023-08-31'),
(65, 'potttrt', 'sugar free cake', 'Foods and Beverages', 65.00, 6, 300.00, 150.00, '2023-08-31'),
(66, 'hfjfk', 'Apple Drink', 'Foods and Beverages', 15.00, 4, 60.00, 20.00, '2023-08-31'),
(67, 'hfjfk', 'Sandaz bag', 'clothes', 85.00, 4, 60.00, 20.00, '2023-08-31'),
(68, 'John Turkson', 'laptop stand', 'gadgets', 20.00, 5, 100.00, 25.00, '2023-08-31'),
(69, 'John Turkson', 'phone holder', 'gadgets', 50.00, 5, 100.00, 25.00, '2023-08-31'),
(70, 'John Turkson', 'Grape Spring', 'Foods and Beverages', 70.00, 6, 300.00, 60.00, '2023-08-31'),
(71, 'John Turkson', 'Grape Spring', 'Foods and Beverages', 70.00, 2, 140.00, 40.00, '2023-09-06'),
(72, 'John Turkson', 'Digestive', 'Foods and Beverages', 55.00, 2, 110.00, 28.80, '2023-09-06'),
(73, 'Charlse Lamptey', 'Grape Spring', 'Foods and Beverages', 70.00, 3, 210.00, 60.00, '2023-09-06'),
(74, 'Charlse Lamptey', 'Lenovo ideapad', 'Computers', 3100.00, 6, 18600.00, 6000.00, '2023-09-06'),
(75, 'Eric', 'Grape Spring', 'Foods and Beverages', 70.00, 3, 210.00, 60.00, '2023-09-06');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `CompanyName` varchar(255) NOT NULL DEFAULT 'RMS'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`CompanyName`) VALUES
('BusinessName');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `supplierID` int(11) NOT NULL,
  `companyName` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`supplierID`, `companyName`, `contact`) VALUES
(1, 'A&D clothings', '0234489950'),
(2, 'Mini Mart', '0556789876'),
(3, 'MRS ', '0245678909'),
(4, 'Safe Supply ', '0234679988'),
(5, 'Burmuda Company', '0245678499');

-- --------------------------------------------------------

--
-- Table structure for table `todo_list`
--

CREATE TABLE `todo_list` (
  `id` int(11) NOT NULL,
  `todo` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `todo_list`
--

INSERT INTO `todo_list` (`id`, `todo`, `status`) VALUES
(1, 'Meeting at 11', 'completed'),
(2, 'New supply coming soon', 'not-completed'),
(4, 'We have a party', 'not-completed');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `EmpName` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `EmpName`, `role`, `username`, `password`) VALUES
(8, 'Emmanuel Aperkoh', 'admin', 'user 1', '000'),
(9, 'Alice Grayson', 'vendor', 'user 2', '123'),
(10, 'Moses Fliker', 'stocker', 'user 3', '1234'),
(11, 'Alice Grayson', 'stocker', 'user 2', '001');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID` (`ID`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `limit`
--
ALTER TABLE `limit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `print`
--
ALTER TABLE `print`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID` (`ID`),
  ADD KEY `Category` (`Category`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`supplierID`);

--
-- Indexes for table `todo_list`
--
ALTER TABLE `todo_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Employee_ID` (`EmpName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `limit`
--
ALTER TABLE `limit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `print`
--
ALTER TABLE `print`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `supplierID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `todo_list`
--
ALTER TABLE `todo_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
