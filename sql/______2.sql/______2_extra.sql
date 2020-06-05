
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
