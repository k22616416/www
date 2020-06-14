<?php

function ManagementSearchLayout()
{
}
function ManagementStoreInfoLayout($data)
{
    echo '
    <div style="display: flex;">
    <table class="StoreInfoTable" rules="all" id="storeInfoTemplate" style="width:550px;">
    <input type="hidden" name="storeNumber" value="' . $data['賣場編號'] . '">
    <form id="entryStore" method="post" action="storePage.php">
    <tbody>
    <tr>
    <td rowspan="2" style="width:70px;">';
    if ($data['示意圖'] != null)
        echo '<img id="previewImg"src="data:' . $data['圖片編碼格式'] . ';base64,' . $data['示意圖'] . '" />';
    else
        echo '<img id="previewImg"src="Image/carrot.png" />';
    echo '<button class="StoreHrefText">進入此賣場</button>
    </td>
    <td style="width:auto;font-size:14px;">使用者帳號：<br><b>' . $data['使用者帳號'] . '</b></td>
    <td style="width:auto;font-size:14px;">賣場編號：<br><b>' . $data['賣場編號'] . '</b></td>
    <td style="width:100px;"><span style="font-size:14px;">瀏覽次數：<br>' . $data['瀏覽次數'] . '</span></td>
    <td style="width:100px;"><span style="font-size:14px;">已成交訂單數：<br>' . $data['交易訂單數'] . '</span></td>
    </tr>
    <tr>
    <td colspan="3">農場簡介：' . $data['賣場簡介'] . '</td>
    <td><button class="entryStoreButton" storeIndex="123456" onclick="if(!storeOrderInfo(' . $data['賣場編號'] . ')){return false;}">查看該賣場<br>訂單資訊</button></td>
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
    <form name="orderDetail" id="orderDetail" method="post" action="managementPage.php?method=2">
    <tbody>
    <tr>
    <td style="width:295px;">
    訂購者帳號:' . $sqlArray['訂購者帳號'] . '
    </td>
    <td>
    訂單總金額:<span style="color:red">' . $sqlArray['訂單金額'] . '</span>
    </td>
    </tr>
    <tr>
    <td style="width:295px;">
    訂單編號:' . $sqlArray['訂單編號'] . '
    </td>
    <td>
    訂單建立日期:' . $sqlArray['訂單日期'] . '
    </td>
    </tr>
    <tr>
    <td style="width:295px;">
    購買者聯絡電話:' . $sqlArray['連絡電話'] . '
    </td>
    <td>
    訂單狀態:<span style="color:red">' . orderStatus($sqlArray['訂單狀態']) . '</span>
    <form name="orderDetail" id="orderDetail" method="post" action="managementPage.php?method=7">
    <input type="hidden" name="orderIndex" value="' . $sqlArray['訂單編號'] . '" />
    <input type="radio" name="orderStatus" value="1">通過</input>
    <input type="radio" name="orderStatus" value="2">未通過</input>
    <button type="submit" class="statusSubmit" name="statusSubmit" id="statusSubmit">送出</button>
    </form>
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
