<?php
/**
 * Created by PhpStorm.
 * User: Microsoft Windows
 * Date: 11/08/2019
 * Time: 8:20 PM
 */
class Apps_Control_Topic extends Apps_Class_Database {
    protected $tableName = "tbl_topic";
    protected $column = [
        "topic_id" => "",
        "topic_date" => "",
        "topic_title" => "",
        "topic_src" => "",
        "topic_desc" => "",
        "topic_content" => "",
        "topic_picture" => "",
        "topic_active" => "",
        "topic_view" => "",
        "topic_showads" => ""
    ];

    public function changeBlock($active, $id) {
        $act = ($active == 1) ? 0 : 1;
        $param = [
            "topic_active" => $act
        ];
        $query = [
            "topic_id" => $id
        ];
        $this->setParam($param);
        $this->setQuery($query);
        if ($this->updateData()) Apps_Class_Log::writeLogSuccess("changeBlock đã thay đổi trạng thái active topic.php");
        else Apps_Class_Log::writeLogFail("changeBlock thay đổi trạng thái active không thành công, kiểm tra lại tham số truyền topic.php");
    }
}
?>