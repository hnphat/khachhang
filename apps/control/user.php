<?php

/**
 * Created by PhpStorm.
 * User: Microsoft Windows
 * Date: 11/08/2019
 * Time: 11:42 AM
 */
class Apps_Control_User extends Apps_Class_Database
{
    protected $tableName = "tbl_user";
    protected $column = [
        "user_id" => "",
        "user_name" => "",
        "user_fullname" => "",
        "user_password" => "",
        "user_permission" => "",
        "user_active" => ""
    ];
}

?>