<?php
/**
 * Main class to control to database. All class wanna connect and handle in database must be extends it
 * User: HNP
 * Date: 08/07/2019
 * Time: 10:39 AM
 */
class Apps_Class_Database
{
    protected $host;
    protected $user;
    protected $pass;
    protected $dataname;
    protected static $connectInstance;
    protected $tableName = "";
    protected $column = [];
    protected $valueColumn = [];
    protected $paramQuery = [
        "select" => "",
        "where" => "",
        "other" => ""
    ];

    public function __construct($host = 'localhost', $user = 'root', $pass = '', $dataname = 'khachhang')
    //public function __construct($host = '112.213.89.41', $user = 'hyundaia', $pass = 'Admin@2018', $dataname = 'hyundaia_khachhang')
    {
        if (self::$connectInstance == null) {
            try {
                self::$connectInstance = new mysqli($this->host = $host, $this->user = $user, $this->pass = $pass, $this->dataname = $dataname);
                $this->createTable(); // create all table for database if any
            } catch (Exception $ex) {
                echo "Error in Connect to Database " . $ex->getMessage();
                die();
            }
        }
    }

    public function getConnect(){
        return self::$connectInstance;
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function createTable()
    {
        $table = Apps_Class_Table::table;
        foreach ($table as $item) {
            try {
                self::$connectInstance->query($item);
            } catch (Exception $ex) {
                die('createTable() Error when create table in database.php' . $ex->getMessage());
            }
        }
    }

    public function checkConnect()
    {
        if (self::$connectInstance->connect_error) {
            die("Connection failed: " . self::$connectInstance->connect_error);
        }
        echo "Connected successfully";
    }

    /**
     * Convert value to safe value for server
     * @param $value
     * @return string
     */
    public function setSafeValue($value)
    {
        return htmlspecialchars(stripslashes($value));
    }

    public function setQuery($param = [])
    {
        $this->paramQuery['select'] = (isset($param['select'])) ? $this->setSafeValue($param['select']) : "";
        $this->paramQuery['where'] = (isset($param['where'])) ? $this->setSafeValue($param['where']) : 1;
        $this->paramQuery['other'] = (isset($param['other'])) ? $this->setSafeValue($param['other']) : "";
    }

    public function setParam($param = [])
    {
        if ($this->checkParam($param)) {
            $this->valueColumn = $param;
            foreach ($this->valueColumn as $key => $value) {
                $this->valueColumn[$key] = $this->setSafeValue($value);
            }
        } else Apps_Class_Log::writeLogFail("setParam giá trị truy vấn truyền vào query không hợp lệ database.php");
    }

    public function setParamWithCondition($param = [], $condition)
    {
        if ($this->checkParam($param)) {
            $this->valueColumn = $param;
            foreach ($this->valueColumn as $key => $value) {
                if ($key != $condition)
                    $this->valueColumn[$key] = $this->setSafeValue($value);
                else $this->valueColumn[$key] = $value;
            }
        } else Apps_Class_Log::writeLogFail("setParamWithCondition giá trị truy vấn truyền vào query không hợp lệ database.php");
    }

    public function checkParam($param = [])
    {
        $flag = true;
        foreach ($param as $key => $item) {
            if (isset($this->column[$key])) {
                continue;
            } else {
                $flag = false;
                break;
            }
        }
        return $flag;
    }

    public function queryData()
    {
        $sql_cmd = "select " . $this->paramQuery['select'] . " from " . $this->tableName . " where " . $this->paramQuery['where'] . " " . $this->paramQuery['other'];
        $result = self::$connectInstance->query($sql_cmd);
        if ($result) Apps_Class_Log::writeLogSuccess("queryData thực hiện lệnh truy vấn database.php - successfully!");
        else Apps_Class_Log::writeLogFail("queryData thực hiện lệnh truy vấn - kiểm tra lệnh truy vấn database.php");
        return $result;
    }

    public function queryWithCmd($cmd) {
        $result = self::$connectInstance->query($cmd);
        if ($result) Apps_Class_Log::writeLogSuccess("queryWithCmd thực hiện lệnh truy vấn database.php - successfully!");
        else Apps_Class_Log::writeLogFail("queryWithCmd thực hiện lệnh truy vấn - kiểm tra lệnh truy vấn database.php");
        return $result;
    }

    public function getNextRow($currentValue, $columnFind)
    {
        $result = self::$connectInstance->query("select * from ".$this->tableName." where ".$columnFind." > (select ".$columnFind." from ".$this->tableName." where ".$columnFind." = '".$currentValue."') order by ".$columnFind." asc limit 1");
        if ($result) {
            Apps_Class_Log::writeLogSuccess("getNextRow lấy hàng kế tiếp theo giá trị ".$currentValue." của cột ".$columnFind." database.php");
            return $result;
        }
        else {
            Apps_Class_Log::writeLogFail("getNextRow lấy hàng kế tiếp theo giá trị ".$currentValue." của cột ".$columnFind." database.php");
        }
    }

    public function getPreviousRow($currentValue, $columnFind)
    {
        $result = self::$connectInstance->query("select * from " . $this->tableName . " where " . $columnFind . " < (select " . $columnFind . " from " . $this->tableName . " where " . $columnFind . " = '" . $currentValue . "') order by " . $columnFind . " desc limit 1");
        $result = $this->queryData();
        if ($result) {
            Apps_Class_Log::writeLogSuccess("getPreviousRow lấy hàng trước đó theo giá trị " . $currentValue . " của cột " . $columnFind . " database.php");
            return $result;
        } else {
            Apps_Class_Log::writeLogFail("getPreviousRow lấy hàng trước đó theo giá trị " . $currentValue . " của cột " . $columnFind . " database.php");
        }
    }

    public function createData()
    {
        $column = "";
        $value = "";
        $count = 0;
        foreach ($this->valueColumn as $key => $_value) {
            $column .= $key;
            $value .= "'" . $_value . "'";
            $count++;
            if ($count != count($this->valueColumn)) {
                $column .= ",";
                $value .= ",";
            }
        }
        $sql_cmd = "INSERT INTO " . $this->tableName . "(" . $column . ") VALUE(" . $value . ")";
        return self::$connectInstance->query($sql_cmd);
    }

    public function getColumnName(){
        $columnName = [];
        foreach($this->column as $key => $value) {
            $columnName[count($columnName)] = $key;
        }
        return $columnName;
    }

    public function updateData()
    {
        $group = "";
        $count = 0;
        foreach ($this->valueColumn as $key => $value) {
            $group .= $key . "='" . $value . "'";
            $count++;
            if ($count != count($this->valueColumn)) {
                $group .= ",";
            }
        }
        $sql_cmd = "UPDATE " . $this->tableName . " SET " . $group . " WHERE " . $this->paramQuery["where"];
        return self::$connectInstance->query($sql_cmd);
    }

    public function deleteWithId()
    {
        $group = "";
        foreach ($this->valueColumn as $key => $value) {
            $group .= $key . "='" . $value . "'";
        }
        $sql_cmd = "DELETE FROM " . $this->tableName . " WHERE $group";
        return self::$connectInstance->query($sql_cmd);
    }

    public function deleteWithWhere()
    {
        $sql_cmd = "DELETE FROM " . $this->tableName . " WHERE " . $this->setSafeValue($this->paramQuery["where"]);
        return self::$connectInstance->query($sql_cmd);
    }

    /**
     * @param $query is query executed from command sql
     * @param $arr is list column name in table database
     * @return array|null
     */
    public function getResultFromSelectQuery($query)
    {
        $arr_temp = $this->column;
        $main_arr = [[]];
        $result = [[]];
        $main_arr[0] = $this->column;
        if ($query && $query->num_rows > 0) {
            while ($row = $query->fetch_assoc()) {
                foreach ($arr_temp as $key => $item) {
                    $arr_temp[$key] = $row[$key];
                }
                array_push($main_arr, $arr_temp);
            }
            $result[0] = $main_arr[1];
            for ($i = 2; $i < count($main_arr); $i++) {
                array_push($result, $main_arr[$i]);
            }
            Apps_Class_Log::writeLogSuccess("getResultFromSelectQuery trích suất dữ liệu database.php");
            return $result;
        }
        Apps_Class_Log::writeLogFail("getResultFromSelectQuery trích suất dữ liệu database.php");
        return null;
    }

    /**
     * With this function will auto query, the first setQuery
     * @param $column
     * @return array
     */
    public function getResultOnlyAColumn($column)
    {
        $arr = [];
        $data = $this->queryData();
        while ($row = $data->fetch_assoc()) {
            array_push($arr, $row[$column]);
        }
        Apps_Class_Log::writeFlowLog("getResultOnlyAColumn lấy tất cả giá trị của cột ".$column." database.php");
        return $arr;
    }

    public function getOneRow($arr = [])
    {
        if (isset($arr[0]) && $arr[0] != null) return $arr[0];
        Apps_Class_Log::writeLogFail("getOneRow lấy giá trị hàng duy nhất database.php");
        return null;
    }

    public function isExistRow($query) {
        if ($query->num_rows > 0) return true;
        return false;
    }

    public function copyRowWithoutUnique($condition = []){
        $element = "";
        $flag = false;
        $tem = 0;
        foreach($this->column as $key => $value){
            $flag2 = true;
            foreach ($condition as $key2 => $value2) {
                if ($key == $key2) {$flag2 = false; break;}
                $flag2 = true;
            }
            if ($flag2 == true) {
                if ($tem != 0 && $tem < (count($this->column) - 1))
                    $element .= ",";
                if ($flag == false) {$flag = true; continue;}
                $element .= $key;
            }
            $tem++;
        }
        $sql_cmd = "insert into ".$this->tableName."(".$element.") select ".$element." from ".$this->tableName." where ".$this->paramQuery['where'];
        Apps_Class_Log::writeFlowLog("copyRowWithoutUnique thực hiện copy một hàng theo ".$this->paramQuery['where']." của bảng " . $this->tableName . " có điều kiện loại trừ");
        return self::$connectInstance->query($sql_cmd);
    }

    public function copyRow(){
        $element = "";
        $flag = false;
        $tem = 0;
        foreach($this->column as $key => $value){
            if ($tem != 0 && $tem < (count($this->column) - 1))
                $element .= ",";
            if ($flag == false) {$flag = true; continue;}
            $element .= $key;
            $tem++;
        }
        $sql_cmd = "insert into ".$this->tableName."(".$element.") select ".$element." from ".$this->tableName." where ".$this->paramQuery['where'];
        Apps_Class_Log::writeFlowLog("copyRow thực hiện copy một hàng theo ".$this->paramQuery['where']." của bảng " . $this->tableName);
        return self::$connectInstance->query($sql_cmd);
    }
}

?>