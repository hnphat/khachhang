<?php
/**
 * Created by PhpStorm.
 * User: Microsoft Windows
 * Date: 18/10/2019
 * Time: 8:42 AM
 */
class Apps_Control_Question extends Apps_Class_Database {
    protected $tableName = "tbl_question";
    protected $column = [
        "question_id" => "",
        "question_content" => "",
        "question_type" => "",
        "question_user" => ""
    ];
}
?>