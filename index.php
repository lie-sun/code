<?php
header('Content-Type:text/json;charset=utf-8');

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
        $appcode = "1ec690ed301f422ab0afe2bb8a67f651";
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
        $json = curl_exec($curl);
        $data = json_decode($json, true);

//        echo $json;


        $sql = "select count(id) from record where fpdm = '" . $_GET['fpdm'] . "' and fphm = '" . $_GET['fphm'] . "'";
        echo $sql;
        $resultNum = $db->query($sql)->fetchColumn();

        echo $resultNum;

        exit();

        if ($resultNum > 0) {

        } else {
            $json = curl_exec($curl);
            $data = json_decode($json, true);
            self::saveData($data);
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
        $namess = $data['goodsData'][0]['name'];
        $unit = $data['goodsData'][0]['unit'];
        $priceUnit = $data['goodsData'][0]['priceUnit'];
        $priceSum = $data['goodsData'][0]['priceSum'];
        $taxSum = $data['goodsData'][0]['taxSum'];
        $spec = $data['goodsData'][0]['spec'];
        $isql = "insert into record(fpdm,fphm,kprq,code,fplx,xfMc,xfNsrsbh,xfContact,xfBank,gfMc,gfNsrsbh,gfContact,gfBank,del,taxamount,sumamount,taxRate,remark,amount,namess,unit) values ('$fpdm','$fphm','$kprq','$code','$fplx','$xfMc','$xfNsrsbh','$xfContact','$xfBank','$gfMc','$gfNsrsbh','$gfContact','$gfBack','$del','$taxamount','$sumamount','$taxRate','$remark','$amount','$namess','$unit','')";


//        echo($isql);

        $result = $db->exec($isql);
        var_dump($result);
    }

    /**
     * 查询数据
     */
    function select()
    {
        global $db;
        $ssql = "select count(id) from record where fpdm = " . $_GET['fpdm'] . " and fphm = " . $_GET['fphm'];
        $num = $db->query($ssql)->fetchColumn();
        if ($num > 0) {
            echo json_encode(array(
                'code' => 0,
                'data' => 1,
                'msg' => 'success',
                'remark' => "无"

            ));
        } else {
            echo json_encode(array(
                'code' => 0,
                'data' => 0,
                'msg' => 'success',
                'remark' => "无"

            ));
        }
    }
}

$aa = new Code();
$aa->abc();
