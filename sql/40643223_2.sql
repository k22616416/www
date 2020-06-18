-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- 主機: 127.0.0.1
-- 產生時間： 
-- 伺服器版本: 10.1.24-MariaDB
-- PHP 版本： 7.1.6

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
(1, '123456', 1, '產品資訊1', '', '宅配'),
(2, '654321', 2, '產品資訊2', '', ''),
(3, '123456', 3, '產品資訊3', '', ''),
(6, '123456', 6, '產品資訊6', '中國', '丟過去'),
(16, '654321', 8, '', '', ''),
(17, '123456', 4, '產品資訊3', '', ''),
(18, '123456', 5, '產品資訊5', '', ''),
(24, '0499fe', 19, '', '', '無');

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
('0499fe', 'nfucsie1', '0000000000', 'nfu@csie.com', '0912345678', '', 'nfucsie1', 'nfucsie1', NULL, '', '', 0, 17),
('123456', 'qaz', 'aaa@bbb', 'ccc@ddd', '0912345678', '', '123', '使用者1', NULL, '', 'qewqewqewqewqe', 0, 239),
('654321', 'qwe', 'aaa@bbb', 'ccc@ddd', '0912345678', '', '123', '使用者2', NULL, '', 'qewqewqewqewqe', 0, 57),
('789456', 'wsx', 'dsadwads', 'wsx@123', '', '', '123', '', NULL, '', 'sdwqadaf', 0, 5),
('urj647', 'admin304t', 'NFU', 'NFU@GMAIL', '', '', 'lab304t', '', NULL, '', '', 0, 15);

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

--
-- 資料表的匯出資料 `消費者`
--

INSERT INTO `消費者` (`使用者帳號`, `姓名`, `使用者密碼`, `地址`, `Email`, `連絡電話`) VALUES
('admin304u', 'Lab304U', 'lab304u', 'NFU', 'NFU@GMAIL', '056315000'),
('nfucsie1', 'nfucsie1', 'nfucsie1', '0000000000', 'nfu@csie.com', '0912345678'),
('qaz', '消費者1', '123', 'aaaaaa', 'sss@ddd', '123456789'),
('qwe', '使用者2', '123', 'aaa@bbb', 'ccc@ddd', '0912345678');

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
  `收成時間` varchar(255) NOT NULL,
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
(1, '', '', '斤', 10, 0, 1, '蘿蔔類', 10, '0618', '紅蘿蔔', '台灣', '123', '0000-00-00', 0),
(2, NULL, '', '斤', 20, 0, 0, '', 0, '', '產品2', '', '', '0000-00-00', 1),
(3, NULL, '', '斤', 30, 100, 0, '紅蘿蔔', 30, '0606', '產品3', '台灣', '123', '0000-00-00', 1),
(4, NULL, '', '斤', 40, 100, 1, '紅蘿蔔', 40, '0606', '產品4', '台灣', '123', '0000-00-00', 0),
(5, NULL, '', '斤', 50, 100, 0, '紅蘿蔔', 50, '0606', '產品5', '台灣', '123', '0000-00-00', 0),
(6, NULL, '', '斤', 60, 100, 1, '紅蘿蔔', 60, '0606', '產品6', '台灣', '123', '0000-00-00', 0),
(8, NULL, '', '斤', 20, 0, 1, '紅蘿蔔', 20, '0606', '產品名稱2', '台灣', '123', '0000-00-00', 1),
(19, '', '', '箱', 120, 1000, 0, '測試物種', 120, '測試時間', '測試1', '測試產地', '自己拿', '2020-06-18', 0);

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
-- 資料表的匯出資料 `訂單`
--

INSERT INTO `訂單` (`訂單編號`, `訂購者帳號`, `訂單日期`, `販售者帳號`, `賣場編號`, `購買清單`, `訂單金額`, `配銷方式`, `訂單狀態`) VALUES
(2, 'qaz', '2020-06-10 12:36:55', 'qaz', '123456', '[{\"CID\":\"1\",\"name\":\"u7522u54c11\",\"CCash\":\"10\",\"count\":\"1\"},{\"CID\":\"3\",\"name\":\"u7522u54c13\",\"CCash\":\"30\",\"count\":\"1\"},{\"CID\":\"4\",\"name\":\"u7522u54c14\",\"CCash\":\"40\",\"count\":\"1\"}]', 200, '面交', 1),
(3, 'qaz', '2020-06-10 12:42:08', 'qwe', '123456', '[{\"CID\":\"2\",\"name\":\"u7522u54c12\",\"CCash\":\"20\",\"count\":\"1\"}]', 300, '郵寄', 1),
(22, 'qwe', '2020-06-11 16:51:39', 'qaz', '123456', '[{\"CID\":\"1\",\"name\":\"u7522u54c11\",\"CCash\":\"10\",\"count\":\"1\"},{\"CID\":\"3\",\"name\":\"u7522u54c13\",\"CCash\":\"30\",\"count\":\"1\"},{\"CID\":\"4\",\"name\":\"u7522u54c14\",\"CCash\":\"40\",\"count\":\"1\"}]', 123, '面交', 1),
(23, 'qwe', '2020-06-11 16:51:39', 'qwe', '654321', '[{\"CID\":\"2\",\"name\":\"u7522u54c12\",\"CCash\":\"20\",\"count\":\"1\"}]', 123, '面交', 1),
(24, 'qwe', '2020-06-11 17:06:36', 'qaz', '123456', '[{\"CID\":\"1\",\"name\":\"u7522u54c11\",\"CCash\":\"10\",\"count\":\"1\"},{\"CID\":\"3\",\"name\":\"u7522u54c13\",\"CCash\":\"30\",\"count\":\"1\"},{\"CID\":\"4\",\"name\":\"u7522u54c14\",\"CCash\":\"40\",\"count\":\"1\"}]', 123, '面交', 1),
(25, 'qwe', '2020-06-11 17:06:36', 'qwe', '654321', '[{\"CID\":\"2\",\"name\":\"u7522u54c12\",\"CCash\":\"20\",\"count\":\"1\"}]', 123, '面交', 1),
(26, 'qwe', '2020-06-11 17:06:59', 'qaz', '123456', '[{\"CID\":\"1\",\"name\":\"u7522u54c11\",\"CCash\":\"10\",\"count\":\"1\"},{\"CID\":\"3\",\"name\":\"u7522u54c13\",\"CCash\":\"30\",\"count\":\"1\"},{\"CID\":\"4\",\"name\":\"u7522u54c14\",\"CCash\":\"40\",\"count\":\"1\"}]', 123, '面交', 2),
(27, 'qwe', '2020-06-11 17:06:59', 'qwe', '654321', '[{\"CID\":\"2\",\"name\":\"u7522u54c12\",\"CCash\":\"20\",\"count\":\"1\"}]', 123, '面交', 0),
(28, 'qwe', '2020-06-11 17:20:10', 'qaz', '123456', '[{\"CID\":\"1\",\"name\":\"u7522u54c11\",\"CCash\":\"10\",\"count\":\"1\"},{\"CID\":\"3\",\"name\":\"u7522u54c13\",\"CCash\":\"30\",\"count\":\"1\"},{\"CID\":\"4\",\"name\":\"u7522u54c14\",\"CCash\":\"40\",\"count\":\"1\"}]', 123, '面交', 2),
(29, 'qwe', '2020-06-11 17:20:10', 'qwe', '654321', '[{\"CID\":\"2\",\"name\":\"u7522u54c12\",\"CCash\":\"20\",\"count\":\"1\"}]', 123, '面交', 1),
(30, 'qaz', '2020-06-11 20:54:30', 'qaz', '123456', '[{\"CID\":\"1\",\"name\":\"%E7%94%A2%E5%93%811\",\"CCash\":\"10\",\"count\":\"1\"},{\"CID\":\"4\",\"name\":\"%E7%94%A2%E5%93%814\",\"CCash\":\"40\",\"count\":\"1\"},{\"CID\":\"3\",\"name\":\"%E7%94%A2%E5%93%813\",\"CCash\":\"30\",\"count\":\"1\"}]', 123, '面交', 2),
(48, 'nfucsie1', '2020-06-18 16:50:06', 'qaz', '123456', '[{\"CID\":\"3\",\"name\":\"%E7%94%A2%E5%93%813\",\"CCash\":\"30\",\"count\":\"1\"}]', 30, '郵寄', 1);

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

--
-- 資料表的匯出資料 `註冊審核`
--

INSERT INTO `註冊審核` (`編號`, `註冊身分類別`, `使用者帳號`, `使用者密碼`, `圖片`, `圖片編碼程式`, `聯絡電話`, `Email`, `住址`, `地圖經緯度`, `審核狀態`) VALUES
(1, 0, 'a123123123', 'a12121212121', NULL, '', '123123123', '123@123.com', '123123123', '', 2),
(2, 0, 'a123123123', 'a12121212121', NULL, '', '123123123', '123@123.com', '123123123', '', 2),
(3, 0, 'a123123123', 'a123123123', NULL, '', '123123123', '123@123.com', '123123123', '', 0),
(4, 0, 'a123123123', 'a123123123', NULL, '', '123123123', '123@123.com', '123123123', '', 0),
(6, 0, 'a123456', 'f123456789', NULL, '', '123456789', '123@123.com', '1212121212', '', 0),
(7, 1, 'nfucsie1', 'nfucsie1', NULL, '', '0912345678', 'nfu@csie.com', '0000000000', '', 1);

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
(1, '產品1', 0),
(2, '產品2', 0),
(3, '產品3', 0),
(4, '產品4', 0),
(5, '產品5', 60),
(6, '產品6', 60);

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

--
-- 資料表的匯出資料 `配銷方式`
--

INSERT INTO `配銷方式` (`項目`, `訂單編號`, `付款方式`, `配銷方式`, `配銷地址`, `匯款帳戶`) VALUES
(1, 29, '', '', '', ''),
(2, 28, '', '', '', ''),
(3, 27, '', '', '', ''),
(4, 26, '', '', '', ''),
(5, 26, '', '', '', ''),
(12, 48, '', '郵寄', '213213213213133', '11111111111111');

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
  MODIFY `項目` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- 使用資料表 AUTO_INCREMENT `產品資訊`
--
ALTER TABLE `產品資訊`
  MODIFY `產品編號` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- 使用資料表 AUTO_INCREMENT `訂單`
--
ALTER TABLE `訂單`
  MODIFY `訂單編號` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- 使用資料表 AUTO_INCREMENT `註冊審核`
--
ALTER TABLE `註冊審核`
  MODIFY `編號` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- 使用資料表 AUTO_INCREMENT `配銷方式`
--
ALTER TABLE `配銷方式`
  MODIFY `項目` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
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
