<?php
/**
 * Created by PhpStorm.
 * User: 14665
 * Date: 2018/9/26
 * Time: 17:15
 */
require_once "db.php";
$sql = "select gfmc,id,kprq from record  GROUP BY gfMc order by kprq desc ";
$result = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($result);