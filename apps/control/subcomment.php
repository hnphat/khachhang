<?php
/**
 * Created by PhpStorm.
 * User: Microsoft Windows
 * Date: 16/08/2019
 * Time: 8:34 PM
 */
class Apps_Control_Subcomment extends Apps_Class_Database {
    protected $tableName = "tbl_subcomment";
    protected $column = [
        "subcomment_id" => "",
        "subcomment_date" => "",
        "subcomment_user" => "",
        "subcomment_comment" => "",
        "subcomment_email" => "",
        "subcomment_content" => "",
        "subcomment_active" => ""
    ];
}
?>