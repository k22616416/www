
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
