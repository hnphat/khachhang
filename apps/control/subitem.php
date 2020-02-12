<?php
/**
 * Created by PhpStorm.
 * User: Microsoft Windows
 * Date: 25/07/2019
 * Time: 8:10 PM
 */

class Apps_Control_Subitem extends Apps_Class_Database
{
    protected $tableName = "tbl_subitem";
    protected $column = [
        "subitem_id" => "",
        "subitem_name" => "",
        "subitem_link" => "",
        "item_id" => ""
    ];

    function checkHaveItem($value,$arr){
        for($i = 0; $i < count($arr); $i++){
            if ($value == $arr[$i]['item_id'])
                return true;
        }
        return false;
    }
}