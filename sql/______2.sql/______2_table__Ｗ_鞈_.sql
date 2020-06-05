
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
