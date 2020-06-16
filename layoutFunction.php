<?php

function ManagementSearchLayout()
{
}
function ManagementStoreInfoLayout($data)
{
    echo '
    <div style="display: flex;">
    <table class="StoreInfoTable" rules="all" id="storeInfoTemplate" style="width:550px;">
    <form id="entryStore" method="post" action="storePage.php">
    <input type="hidden" name="storeNumber" value="' . $data['賣場編號'] . '">
    <tbody>
    <tr>
    <td rowspan="2" style="width:70px;">';
    if ($data['示意圖'] != null)
        echo '<img id="previewImg"src="data:' . $data['圖片編碼格式'] . ';base64,' . $data['示意圖'] . '" />';
    else
        echo '<img id="previewImg"src="Image/user.png" />';
    echo '<button type="submit" class="StoreHrefText" name="entryStore">進入此賣場</button>
    </td>
    <td style="width:auto;font-size:14px;">使用者帳號：<br><b>' . $data['使用者帳號'] . '</b></td>
    <td style="width:auto;font-size:14px;">賣場編號：<br><b>' . $data['賣場編號'] . '</b></td>
    <td style="width:100px;"><span style="font-size:14px;">瀏覽次數：<br>' . $data['瀏覽次數'] . '</span></td>
    <td style="width:100px;"><span style="font-size:14px;">已成交訂單數：<br>' . $data['交易訂單數'] . '</span></td>
    </tr>
    <tr>
    <td colspan="3">農場簡介：' . $data['賣場簡介'] . '</td>
    <td><button class="entryStoreButton" storeIndex="' . $data['賣場編號'] . '" onclick="if(!storeOrderInfo(' . $data['賣場編號'] . ')){return false;}">查看該賣場<br>訂單資訊</button></td>
    </tr>
    </tbody>
    </form>
    </table>
    <div class="option">
    <input type="checkbox" class="storeCheckbox" onclick="storeMethod(this,' . $data['賣場編號'] . ')" />
    </div>
    </div>';
}
function orderDetailLayout($sqlArray)
{
    echo '<table class="StoreInfoTable" border="1px" style="width:590px; border-collapse:collapse; ">
    <form name="orderDetail" id="orderDetail" method="post" action="orderOperationg.php">
        <tbody>
            <tr style="height:30px;">
                <td style="width:295px;">
                    訂購者帳號:' . $sqlArray['訂購者帳號'] . '
                </td>
                <td>
                    訂單總金額:<span style="color:red">' . $sqlArray['訂單金額'] . '</span>
                </td>
            </tr>
            <tr style="height:30px;">
                <td style="width:295px;">
                    訂單編號:' . $sqlArray['訂單編號'] . '
                </td>
                <td>
                    訂單建立日期:' . $sqlArray['訂單日期'] . '
                </td>
            </tr>
            <tr style="height:30px;">
                <td style="width:295px;">
                    購買者聯絡電話:' . $sqlArray['連絡電話'] . '
                </td>
                <td>
                    訂單狀態:<span style="color:red">' . orderStatus($sqlArray['訂單狀態']) . '</span><br>
                    
                    <input type="hidden" name="orderIndex0" value="' . $sqlArray['訂單編號'] . '" />';
    if ($sqlArray['訂單狀態'] == 0) {
        echo '
                <input type="hidden" name="orderLength" value="1" />
                <input type="radio" name="orderStatus0" value="1">通過</input>
                <input type="radio" name="orderStatus0" value="2">未通過</input>
                <button type="submit" class="statusSubmit" name="statusSubmit" id="statusSubmit">送出</button>';
    }
    echo '
                    
                </td>
            </tr>
        </tbody>
        </form>
    </table>';
}
function orderList($sqlArray)
{
    echo '
    <div style="display: flex;">
    <table class="StoreInfoTable" id="' . $sqlArray['訂單編號'] . '" border="1px" style="width:550px; border-collapse:collapse; ">
                            <form name="orderDetail" id="orderDetail" method="post" action="managementPage.php?method=7">
                                <tbody>
                                    <tr>
                                        <td>
                                            訂購者帳號:' . $sqlArray['訂購者帳號'] . '
                                        </td>
                                        <td>
                                            訂單總金額:<span style="color:red">' . $sqlArray['訂單金額'] . '</span>
                                        </td>
                                        <td rowspan="3">
                                            <input type="hidden" name="orderIndex" value="' . $sqlArray['訂單編號'] . '" />
                                            <p style="text-align:center; width:50px; margin:auto auto auto auto;"><button class="detailButton" type="submit">詳<br>細<br>資<br>訊</button></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            訂單編號:' . $sqlArray['訂單編號'] . '
                                        </td>
                                        <td>
                                            訂單建立日期:' . $sqlArray['訂單日期'] . '
                                        </td>
            
                                    </tr>
                                    <tr>
                                        <td>
                                            購買者聯絡電話:' . $sqlArray['連絡電話'] . '
                                        </td>
                                        <td>
                                            訂單狀態:<span style="color:red">' . orderStatus($sqlArray['訂單狀態']) . '</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </form>
                        </table>
                        <div class="option">
                            <input type="checkbox" class="orderCheckbox" onclick="orderMethod(this)"  value="' . $sqlArray['訂單編號'] . '"/>
                        </div>
                        </div>
                        ';
}
function ProductsLayout1()
{
    echo '<table class="StoreInfoTable" rules="all" id="productTable" style="width:590px; height:auto;">
    <tbody>
        <tr style="height:50px; background-color:#82D900;font-weight: bolder;">
            <td width="40" align="center">
                編號
            </td>
            <td>
                名稱
            </td>
            <td>
                限制單價上限<br>
                (每斤n元/每個n元/....)
            </td>
            <td width="40" align="center">
                選取
            </td>
            <td width="40" align="center">
                刪除
            </td>
        </tr>';
}
function ProductsLayout2($sqlArray)
{
    echo '          <form name="product" action="">
                        <tr class="trbg" name="trbg' . $sqlArray['產品編號'] . '" style=";">
                            <td align="center">
                                <input type="hidden" name=productIndex value="' . $sqlArray['產品編號'] . '" />
                                ' . $sqlArray['產品編號'] . '
                            </td>
                            <td>
                                <input type="text" value="' . $sqlArray['名稱'] . '" name="productName' . $sqlArray['產品編號'] . '" style="width: 80px;" onchange="productMethod(' . $sqlArray['產品編號'] . ')" />
                            </td>
                            <td>
                                <input type="text" value="' . $sqlArray['限額公斤價'] . '" name="productCash' . $sqlArray['產品編號'] . '" style="width: 60px;" onchange="productMethod(' . $sqlArray['產品編號'] . ')" />元
                            </td>
                            <td align="center">
                                <input type="checkbox" class="storeCheckbox" name="productSelect' . $sqlArray['產品編號'] . '" onclick="productMethod(' . $sqlArray['產品編號'] . ',this)" />
                            </td>
                            <td align="center">
                                <button class="addProductInfo" onclick="if(!deleteProduct(' . $sqlArray['產品編號'] . ')){return false;}">
                                    <img src="Image/del.png" style="height:20px; width:20px;">
                                </button>
                            </td>
                        </tr>
                    </form>


';
}
function ProductsLayout3()
{
    echo '<tr>
            <td colspan="5" align="center" style="height:35px; background-color:#FFFFFF;">
                <button class="addProductInfo" onclick="if(!addProduct()){return false;}">
                    <img src="Image/add.png" style="height:25px; width:25px;">
                </button>
            </td>
        </tr>
        </tbody>
        </table>
';
}
function checkAddProduct($conn)
{
    if (isset($_POST['addProduct'])) {
        $cmd = 'SELECT COUNT(`產品編號`) AS `總數` FROM `農產品` WHERE 1';
        $sqlData = mysqli_query($conn, $cmd);
        $sqlArray = mysqli_fetch_array($sqlData, MYSQLI_ASSOC);
        $cmd2 = 'INSERT INTO `農產品`(`產品編號`, `名稱`, `限額公斤價`) VALUES ("' . ($sqlArray['總數'] + 1) . '","產品名稱","0");';
        $sqlData = mysqli_query($conn, $cmd2);
        if (!$sqlData) echo ("Error");
        unset($_POST['addProduct']);
    }
}
function DeleteProduct($conn)
{
    if (isset($_POST['deleteProduct'])) {
        $cmd = 'DELETE FROM `農產品` WHERE `產品編號`=' . $_POST['deleteProduct'] . '';
        $sqlData = mysqli_query($conn, $cmd);
        if (!$sqlData) echo ("Error");
        unset($_POST['deleteProduct']);
    }
}
function registeredLayout($sqlArray)
{
    echo '
    <table class="StoreInfoTable" rules="all" id="storeInfoTemplate" style="width:550px;">
                <form id="register" method="post" action="registerOperating.php">
                    <tbody>
                        <tr>
                            <td rowspan="3" style="width:70px;">';
    if ($sqlArray['圖片'] != null)
        echo '<img id="previewImg"src="data:' . $sqlArray['圖片編碼格式'] . ';base64,' . $sqlArray['圖片'] . '" />';
    else
        echo '<img id="previewImg" src="Image/user.png" />';
    echo '<button class="StoreHrefText">進入此賣場</button>
                            </td>
                            <td style="width:auto;font-size:14px;">使用者帳號：<br><b>' . $sqlArray['使用者帳號'] . '</b></td>
                            <td colspan="2" style="width:auto;font-size:14px;">連絡電話：<br><b>' . $sqlArray['聯絡電話'] . '</b></td>
                        <tr>
                            <td colspan="3" style="width:100px;"><span style="font-size:14px;">地址：<br>' . $sqlArray['住址'] . '</span></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="width:100px;"><span style="font-size:14px;">農地經緯度：<br>' . $sqlArray['地圖經緯度'] . '</span></td>
                        </tr>
                        </tr>
                        <tr>
                            <input type="hidden" name="registerIndex" value="' . $sqlArray['編號'] . '" />
                            <td align="left" colspan="2">註冊身分：<span style="color:#FF0000"><b>' . ($sqlArray['註冊身分類別'] == 0 ? '消費者' : '小農') . '</b></span></td>
                            <td style="width:80px;"><button class="passButton" name="pass" onclick="">通過</button></td>
                            <td style="width:80px;"><button class="blockButton" name="block" onclick="">拒絕</button></td>
                        </tr>
                    </tbody>
                </form>
            </table>
    
    ';
}


function orderStatus($x)
{
    switch ($x) {
        case 0:
            return '審核中';
        case 1:
            return '通過';
        case 2:
            return '未通過';
        default:
            return null;
    }
}
