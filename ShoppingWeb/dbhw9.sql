-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2024 at 09:27 AM
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
-- Database: `dbhw9`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `age` int(11) NOT NULL,
  `province` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` varchar(20) DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `username`, `password`, `first_name`, `last_name`, `gender`, `age`, `province`, `email`, `role`) VALUES
(1, 'pornarakA', '$2y$10$Defq/W1T4KZRTTWIxZTY3OMmbO/PTZz.uFQQTEXVXPW6sjx7WELyS', 'kritsanaphon', 'ketkaew', 'male', 20, 'กรุงเทพมหานคร', 'darenhunt@gmail.com', 'admin'),
(2, 'teenoihi', '$2y$10$VHqUZdSjod5yaivUHceqZenAhw31w32lenQunfzSwKOPgtpwETf..', 'teenoi', 'aroi', 'male', 21, 'เลย', 'teenoi@gmail.com', 'customer'),
(3, 'teeyaigg', '$2y$10$0Mw/hgBxNLv6jHP2bHHDR.sVkS1OQ7gMs7G8iGYVlIbanZQCuInmG', 'teeyai', 'araia', 'male', 22, 'เลย', 'teeyai@gmail.com', 'customer'),
(4, 'Trexqa', '$2y$10$UAaLp6L9iYD8.cdplzGzoOQMkOHkRt7fl3iYpQnOwD0LkQ1oZQwUm', 'trex', 'dainosoa', 'male', 30, 'กรุงเทพมหานคร', 'trex@gmail.com', 'customer'),
(16, 'manage', '$2y$10$cWuTJF9UEn.8fMp8vS743uMPwMIjhM0UQPht4163tafSPgH33hMri', 'Manager', 'User', 'male', 30, 'กรุงเทพมหานคร', 'manage@example.com', 'manager'),
(17, 'Member', '$2y$10$JmCfPNHzD6nPA60b/10Oee9ik7kC34mEai.Vrxwnq23tSrHtIayw6', 'Member', 'Camping', 'male', 27, '0', 'member1000@gmail.com', 'customer'),
(18, 'Member2', '$2y$10$SIpe30ytlfE1T1rl6OGC2Oc23eQ6AenS85cTkms4wsBiR.Y8QiuXG', 'Member2', 'Camping', 'female', 29, '0', 'member2000@gmail.com', 'customer');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `stock_quantity` int(11) NOT NULL,
  `is_visible` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `image`, `price`, `category`, `description`, `stock_quantity`, `is_visible`) VALUES
(1, 'ถุงนอน ยี่ห้อ Coleman', 'images/sleeping_bag1.jpg', 1800.00, 'ที่นอน', 'ถุงนอนสำหรับการตั้งแคมป์ ขนาด 3 ฟุต\r\n- เหมาะสำหรับอุณหภูมิ 0-10 องศาเซลเซียส\r\n- น้ำหนักเบาและสะดวกในการพกพา', 50, 1),
(2, 'หมอนข้างพกพา', 'images/pillow.jpg', 600.00, 'ที่นอน', 'หมอนข้างพกพา ขนาด 30 x 50 ซม.\r\n- ทำจากวัสดุนุ่มสบาย\r\n- เหมาะสำหรับการเดินทางและตั้งแคมป์', 80, 1),
(3, 'ฟูกนอนพกพา', 'images/mattress.jpg', 2500.00, 'ที่นอน', 'ฟูกนอนพกพาสำหรับตั้งแคมป์\r\n- ขนาด 75 x 200 ซม.\r\n- สามารถพับเก็บได้ง่าย', 40, 1),
(4, 'ผ้าห่มเดินป่า', 'images/camping_blanket.jpg', 900.00, 'ที่นอน', 'ผ้าห่มกันน้ำสำหรับการเดินป่า\r\n- ขนาด 200 x 150 ซม.\r\n- ทำจากวัสดุที่ให้ความอบอุ่น', 100, 1),
(5, 'รองเท้าบูทกันน้ำ', 'images/boots.jpg', 3500.00, 'รองเท้า', 'รองเท้าบูทกันน้ำสำหรับการเดินป่า\r\n- ขนาด: 40-45\r\n- มีการป้องกันข้อเท้า', 70, 1),
(6, 'รองเท้าเดินป่า', 'images/hiking_shoes.jpg', 3000.00, 'รองเท้า', 'รองเท้าเดินป่ารุ่นใหม่\r\n- ออกแบบมาเพื่อความสบายและความทนทาน\r\n- ขนาด: 39-44', 80, 1),
(7, 'รองเท้ากีฬา', 'images/sports_shoes.jpg', 2500.00, 'รองเท้า', 'รองเท้ากีฬาสำหรับวิ่งและออกกำลังกาย\r\n- วัสดุเบา ระบายอากาศได้ดี\r\n- ขนาด: 37-43', 100, 1),
(8, 'รองเท้าสวมลำลอง', 'images/casual_shoes.jpg', 1800.00, 'รองเท้า', 'รองเท้าสวมลำลองสำหรับชายและหญิง\r\n- เหมาะสำหรับการใช้งานในชีวิตประจำวัน\r\n- ขนาด: 36-44', 90, 1),
(9, 'เสื้อกันฝน', 'images/raincoat.jpg', 1200.00, 'เสื้อผ้า', 'เสื้อกันฝนแบบพับได้ ขนาดฟรีไซส์\r\n- กันน้ำได้ดีและระบายอากาศ\r\n- น้ำหนักเบา พกพาสะดวก', 60, 1),
(10, 'เสื้อแจ็กเก็ตกันลม', 'images/windbreaker.jpg', 1500.00, 'เสื้อผ้า', 'เสื้อแจ็กเก็ตกันลม รุ่นยอดนิยม\r\n- เหมาะสำหรับการเดินป่าและกิจกรรมกลางแจ้ง\r\n- ขนาด: S-XXL', 70, 1),
(11, 'เสื้อยืดกัน UV', 'images/uv_shirt.jpg', 900.00, 'เสื้อผ้า', 'เสื้อยืดสำหรับกัน UV ขนาดฟรีไซส์\r\n- เหมาะสำหรับกิจกรรมกลางแจ้งในฤดูร้อน\r\n- ระบายอากาศได้ดี', 100, 1),
(12, 'กางเกงเดินป่า', 'images/hiking_pants.jpg', 1800.00, 'เสื้อผ้า', 'กางเกงเดินป่าสำหรับชาย\r\n- มีความทนทานและสะดวกสบาย\r\n- ขนาด: 30-40', 80, 1),
(13, 'ชุดว่ายน้ำ', 'images/swimwear.jpg', 1000.00, 'เสื้อผ้า', 'ชุดว่ายน้ำสำหรับชายและหญิง\r\n- ออกแบบมาสำหรับการใช้งานในน้ำ\r\n- ขนาด: S-XL', 60, 1),
(14, 'ไฟฉาย LED', 'images/flashlight.jpg', 800.00, 'อุปกรณ์เสริม', 'ไฟฉาย LED แบบพกพา\r\n- ส่องสว่างได้ไกลและทนทานต่อสภาพอากาศ\r\n- มีโหมดการใช้งานหลายแบบ', 150, 1),
(15, 'เครื่องกรองน้ำพกพา', 'images/water_filter.jpg', 2200.00, 'อุปกรณ์เสริม', 'เครื่องกรองน้ำแบบพกพา\r\n- สามารถกรองน้ำได้ 1000 ลิตร\r\n- เหมาะสำหรับการเดินป่าและแคมป์ปิ้ง', 80, 1),
(16, 'หม้อหุงข้าวไฟฟ้า', 'images/rice_cooker.jpg', 2200.00, 'อุปกรณ์เสริม', 'หม้อหุงข้าวไฟฟ้าขนาด 1.8 ลิตร\r\n- ใช้งานง่ายและรวดเร็ว\r\n- มีฟังก์ชันการอุ่นอาหาร', 80, 1),
(17, 'ชุดทำอาหารพกพา', 'images/cooking_gear.jpg', 1200.00, 'อุปกรณ์เสริม', 'ชุดอุปกรณ์ทำอาหารสำหรับการตั้งแคมป์\r\n- รวมเครื่องครัวต่างๆ ที่ใช้ได้ง่าย\r\n- น้ำหนักเบาและสะดวกในการพกพา', 90, 1),
(18, 'เก้าอี้พับได้', 'images/camping_chair.jpg', 1500.00, 'อุปกรณ์เสริม', 'เก้าอี้พับได้สำหรับการตั้งแคมป์\r\n- น้ำหนักเบา และสะดวกในการพกพา\r\n- สามารถรับน้ำหนักได้ถึง 100 กิโลกรัม', 100, 1),
(19, 'ชุดปฐมพยาบาล', 'images/first_aid_kit.jpg', 600.00, 'อุปกรณ์เสริม', 'ชุดปฐมพยาบาลเบื้องต้นสำหรับการเดินป่า\r\n- ประกอบด้วยอุปกรณ์ที่จำเป็นในการช่วยชีวิต\r\n- น้ำหนักเบาและสะดวกในการพกพา', 60, 1),
(20, 'ไฟฉายพกพา', 'images/portable_flashlight.jpg', 900.00, 'อุปกรณ์เสริม', 'ไฟฉายพกพาใช้แบตเตอรี่ ขนาดเล็ก น้ำหนักเบา\r\n- สะดวกในการใช้งานกลางแจ้ง\r\n- มีหลายระดับความแรงลม', 120, 1);
COMMIT;
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
