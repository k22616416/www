-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2020-06-05 10:11:54
-- 伺服器版本： 10.4.11-MariaDB
-- PHP 版本： 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `小農2`
--

-- --------------------------------------------------------

--
-- 資料表結構 `imgtest`
--

CREATE TABLE `imgtest` (
  `img` mediumblob NOT NULL,
  `imgtype` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `個人賣場2`
--

CREATE TABLE `個人賣場2` (
  `項目` int(11) NOT NULL,
  `賣場編號` varchar(20) NOT NULL,
  `產品編號` varchar(20) NOT NULL,
  `產品資訊` varchar(255) NOT NULL,
  `願意配銷地點` varchar(255) NOT NULL,
  `配銷方式` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `個人賣場2`
--

INSERT INTO `個人賣場2` (`項目`, `賣場編號`, `產品編號`, `產品資訊`, `願意配銷地點`, `配銷方式`) VALUES
(1, '123456', '1', '產品資訊1', '配銷地點1', '配銷方式1'),
(2, '654321', '2', '產品資訊2', '配銷地點2', '配銷方式2'),
(3, '123456', '3', '產品資訊3', '配銷地點3', '配銷方式3'),
(4, '123456', '4', '產品資訊4', '配銷地點4', '配銷方式4');

-- --------------------------------------------------------

--
-- 資料表結構 `審核`
--

CREATE TABLE `審核` (
  `使用者帳號` varchar(255) NOT NULL,
  `產品編號` int(11) NOT NULL,
  `產品資訊` varchar(255) NOT NULL,
  `時間` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `小農`
--

CREATE TABLE `小農` (
  `賣場編號` varchar(20) NOT NULL,
  `使用者帳號` varchar(255) NOT NULL,
  `地址` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `連絡電話` varchar(11) NOT NULL,
  `黑名單` varchar(255) NOT NULL,
  `使用者密碼` varchar(255) NOT NULL,
  `姓名` varchar(255) NOT NULL,
  `賣場圖片` longblob NOT NULL,
  `賣場簡介` varchar(255) NOT NULL,
  `交易訂單數` int(11) NOT NULL,
  `瀏覽次數` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `小農`
--

INSERT INTO `小農` (`賣場編號`, `使用者帳號`, `地址`, `Email`, `連絡電話`, `黑名單`, `使用者密碼`, `姓名`, `賣場圖片`, `賣場簡介`, `交易訂單數`, `瀏覽次數`) VALUES
('123456', 'qaz', 'aaa@bbb', 'ccc@ddd', '0912345678', '', '123', 'test1', '', 'qewqewqewqewqe', 0, 0),
('654321', 'qwe', 'aaa@bbb', 'ccc@ddd', '0912345678', '', '123', 'test1', '', 'qewqewqewqewqe', 0, 0);

-- --------------------------------------------------------

--
-- 資料表結構 `消費者`
--

CREATE TABLE `消費者` (
  `使用者帳號` varchar(255) NOT NULL,
  `姓名` varchar(255) NOT NULL,
  `使用者密碼` varchar(255) NOT NULL,
  `地址` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `連絡電話` int(11) NOT NULL,
  `購物車` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`購物車`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `消費者`
--

INSERT INTO `消費者` (`使用者帳號`, `姓名`, `使用者密碼`, `地址`, `Email`, `連絡電話`, `購物車`) VALUES
('qaz', '消費者1', '123', 'aaaaaa', 'sss@ddd', 123456789, '');

-- --------------------------------------------------------

--
-- 資料表結構 `產品資訊`
--

CREATE TABLE `產品資訊` (
  `產品編號` varchar(20) NOT NULL,
  `示意圖` varchar(255) NOT NULL,
  `價格` int(11) NOT NULL,
  `剩餘數量` int(30) NOT NULL,
  `是否有機` varchar(255) NOT NULL,
  `物種` varchar(255) NOT NULL,
  `每公斤單價` int(11) NOT NULL,
  `收成時間` varchar(255) NOT NULL,
  `名稱` varchar(255) NOT NULL,
  `產地` varchar(255) NOT NULL,
  `產品註明` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `產品資訊`
--

INSERT INTO `產品資訊` (`產品編號`, `示意圖`, `價格`, `剩餘數量`, `是否有機`, `物種`, `每公斤單價`, `收成時間`, `名稱`, `產地`, `產品註明`) VALUES
('1', '', 10, 0, '0', '', 0, '', '產品1', '', ''),
('2', '', 20, 0, '0', '', 0, '', '產品2', '', ''),
('3', '', 30, 100, '0', '', 20, '', '產品3', '', ''),
('4', '', 40, 100, '0', '', 20, '', '產品4', '', '');

-- --------------------------------------------------------

--
-- 資料表結構 `管理者`
--

CREATE TABLE `管理者` (
  `使用者帳號` int(11) NOT NULL,
  `使用者密碼` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `訂單`
--

CREATE TABLE `訂單` (
  `訂單編號` int(11) NOT NULL,
  `使用者帳號` varchar(255) NOT NULL,
  `訂單日期` varchar(255) NOT NULL,
  `購買者` varchar(255) NOT NULL,
  `訂單金額` int(11) NOT NULL,
  `配銷方式` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `購物車`
--

CREATE TABLE `購物車` (
  `使用者帳號` varchar(255) NOT NULL,
  `訂單編號` varchar(255) NOT NULL,
  `產品編號` varchar(20) NOT NULL,
  `數量` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `農產品`
--

CREATE TABLE `農產品` (
  `產品編號` int(11) NOT NULL,
  `產品號` int(11) NOT NULL,
  `名稱` varchar(255) NOT NULL,
  `限額公斤價` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `農產品`
--

INSERT INTO `農產品` (`產品編號`, `產品號`, `名稱`, `限額公斤價`) VALUES
(0, 0, '產品1', 0),
(1, 1, '產品2', 0);

-- --------------------------------------------------------

--
-- 資料表結構 `配銷方式`
--

CREATE TABLE `配銷方式` (
  `付款方式` varchar(255) NOT NULL,
  `地址` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `黑名單`
--

CREATE TABLE `黑名單` (
  `使用者帳號` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `個人賣場2`
--
ALTER TABLE `個人賣場2`
  ADD PRIMARY KEY (`項目`);

--
-- 資料表索引 `小農`
--
ALTER TABLE `小農`
  ADD PRIMARY KEY (`使用者帳號`) USING BTREE;

--
-- 資料表索引 `消費者`
--
ALTER TABLE `消費者`
  ADD PRIMARY KEY (`使用者帳號`);

--
-- 資料表索引 `產品資訊`
--
ALTER TABLE `產品資訊`
  ADD PRIMARY KEY (`產品編號`);

--
-- 資料表索引 `管理者`
--
ALTER TABLE `管理者`
  ADD PRIMARY KEY (`使用者帳號`);

--
-- 資料表索引 `訂單`
--
ALTER TABLE `訂單`
  ADD PRIMARY KEY (`訂單編號`);

--
-- 資料表索引 `購物車`
--
ALTER TABLE `購物車`
  ADD PRIMARY KEY (`訂單編號`),
  ADD KEY `使用者帳號` (`使用者帳號`),
  ADD KEY `產品編號` (`產品編號`);

--
-- 資料表索引 `農產品`
--
ALTER TABLE `農產品`
  ADD PRIMARY KEY (`產品號`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `個人賣場2`
--
ALTER TABLE `個人賣場2`
  MODIFY `項目` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `管理者`
--
ALTER TABLE `管理者`
  MODIFY `使用者帳號` int(11) NOT NULL AUTO_INCREMENT;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `購物車`
--
ALTER TABLE `購物車`
  ADD CONSTRAINT `a` FOREIGN KEY (`使用者帳號`) REFERENCES `消費者` (`使用者帳號`),
  ADD CONSTRAINT `購物車_ibfk_1` FOREIGN KEY (`產品編號`) REFERENCES `產品資訊` (`產品編號`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
