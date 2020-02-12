<?php

/**
 * Created by PhpStorm.
 * User: Microsoft Windows
 * Date: 16/08/2019
 * Time: 8:43 PM
 */
class Apps_Control_Info extends Apps_Class_Database
{
    protected $tableName = "tbl_info";
    protected $column = [
        "info_id" => "",
        "info_date" => "",
        "info_user" => "",
        "info_email" => "",
        "info_address" => "",
        "info_phone" => "",
        "info_content" => "",
        "info_type" => "",
    ];
}

?>