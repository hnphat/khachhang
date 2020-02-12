<?php
/**
 * Created by PhpStorm.
 * User: Microsoft Windows
 * Date: 18/10/2019
 * Time: 11:21 AM
 */
class Apps_Control_Vote extends Apps_Class_Database {
    protected $tableName = "tbl_vote";
    protected $column = [
        "vote_guest" => "",
        "vote_question" => "",
        "vote_point" => "",
        "vote_type" => ""
    ];

    public function writeVote($arrQuestion, $arrValue, $idUser, $type) {
        $cmds = [];
        $columnName = $this->getColumnName();
        $flag = true;

        for($i = 0; $i < count($arrValue);  $i++){
            $cmds[count($cmds)] = "INSERT INTO " . $this->tableName . "(" . $columnName[0] . ",". $columnName[1].",". $columnName[2].",". $columnName[3].") VALUE(" . $idUser . ",".$arrQuestion[$i].",".$arrValue[$i].",".$type.")";
        }

        foreach($cmds as $item){
            if (self::$connectInstance->query($item)){
                Apps_Class_Log::writeLogSuccess("writeVote ghi dữ liệu radio vote thành công vote.php");
            } else {
                Apps_Class_Log::writeLogFail("writeVote ghi dữ liệu radio vote thất bại vote.php");
                $flag = false;
            }
        }
        return $flag;
    }

}
?>