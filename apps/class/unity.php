<?php
/**
 * Created by PhpStorm.
 * User: Microsoft Windows
 * Date: 14/07/2019
 * Time: 8:13 PM
 */

class Apps_Class_Unity
{
    public function vn_to_str($str)
    {
        $unicode = array(
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd' => 'đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D' => 'Đ',
            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
            '' => "\"|”|“"
        );
        foreach ($unicode as $nonUnicode => $uni) {
            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        }
        $str = str_replace(' ', '-', $str);
        return $str;
    }

    public function getTheFirstLink($link)
    {
        $arr = explode("-", $link);
        $txt = "";
        for ($i = 0; $i < count($arr); $i++) {
            if ($i != (count($arr) - 1)) {
                ($i != 0) ? $txt .= "-" : "";
                $txt .= $arr[$i];
            }
        }
        return $txt;
    }

    public function getTheSecondLink($link)
    {
        $arr = explode("-", $link);
        return $arr[count($arr) - 1];
    }

    public function getStringFromNumber($str)
    {
        $result = "";
        for ($i = 0; $i < strlen($str); $i++) {
            if (is_numeric($str[$i]))
                continue;
            else $result .= $str[$i];
        }
        return $result;
    }

    public function getNumberFromString($str)
    {
        $result = "";
        for ($i = 0; $i < strlen($str); $i++) {
            if (is_numeric($str[$i]))
                $result .= $str[$i];
            else continue;
        }
        return (int)$result;
    }

    public function getStringFromUrl($str)
    {
        return ucfirst(str_replace("-", " ", $this->getTheFirstLink($str)));
    }

    public function getActualLink()
    {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }
}