<?php
/**
 * Created by PhpStorm.
 * User: Microsoft Windows
 * Date: 25/07/2019
 * Time: 8:08 PM
 */

class Apps_Control_Item extends Apps_Class_Database
{
    protected $tableName = "tbl_item";
    protected $column = [
        "item_id" => "",
        "item_name" => "",
        "item_link" => ""
    ];
}