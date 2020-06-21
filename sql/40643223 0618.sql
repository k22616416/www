-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- 主機: 127.0.0.1
-- 產生時間： 2020 年 06 月 18 日 17:41
-- 伺服器版本: 10.1.24-MariaDB
-- PHP 版本： 7.0.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `40643223`
--

-- --------------------------------------------------------

--
-- 資料表結構 `個人賣場2`
--

CREATE TABLE `個人賣場2` (
  `項目` int(11) NOT NULL,
  `賣場編號` varchar(20) NOT NULL,
  `產品編號` int(20) NOT NULL,
  `產品資訊` varchar(255) NOT NULL,
  `願意配銷地點` varchar(255) NOT NULL,
  `配銷方式` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 資料表的匯出資料 `個人賣場2`
--

INSERT INTO `個人賣場2` (`項目`, `賣場編號`, `產品編號`, `產品資訊`, `願意配銷地點`, `配銷方式`) VALUES
(1, 'dec9c9', 1, '', '全台', ''),
(2, 'dec9c9', 2, '', '全台', '郵寄、面交'),
(3, 'dec9c9', 3, '', '全台', ''),
(4, 'dec9c9', 4, '', '全台', '郵寄、面交'),
(5, 'dec9c9', 5, '', '全台', '郵寄、面交'),
(6, 'dec9c9', 6, '', '全台', '郵寄、面交'),
(7, '236c56', 7, '', '雲林', '面交'),
(8, '236c56', 8, '', '雲林', '面交'),
(9, '236c56', 9, '', '雲林', '面交'),
(10, '236c56', 9, '', '雲林', '面交'),
(11, '236c56', 10, '', '雲林', '面交'),
(12, '236c56', 11, '', '雲林', '面交'),
(13, '236c56', 12, '', '雲林', '面交'),
(14, '236c56', 13, '', '雲林', '面交');

-- --------------------------------------------------------

--
-- 資料表結構 `小農`
--

CREATE TABLE `小農` (
  `賣場編號` varchar(20) NOT NULL,
  `使用者帳號` varchar(30) NOT NULL,
  `地址` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `連絡電話` varchar(11) NOT NULL,
  `黑名單` varchar(255) NOT NULL,
  `使用者密碼` varchar(30) NOT NULL,
  `姓名` varchar(11) NOT NULL,
  `賣場圖片` blob,
  `圖片編碼格式` varchar(50) NOT NULL,
  `賣場簡介` varchar(255) NOT NULL,
  `交易訂單數` int(30) NOT NULL,
  `瀏覽次數` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 資料表的匯出資料 `小農`
--

INSERT INTO `小農` (`賣場編號`, `使用者帳號`, `地址`, `Email`, `連絡電話`, `黑名單`, `使用者密碼`, `姓名`, `賣場圖片`, `圖片編碼格式`, `賣場簡介`, `交易訂單數`, `瀏覽次數`) VALUES
('236c56', 'nfucsie02', '', '', '0912345678', '', 'nfucsie02', 'nfucsie02', NULL, '', '嚴選高品質農產品，不使用農藥栽種', 0, 3),
('dec9c9', 'nfucsie01', '', '', '0912345678', '', 'nfucsie01', 'nfucsie01', NULL, '', '販售各式農產，都可以參考看看喔', 0, 3);

--
-- 觸發器 `小農`
--
DELIMITER $$
CREATE TRIGGER `rand` BEFORE INSERT ON `小農` FOR EACH ROW SET new.`賣場編號` = (substring(MD5(RAND()),1,6))
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- 資料表結構 `消費者`
--

CREATE TABLE `消費者` (
  `使用者帳號` varchar(30) NOT NULL,
  `姓名` varchar(30) NOT NULL,
  `使用者密碼` varchar(30) NOT NULL,
  `地址` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `連絡電話` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `產品資訊`
--

CREATE TABLE `產品資訊` (
  `產品編號` int(20) NOT NULL,
  `示意圖` blob,
  `圖片編碼格式` varchar(30) NOT NULL,
  `單位` varchar(10) NOT NULL DEFAULT '斤',
  `價格` int(11) NOT NULL,
  `剩餘數量` int(30) NOT NULL,
  `是否有機` int(5) NOT NULL,
  `物種` varchar(255) NOT NULL,
  `每公斤單價` int(11) NOT NULL,
  `收成時間` date NOT NULL,
  `名稱` varchar(255) NOT NULL,
  `產地` varchar(255) NOT NULL,
  `產品註明` varchar(255) NOT NULL,
  `上架日期` date DEFAULT NULL,
  `審核狀態` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 資料表的匯出資料 `產品資訊`
--

INSERT INTO `產品資訊` (`產品編號`, `示意圖`, `圖片編碼格式`, `單位`, `價格`, `剩餘數量`, `是否有機`, `物種`, `每公斤單價`, `收成時間`, `名稱`, `產地`, `產品註明`, `上架日期`, `審核狀態`) VALUES
(1, '', '', '顆', 15, 100, 0, '蔬菜類', 15, '2020-06-18', '番茄', '台東', '', '2020-06-18', 0),
(2, NULL, '', '顆', 35, 200, 1, '葉菜類', 35, '2020-06-18', '高麗菜', '台東', '', '2020-06-18', 0),
(3, '', '', '把', 30, 150, 0, '葉菜類', 30, '2020-06-18', '芹菜', '台東', '', '2020-06-18', 0),
(4, NULL, '', '把', 30, 150, 0, '葉菜類', 30, '2020-06-21', '空心菜', '彰化', '', '2020-06-18', 1),
(5, NULL, '', '顆', 45, 100, 1, '葉菜類', 45, '2020-06-18', '茼蒿', '彰化', '', '2020-06-18', 0),
(6, NULL, '', '把', 35, 200, 0, '十字花科類', 35, '2020-06-18', '大白菜', '彰化', '', '2020-06-18', 1),
(7, NULL, '', '把', 30, 100, 0, '蔥蒜類', 30, '2020-06-18', '大蔥', '雲林', '', '2020-06-18', 1),
(8, NULL, '', '把', 20, 150, 0, '蔥蒜類', 20, '2020-06-18', '韭菜', '雲林', '', '2020-06-18', 1),
(9, NULL, '', '顆', 10, 100, 1, '蔥蒜類', 10, '2020-06-18', '洋蔥', '雲林', '', '2020-06-18', 1),
(10, NULL, '', '斤', 30, 200, 0, '莖菜類', 30, '2020-06-18', '甘蔗', '屏東', '', '2020-06-18', 1),
(11, NULL, '', '把', 30, 140, 0, '莖菜類', 30, '2020-06-18', '筊白筍', '屏東', '', '2020-06-18', 1),
(12, NULL, '', '斤', 20, 300, 0, '瓜果類', 20, '2020-06-29', '小黃瓜', '屏東', '', '2020-06-18', 1),
(13, NULL, '', '顆', 55, 240, 0, '瓜果類', 55, '2020-06-18', '南瓜', '屏東', '', '2020-06-18', 0);

-- --------------------------------------------------------

--
-- 資料表結構 `管理者`
--

CREATE TABLE `管理者` (
  `使用者帳號` varchar(30) NOT NULL,
  `使用者密碼` varchar(30) NOT NULL,
  `姓名` varchar(20) NOT NULL DEFAULT '管理員'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `管理者`
--

INSERT INTO `管理者` (`使用者帳號`, `使用者密碼`, `姓名`) VALUES
('admin304', 'lab304', '管理員2'),
('NFU_PM01', '40643223', '管理員1');

-- --------------------------------------------------------

--
-- 資料表結構 `訂單`
--

CREATE TABLE `訂單` (
  `訂單編號` int(11) NOT NULL,
  `訂購者帳號` varchar(30) NOT NULL,
  `訂單日期` datetime NOT NULL,
  `販售者帳號` varchar(30) NOT NULL,
  `賣場編號` varchar(30) NOT NULL,
  `購買清單` varchar(1000) NOT NULL,
  `訂單金額` int(11) NOT NULL,
  `配銷方式` varchar(30) NOT NULL,
  `訂單狀態` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 觸發器 `訂單`
--
DELIMITER $$
CREATE TRIGGER `DelTransPort` BEFORE DELETE ON `訂單` FOR EACH ROW DELETE FROM `配銷方式` WHERE `配銷方式`.`訂單編號` = old.`訂單編號`
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `addTransPort` AFTER INSERT ON `訂單` FOR EACH ROW INSERT INTO `配銷方式`(`訂單編號`) VALUES (new.`訂單編號`)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- 資料表結構 `註冊審核`
--

CREATE TABLE `註冊審核` (
  `編號` int(11) NOT NULL,
  `註冊身分類別` int(11) NOT NULL,
  `使用者帳號` varchar(30) NOT NULL,
  `使用者密碼` varchar(30) NOT NULL,
  `圖片` blob,
  `圖片編碼程式` varchar(30) NOT NULL,
  `聯絡電話` varchar(20) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `住址` varchar(50) NOT NULL,
  `地圖經緯度` varchar(255) NOT NULL,
  `審核狀態` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `農產品`
--

CREATE TABLE `農產品` (
  `產品編號` int(20) NOT NULL,
  `名稱` varchar(255) NOT NULL,
  `限額公斤價` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 資料表的匯出資料 `農產品`
--

INSERT INTO `農產品` (`產品編號`, `名稱`, `限額公斤價`) VALUES
(1, '產品名稱', 0),
(2, '產品名稱', 0),
(3, '產品名稱', 0),
(4, '產品名稱', 0),
(5, '產品名稱', 0);

-- --------------------------------------------------------

--
-- 資料表結構 `配銷方式`
--

CREATE TABLE `配銷方式` (
  `項目` int(11) NOT NULL,
  `訂單編號` int(20) NOT NULL,
  `付款方式` varchar(255) NOT NULL,
  `配銷方式` varchar(30) NOT NULL,
  `配銷地址` varchar(255) NOT NULL,
  `匯款帳戶` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `黑名單`
--

CREATE TABLE `黑名單` (
  `使用者帳號` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `個人賣場2`
--
ALTER TABLE `個人賣場2`
  ADD PRIMARY KEY (`項目`),
  ADD KEY `產品編號` (`產品編號`);

--
-- 資料表索引 `小農`
--
ALTER TABLE `小農`
  ADD PRIMARY KEY (`賣場編號`);

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
  ADD PRIMARY KEY (`訂單編號`),
  ADD KEY `販售者帳號` (`販售者帳號`),
  ADD KEY `訂購者帳號` (`訂購者帳號`);

--
-- 資料表索引 `註冊審核`
--
ALTER TABLE `註冊審核`
  ADD PRIMARY KEY (`編號`);

--
-- 資料表索引 `農產品`
--
ALTER TABLE `農產品`
  ADD PRIMARY KEY (`產品編號`);

--
-- 資料表索引 `配銷方式`
--
ALTER TABLE `配銷方式`
  ADD PRIMARY KEY (`項目`),
  ADD KEY `訂單編號` (`訂單編號`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `個人賣場2`
--
ALTER TABLE `個人賣場2`
  MODIFY `項目` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- 使用資料表 AUTO_INCREMENT `產品資訊`
--
ALTER TABLE `產品資訊`
  MODIFY `產品編號` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- 使用資料表 AUTO_INCREMENT `訂單`
--
ALTER TABLE `訂單`
  MODIFY `訂單編號` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `註冊審核`
--
ALTER TABLE `註冊審核`
  MODIFY `編號` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `配銷方式`
--
ALTER TABLE `配銷方式`
  MODIFY `項目` int(11) NOT NULL AUTO_INCREMENT;
--
-- 已匯出資料表的限制(Constraint)
--

--
-- 資料表的 Constraints `個人賣場2`
--
ALTER TABLE `個人賣場2`
  ADD CONSTRAINT `個人賣場2_ibfk_1` FOREIGN KEY (`產品編號`) REFERENCES `產品資訊` (`產品編號`);

--
-- 資料表的 Constraints `配銷方式`
--
ALTER TABLE `配銷方式`
  ADD CONSTRAINT `配銷方式_ibfk_1` FOREIGN KEY (`訂單編號`) REFERENCES `訂單` (`訂單編號`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
