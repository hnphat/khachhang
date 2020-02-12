<?php
/**
 * Created by PhpStorm.
 * User: Microsoft Windows
 * Date: 18/09/2019
 * Time: 1:52 PM
 */
class Apps_Control_Slide extends Apps_Class_Database {
    protected $tableName = "tbl_slide";
    protected $column = [
        "slide_id" => "",
        "slide_name" => "",
        "slide_image" => "",
        "slide_link" => "",
        "slide_pos" => ""
    ];

    function changeOrder($slideOrder){
        $txt = [];
        foreach ($slideOrder as $key => $value){
            $txt[] = "UPDATE ".$this->tableName." SET slide_pos = '".$value."' WHERE slide_id = '".$key."';";
        }
        foreach ($txt as $item) {
            try {
                self::$connectInstance->query($item);
                Apps_Class_Log::writeLogSuccess("changeOrder Đã cập nhật thứ tự Slide slide.php");
            } catch (Exception $ex) {
                Apps_Class_Log::writeLogFail("changeOrder Không thể cập nhật" . $ex->getMessage() . "slide.php");
            }
        }
    }
}
?>