<?php
/**
 * Created by PhpStorm.
 * User: 14665
 * Date: 2018/9/26
 * Time: 17:12
 */
$mysqli = mysqli_connect('localhost', 'root', '123456', 'test');
$sql = 'select * from country';
$res = mysqli_query($mysqli, $sql);
$file = fopen('./country.xls', 'w');
fwrite($file, "code\tname\tpopulation\t\n");
if(mysqli_num_rows($res) > 0) {
    while($row = mysqli_fetch_array($res)) {
        fwrite($file, $row['code']."\t".$row['name']."\t".$row['population']."\t\n");//这里写得不好，应该把所有文件内容组装到一个字符串中然后一次性写入文件。
    }
}
fclose($file);
echo 'http://www.jtw.com/....../country.xls';//这里返回文件路径给js