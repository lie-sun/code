<?php
/**
 * Created by PhpStorm.
 * User: 14665
 * Date: 2018/9/25
 * Time: 13:52
 */
/**
 * $dsn = "mysql:host=bj-cdb-h6phle00.sql.tencentcdb.com:63057;dbname=invoice";
 * $user = "root";
 * $password = "chenyu111";
 * $db = new PDO($dsn, $user, $password);
 */

//$dsn = "mysql:host=localhost:3306;dbname=invoice";
$dsn = "mysql:host=bj-cdb-h6phle00.sql.tencentcdb.com:63057;dbname=invoice";
//$user = "root";
//$password = "";
$user = "root";
$password = "chenyu111";
$db = new PDO($dsn, $user, $password);
$db->exec('SET NAMES utf8');
