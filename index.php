<?php
header("Content-Type: text/html;charset=utf-8");
require_once "db.php";

class Code
{

    function abc()
    {
        global $db;
        $fpdm = $_GET['fpdm'];//发票代码
        $fphm = $_GET['fphm'];//发票号码
        $kprq = $_GET['kprq'];//开票日期
        $checkCode = $_GET['checkCode'];//校验码后6位
        $noTaxAmount = $_GET['noTaxAmount'];//不含税金额
        $host = "https://fapiao.market.alicloudapi.com";
        $path = "/invoice/query";
        $method = "GET";
        $appcode = "93acc0b7137943c5b542ea8c3c917da7";
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);
        $querys = "fpdm=$fpdm&fphm=$fphm&kprq=$kprq&checkCode=$checkCode&noTaxAmount=$noTaxAmount";
        $bodys = "";
        $url = $host . $path . "?" . $querys;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        if (1 == strpos("$" . $host, "https://")) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        $sql = "select * from record where fpdm = '" . $_GET['fpdm'] . "' and fphm = '" . $_GET['fphm'] . "'";
        $resultNum = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        $rowCount = count($resultNum);
        if ($rowCount > 0) {
            echo json_encode($resultNum[0]);
        } else {
            $json = curl_exec($curl);
            $data = json_decode($json, true);
            if (!$data) {
                echo "没有获取到数据";
                exit();
            } else {
                self::saveData($data);
            }
        }
    }

    /**
     * 存储数据
     * @param $data
     */
    function saveData($data)
    {
        global $db;
        $fpdm = $data['fpdm'];
        $fphm = $data['fphm'];
        $kprq = $data['kprq'];
        $code = $data['code'];
        $fplx = $data['fplx'];
        $xfMc = $data['xfMc'];
        $xfNsrsbh = $data['xfNsrsbh'];
        $xfContact = $data['xfContact'];
        $xfBank = $data['xfBank'];
        $gfMc = $data['gfMc'];
        $gfNsrsbh = $data['gfNsrsbh'];
        $gfContact = $data['gfContact'];
        $gfBack = isset($data['gfBack']) ? $data['gfBack'] : "";
        $del = $data['del'];
        $taxamount = $data['taxamount'];
        $sumamount = $data['sumamount'];
        $taxRate = isset($data['goodsData'][0]['taxRate']) ? $data['goodsData'][0]['taxRate'] : "";
        $remark = $data['remark'];
        $amount = $data['goodsData'][0]['amount'];
        $name = $data['goodsData'][0]['name'];
        $unit = $data['goodsData'][0]['unit'];
        $priceUnit = $data['goodsData'][0]['priceUnit'];
        $priceSum = $data['goodsData'][0]['priceSum'];
        $taxSum = $data['goodsData'][0]['taxSum'];
        $spec = $data['goodsData'][0]['spec'];
        $isql = "insert into record(fpdm,fphm,kprq,code,fplx,xfMc,xfNsrsbh,xfContact,xfBank,gfMc,gfNsrsbh,gfContact,gfBank,del,taxamount,sumamount,taxRate,remark,amount,unit,priceUnit,priceSum,taxSum,name,spec) values ('$fpdm','$fphm','$kprq','$code','$fplx','$xfMc','$xfNsrsbh','$xfContact','$xfBank','$gfMc','$gfNsrsbh','$gfContact','$gfBack','$del','$taxamount','$sumamount','$taxRate','$remark','$amount','$unit','$priceUnit','$priceSum','$taxSum','$name','$spec')";
        $result = $db->exec($isql);
        if ($result) {
            echo json_encode($data);
        }
    }

}

$aa = new Code();
$aa->abc();
