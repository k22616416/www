
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
