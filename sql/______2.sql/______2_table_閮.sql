
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
