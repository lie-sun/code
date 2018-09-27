<?php

require_once "db.php";
function excelData($datas, $titlename, $title, $filename)
{
    $str = "<html xmlns:o=\"urn:schemas-microsoft-com:office:office\"\r\nxmlns:x=\"urn:schemas-microsoft-com:office:excel\"\r\nxmlns=\"http://www.w3.org/TR/REC-html40\">\r\n<head>\r\n<meta http-equiv=Content-Type content=\"text/html; charset=utf-8\">\r\n</head>\r\n<body>";
    $str .= "<table border=1><thead>" . $titlename . "</thead>";
    $str .= $title;
    foreach ($datas as $key => $rt) {
        $str .= "<tr>";
        foreach ($rt as $k => $v) {
            $str .= "<td style='vnd.ms-excel.numberformat:@'>$v</td>";
        }
        $str .= "</tr>\n";
    }
    $str .= "</table></body></html>";
    header("Content-type:application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=" . $filename);
    exit($str);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    exit();
}
$sql_today = "SELECT fpdm,fphm,kprq,code as codes,xfMc,xfNsrsbh,xfContact,xfbank,gfMc,gfNsrsbh,gfContact,gfbank,taxamount,taxRate,unit,priceUnit,amount,priceSum,sumamount,name,spec,remark from record where id = " . $id;
$res_today = $db->query($sql_today)->fetchAll(PDO::FETCH_ASSOC);
$dataResult = $res_today;
$headTitle = $dataResult[0]['gfMc'] . $dataResult[0]['kprq'];
$title = $dataResult[0]['gfMc'];
$headtitle = "<tr style='height: 40px'>
<th style='font-weight:600;font-size:14px;'>发票代码</th>
<th style='font-weight:600;font-size:14px;'>发票号码</th>
<th style='font-weight:600;font-size:14px;'>开票日期</th>
<th style='font-weight:600;font-size:14px;'>校验码</th>
<th style='font-weight:600;font-size:14px;'>销方名称</th>
<th style='font-weight:600;font-size:14px;'>销方纳税人识别号</th>
<th style='font-weight:600;font-size:14px;'>销方地址电话</th>
<th style='font-weight:600;font-size:14px;'>销方银行</th>
<th style='font-weight:600;font-size:14px;'>购方名称</th>
<th style='font-weight:600;font-size:14px;'>购方纳税人识别号</th>
<th style='font-weight:600;font-size:14px;'>购方址电话</th>
<th style='font-weight:600;font-size:14px;'>购方银行</th>
<th style='font-weight:600;font-size:14px;'>税额</th>
<th style='font-weight:600;font-size:14px;'>税率</th>
<th style='font-weight:600;font-size:14px;'>单位</th>
<th style='font-weight:600;font-size:14px;'>单价</th>
<th style='font-weight:600;font-size:14px;'>数量</th>
<th style='font-weight:600;font-size:14px;'>总价</th>
<th style='font-weight:600;font-size:14px;'>价税合计</th>
<th style='font-weight:600;font-size:14px;'>服务名称</th>
<th style='font-weight:600;font-size:14px;'>规格</th>
<th style='font-weight:600;font-size:14px;'>备注</th>
</tr>";
$titlename = "<tr style='font-size: 17px;text-align: center;font-weight: 600;height: 50px;'>
                 <th colspan='22'>$headTitle</th>
              </tr>";
$filename = $headTitle . ".xls";
$file = excelData($dataResult, $titlename, $headtitle, $filename);
echo $file;
