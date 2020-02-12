<?php
/**
 * Created by PhpStorm.
 * User: Microsoft Windows
 * Date: 12/07/2019
 * Time: 7:37 PM
 */
date_default_timezone_set('Asia/Ho_Chi_Minh');

class Apps_Class_Log
{
    const _FILE_PATH = '';
    const FAIL = "<span style='color: red; font-weight:bold;'>Fail</span>";
    const SUCCESS = "<span style='color: green; font-weight:bold;'>Success</span>";

    public static function writeLogSuccess($content = "")
    {
        $log = "[" . date("d-m-Y") . "][" . date("h:i:s") . "] " . self::SUCCESS . " : " . $content . PHP_EOL;
        if (file_exists(Apps_Class_Log::_FILE_PATH . 'log.txt'))
            file_put_contents(Apps_Class_Log::_FILE_PATH . 'log.txt', $log, FILE_APPEND);
        else
            file_put_contents(Apps_Class_Log::_FILE_PATH . 'log.txt', $log, FILE_APPEND);
    }

    public static function writeLogFail($content = "")
    {
        $log = "[" . date("d-m-Y") . "][" . date("h:i:s") . "] " . self::FAIL . " : " . $content . PHP_EOL;
        if (file_exists(Apps_Class_Log::_FILE_PATH . 'log.txt'))
            file_put_contents(Apps_Class_Log::_FILE_PATH . 'log.txt', $log, FILE_APPEND);
        else
            file_put_contents(Apps_Class_Log::_FILE_PATH . 'log.txt', $log, FILE_APPEND);
    }

    public static function moveTo($url)
    {
        echo "<script>window.open('" . $url . "','_self');</script>";
    }

    public static function writeFlowLog($flow)
    {
        $log = "[" . date("d-m-Y") . "][" . date("h:i:s") . "] <span style='color: blue; font-weight:bold;'>Flow</span> : " . $flow . PHP_EOL;
        file_put_contents(Apps_Class_Log::_FILE_PATH . 'log.txt', $log, FILE_APPEND);
    }
}