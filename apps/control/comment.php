<?php

/**
 * Created by PhpStorm.
 * User: Microsoft Windows
 * Date: 16/08/2019
 * Time: 8:32 PM
 */
class Apps_Control_Comment extends Apps_Class_Database
{
    protected $tableName = "tbl_comment";
    protected $column = [
        "comment_id" => "",
        "comment_date" => "",
        "comment_user" => "",
        "comment_topic" => "",
        "comment_email" => "",
        "comment_content" => "",
        "comment_active" => ""
    ];
}

?>