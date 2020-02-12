<?php
/**
 * Created by PhpStorm.
 * User: Microsoft Windows
 * Date: 05/11/2019
 * Time: 9:32 AM
 */
include '../apps/autoload.php';
$item = new Apps_Control_Item();
if (isset($_GET['demo'])){
    $name = (isset($_GET['name'])) ? $_GET['name'] : null;
    $link = ($_GET['link'] != "") ? $_GET['link'] : "#";
    $param = [
        "item_name" => $name,
        "item_link" => $link
    ];
    if ($item->checkParam($param)) {
        $item->setParam($param);
        if ($item->createData()){

        }
    }
}
?>